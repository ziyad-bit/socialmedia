<?php

namespace App\Http\Controllers\Users;

use App\Classes\GetGroupAuth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Groups;
use App\Traits\GetPosts;
use App\Traits\GetFriends;
use App\Models\Group_users;
use App\Traits\GetPageCode;
use Illuminate\Http\Request;
use App\Http\Requests\GroupRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GroupsController extends Controller
{
    use GetPosts, GetFriends, GetPageCode;

    public function index_posts(Request $request,Groups $group)
    {
        $group_users_count = $group->group_users->count();
        $group_auth        = GetGroupAuth::getGroupAuth($group->id);

        $posts     = null;
        $page_code = null;

        if ($group_auth) {
            if ($group_auth->role_id != null || $group_auth->punish == Group_users::punished) {
                $friends_ids = $this->getFriends()->pluck('id')->toArray();
                $posts       = $this->getPosts($friends_ids)->where('group_id', $group->id)
                    ->orderBydesc('id')->cursorPaginate(3);
        
                $page_code = $this->getPageCode($posts);
        
                if ($request->has('agax')) {
                    $view = view('users.posts.index_posts', compact('posts', 'page_code'))->render();
                    return response()->json(['view' => $view, 'page_code' => $page_code]);
                }
            }
        }

        return view('users.groups.show', compact('posts', 'group','group_users_count','group_auth', 'page_code'));
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
