<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Session;

class MessageController extends Controller
{
   public function index()
{
    $userId = session('user_id');
    $isClient = session('is_client');

    if ($isClient) {
        // CLIENT: Can message only one admin (we’ll pick the first admin from the DB)
        $admin = User::where('role', 'admin')->first(); // you can change 'admin' if needed

        if (!$admin) {
            return view('message', ['conversations' => []]);
        }

        $messages = Message::where(function ($q) use ($userId, $admin) {
            $q->where('client_id', $userId)->where('user_id', $admin->id);
        })->orWhere(function ($q) use ($userId, $admin) {
            $q->where('client_id', $userId)->where('user_id', $admin->id);
        })->orderBy('created_at')->get();

        $lastMessage = $messages->last();

        $conversations = [
            [
                'id' => $admin->id,
                'name' => $admin->name,
                'recipient_type' => 'user',
                'last_message' => optional($lastMessage)->message,
                'last_message_time' => optional($lastMessage)->created_at?->diffForHumans(),
                'messages' => $messages,
            ]
        ];
    } else {
        // ADMIN/USER: Can message all clients
        $conversations = Client::with(['messages' => function ($q) use ($userId) {
            $q->where('user_id', $userId);
        }])->get()->map(function ($client) use ($userId) {
            $lastMessage = $client->messages->last();
            return [
                'id' => $client->id,
                'name' => $client->name,
                'recipient_type' => 'client',
                'last_message' => optional($lastMessage)->message,
                'last_message_time' => optional($lastMessage)->created_at?->diffForHumans(),
                'messages' => $client->messages,
            ];
        });
    }

    return view('message', compact('conversations'));
}

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'recipient_id' => 'required|integer',
            'recipient_type' => 'required|in:user,client',
        ]);

        $isClient = session('is_client');
        $senderType = $isClient ? 'client' : 'user';

        $message = new Message([
            'message' => $request->message,
            'sender_type' => $senderType,
        ]);

        if ($isClient) {
            $message->client_id = session('user_id');
            $message->user_id = $request->recipient_id;
        } else {
            $message->user_id = session('user_id');
            $message->client_id = $request->recipient_id;
        }

        $message->save();

        return back()->with('success', 'Message sent.');
    }
}
