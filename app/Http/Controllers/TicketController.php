<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Menampilkan daftar semua tiket + Filter & Search
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Ticket::with(['user', 'category', 'technician']);

        // Jika user biasa, hanya tampilkan tiket miliknya
        if ($user->role === 'user') {
            $query->where('user_id', $user->id);
        }

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('ticket_number', 'like', '%' . $request->search . '%')
                  ->orWhere('id', 'like', '%' . $request->search . '%');
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter prioritas
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $tickets = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('tickets.index', compact('tickets', 'categories'));
    }

    /**
     * Menampilkan form buat tiket baru
     */
    public function create()
    {
        if (Auth::user()->role !== 'user') {
            return redirect()->route('tickets.index')->with('error', 'Admin dan Teknisi tidak membuat tiket.');
        }

        $categories = Category::all();
        return view('tickets.create', compact('categories'));
    }

    /**
     * Menyimpan tiket baru ke database (Sudah dilengkapi Auto Generate Nomor Tiket)
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'user') {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'priority'    => 'required|in:low,medium,high',
            'description' => 'required|string',
            'attachment'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // GENERATE NOMOR TIKET OTOMATIS (Format: TCK-YYYYMMDD-0001)
        $today = date('Ymd');
        $lastTicket = Ticket::whereDate('created_at', now()->today())->latest()->first();
        $nextNumber = $lastTicket && $lastTicket->ticket_number ? ((int) substr($lastTicket->ticket_number, -4)) + 1 : 1;
        $ticketNumber = 'TCK-' . $today . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $ticket = new Ticket();
        $ticket->ticket_number = $ticketNumber; // Mengisi kolom ticket_number
        $ticket->user_id       = Auth::id();
        $ticket->title         = $validated['title'];
        $ticket->category_id   = $validated['category_id'];
        $ticket->priority      = $validated['priority'];
        $ticket->description   = $validated['description'];
        $ticket->status        = 'open';

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
            $ticket->attachment = $path;
        }

        $ticket->save();

        return redirect()->route('tickets.index')->with('success', 'Tiket pelaporan berhasil dikirim dengan nomor ' . $ticketNumber);
    }

    /**
     * Menampilkan detail tiket & opsi penugasan teknisi
     */
    public function show($id)
    {
        $ticket = Ticket::with(['user', 'category', 'technician', 'comments.user'])->findOrFail($id);

        // Validasi hak akses user
        if (Auth::user()->role === 'user' && $ticket->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak memiliki akses ke tiket ini.');
        }

        // Mengambil daftar teknisi & admin dari DB untuk pilihan dropdown
        $technicians = User::whereIn('role', ['technician', 'teknisi', 'admin'])->get();

        return view('tickets.show', compact('ticket', 'technicians'));
    }

    /**
     * Memperbarui Status, Penugasan Teknisi, dan Catatan Pengerjaan
     */
    public function updateStatus(Request $request, Ticket $ticket)
    {
        if (Auth::user()->role === 'user') {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'status'          => 'required|in:open,in_progress,resolved,closed',
            'technician_id'   => 'nullable',
            'technician_name' => 'nullable|string|max:255',
            'notes'           => 'nullable|string',
        ]);

        $technicianName = $request->technician_name;

        if ($request->filled('technician_id') && empty($technicianName)) {
            $techUser = User::find($request->technician_id);
            $technicianName = $techUser ? $techUser->name : null;
        }

        $ticket->status          = $request->status;
        $ticket->technician_id   = $request->technician_id ?: null;
        $ticket->technician_name = $technicianName;
        $ticket->notes           = $request->notes;
        $ticket->save();

        return redirect()->back()->with('success', 'Status tiket dan penugasan teknisi berhasil diperbarui!');
    }
}