<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Groups;
use App\Http\Requests\GroupRequest;
use App\Traits\GetFriends;
use App\Traits\GetPageCode;
use App\Traits\GetPosts;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    use GetPosts , GetFriends ,GetPageCode;

    public function index_posts(int $id,Request $request)
    {
        $group               = Groups::findOrFail($id);
        $group_members_count = $group->group_users->count();
        $friends_ids         = $this->getFriends()->pluck('id')->toArray();
        $posts               = $this->getPosts($friends_ids)->where('group_id',$id)
                ->orderBydesc('id')->cursorPaginate(3);
        
        $page_code = $this->getPageCode($posts);
        
        if ($request->has('agax')) {
            $view = view('users.posts.index_posts', compact('posts','page_code'))->render();
            return response()->json(['view' => $view,'page_code'=>$page_code]);
        }

        return view('users.groups.show',compact('posts','group','group_members_count','page_code'));
    }


    public function store(GroupRequest $request)
    {
        //
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
