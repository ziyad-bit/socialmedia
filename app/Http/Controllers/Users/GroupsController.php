<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequest;
use App\Models\Groups;
use App\Traits\GetFriends;
use App\Traits\GetPageCode;
use App\Traits\GetPosts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupsController extends Controller
{
    use GetPosts, GetFriends, GetPageCode;

    public function index_posts(int $id, Request $request)
    {
        $groups  = Groups::min_selection()->withCount('group_users')
                ->with(['group_users'=>fn($q)=>$q->where('user_id',Auth::id())])
                ->where('id',$id)->get();

        $friends_ids = $this->getFriends()->pluck('id')->toArray();
        $posts       = $this->getPosts($friends_ids)->where('group_id', $id)->orderBydesc('id')
                        ->cursorPaginate(3);

        $page_code = $this->getPageCode($posts);

        if ($request->has('agax')) {
            
            $view = view('users.posts.index_posts', compact('posts', 'page_code'))->render();
            return response()->json(['view' => $view, 'page_code' => $page_code]);
        }

        return view('users.groups.show', compact('posts', 'groups', 'page_code'));
    }

    public function store(GroupRequest $request)
    {

    }

    public function show(int $id)
    {

    }

    public function update(GroupRequest $request, Groups $groups)
    {
        //
    }

    public function destroy(Groups $groups)
    {
        //
    }
}
