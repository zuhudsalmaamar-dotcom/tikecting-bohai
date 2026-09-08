<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Base Query berdasarkan Role
        $ticketQuery = Ticket::query();
        if ($user->role === 'user') {
            $ticketQuery->where('user_id', $user->id);
        }

        // Hitung Ringkasan Data Status
        $totalTickets      = (clone $ticketQuery)->count();
        $openTickets       = (clone $ticketQuery)->where('status', 'open')->count();
        $inProgressTickets = (clone $ticketQuery)->where('status', 'in_progress')->count();
        $resolvedTickets   = (clone $ticketQuery)->where('status', 'resolved')->count();
        $closedTickets     = (clone $ticketQuery)->where('status', 'closed')->count();

        // Data Grafik Per Kategori
        $categories     = Category::all();
        $categoryLabels = [];
        $categoryData   = [];

        foreach ($categories as $category) {
            $categoryLabels[] = $category->name;
            $catQuery         = Ticket::where('category_id', $category->id);

            if ($user->role === 'user') {
                $catQuery->where('user_id', $user->id);
            }

            $categoryData[] = $catQuery->count();
        }

        // 5 Tiket Terbaru untuk Tabel Dashboard
        $recentTickets = (clone $ticketQuery)->with(['category', 'user'])->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalTickets',
            'openTickets',
            'inProgressTickets',
            'resolvedTickets',
            'closedTickets',
            'categoryLabels',
            'categoryData',
            'recentTickets'
        ));
    }
}