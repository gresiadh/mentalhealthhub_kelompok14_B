<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\vendor\Chatify\MessagesController;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unreadMessages = MessagesController::getCountOfUnreadMessages(Auth::user()->id);
        $type = Auth::user()->type == '20' ? '10' : '20';
        $users = User::where('type', $type)->get();

        $reciever = null;

        return view('chat.index', compact('users', 'reciever'))->with('unreadMsg', $unreadMessages);
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $unreadMessages = MessagesController::getCountOfUnreadMessages(Auth::user()->id);
        $type = Auth::user()->type == '20' ? '10' : '20';
        $users = User::where('type', $type)->get();
        $reciever = $id;

        return view('chat.index', compact('reciever', 'users'))->with('unreadMsg', $unreadMessages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
                   'receiver_id' => 'required|exists:users,id',
                   'message' => 'nullable|string',
                   'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
               ]);

        $chat = new Chat();
        $chat->sender_id = Auth::id();
        $chat->receiver_id = $request->receiver_id;

        // Jika ada pesan teks
        if ($request->has('message')) {
            $chat->message = $request->message;
        }

        // Jika ada lampiran gambar
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filePath = $file->store('uploads/chats', 'public');
            $chat->attachment = $filePath;
        }

        $chat->save();

        return response()->json(['success' => true, 'chat' => $chat]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $receiverId
     * @return \Illuminate\Http\Response
     */
    public function chatResponse($receiverId)
    {
        $userId = Auth::id(); // Mendapatkan ID pengguna yang sedang login
        // dd($userId, $receiverId);
        // Mengambil pesan antara pengguna yang sedang login dan penerima
        $chats = Chat::where(function ($query) use ($userId, $receiverId) {
            $query->where('sender_id', $userId)->where('receiver_id', $receiverId);
        })
        ->orWhere(function ($query) use ($userId, $receiverId) {
            $query->where('sender_id', $receiverId)->where('receiver_id', $userId);
        })
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json($chats);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
