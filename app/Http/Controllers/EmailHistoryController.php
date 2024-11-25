<?php

namespace App\Http\Controllers;

use App\Models\EmailHistory;
use Illuminate\Http\Request;

class EmailHistoryController extends Controller
{
    public function getAll()
    {
        $email_histories = EmailHistory::all();

        return response()->json($email_histories);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email_receiver_id' => 'required|exists:email_receivers,id',
            'title' => 'required|string',
            'text' => 'required|string',
            'status' => 'required|string',
        ]);

        $history = EmailHistory::create($validated);
        return response()->json($history, 201);
    }

    public function destroy($id)
    {
        $history = EmailHistory::findOrFail($id);
        $history->delete();

        return back()->with('success', 'Riwayat email berhasil dihapus.');
    }
}
