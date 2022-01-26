<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Friends_user;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{

    public function index_friends(Request $request)
    {
        $friends_user = User::whereHas  ('friends_add_auth', fn($q) => $q->friends_add_auth())
                            ->orWhereHas('auth_add_friends', fn($q) => $q->auth_add_friends())
                            ->selection()->paginate(4);

        if ($request->has('agax')) {
            return response()->json(['friends_user' => $friends_user]);
        }

        return view('users.chat.index', compact('friends_user'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
