<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        // Memisahkan nilai users_id_roles menjadi id user dan roles
        $users_id_roles = explode(',', $request->input('users_id_roles'));
        $user = $users_id_roles[0];
        $roles = $users_id_roles[1];

        // Cek roles
        if ($roles == ' USER') {
            // Klaw usernya belum ada maka buat message_code baru
            if (Chat::where('users_id', $user)->doesntExist()) {
                $message_code = 'MSG-' . rand(1000, 9999);
            } else {
                // Ambil message_code dari database
                $message_code = Chat::where('users_id', $user)->first()->message_code;
            }
        } else if ($roles == ' ADMIN') {
            // Ambil message_code dari request
            $message_code = $request->input('message_code');
        }

        $message = Chat::create([
            'message_code' => $message_code,
            'users_id' => $user,
            'message' => $request->input('message')
        ]);

        $user = User::find($user);
        // Jika message_code kosong create message_code baru
        if ($user->message_code == null) {
            $user->message_code = $message_code;
            $user->save();
        } else {
            // Update message_code
            $user->message_code = $message_code;
        }

        return response()->json([
            'status' => 'success',
            'data' => $message
        ]);
    }

    public function userChat($message_code)
    {
        // Ambil semua chat yang terkait dengan messe$message_code
        $chats = Chat::where('message_code', $message_code)
            ->get();

        // Kembalikan data dalam format JSON
        return response()->json([
            'chats' => $chats
        ]);
    }
}
