<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->get();

        return view('admin.messages.index', compact('messages'));
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        abort(404);
    }

    public function show(Message $message)
    {
        // Tandai pesan sebagai sudah dibaca
        if (!$message->is_read) {
            $message->update([
                'is_read' => true,
            ]);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function edit(Message $message)
    {
        abort(404);
    }

    public function update(Request $request, Message $message)
    {
        $validated = $request->validate([
            'is_read' => 'required|boolean',
        ]);

        $message->update($validated);

        return redirect()
            ->route('admin.messages.index')
            ->with('success', 'Status pesan berhasil diperbarui.');
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()
            ->route('admin.messages.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}
