<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\FriendRequest;
use App\Models\Friends_user;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_requests(Request $request)
    {
        $friend_reqs = User::whereHas('friends_add', fn($q) => $q->where(['status' => 0, 'friend_id' => Auth::id()]))
            ->selection()->cursorPaginate(5);

        $page_code='';
        if ($friend_reqs->hasMorePages()) {
            $page_code = $friend_reqs->nextCursor()->encode();
        }

        if ($request->has('agax')) {
            $view = view('users.friends.next_requests', compact('friend_reqs'))->render();
            return response()->json(['view' => $view,'page_code'=>$page_code]);
        }

        return view('users.friends.index', compact('friend_reqs','page_code'));
    }

    public function store(FriendRequest $request)
    {
        Friends_user::create($request->validated() + ['user_id' => Auth::id()]);

        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
