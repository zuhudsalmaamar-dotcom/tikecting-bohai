<?php

namespace App\Http\Controllers;

use App\Models\TicketComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketCommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'comment' => 'required|string',
        ]);

        TicketComment::create([
            'ticket_id' => $request->ticket_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}