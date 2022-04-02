<?php

namespace App\Http\Controllers\Users;

use App\Models\Groups;
use App\Traits\GetPosts;
use App\Models\Languages;
use App\Events\StoreGroup;
use App\Traits\GetFriends;
use App\Models\Group_users;
use App\Traits\GetPageCode;
use Illuminate\Http\Request;
use App\Classes\GetGroupAuth;
use App\Events\StoreGroupOwner;
use App\Http\Requests\GroupRequest;
use App\Http\Controllers\Controller;
use App\Traits\GetGroupAuth as TraitsGetGroupAuth;
use App\Traits\GetLanguages;
use App\Traits\UploadImage;
use Illuminate\Support\Facades\Auth;

class GroupsController extends Controller
{
    use GetPosts, GetFriends, GetPageCode,GetLanguages,UploadImage,TraitsGetGroupAuth;

    #################################    index_posts   ###################################
    public function index_posts(Request $request, Groups $group)
    {
        $group_users_count = $group->group_users->count();
        $group_auth = GetGroupAuth::getGroupAuth($group->id);

        $posts = null;
        $page_code = null;

        if ($group_auth) {
            if ($group_auth->role_id != null || $group_auth->punish == Group_users::punished) {
                $friends_ids = $this->getFriends()->pluck('id')->toArray();
                $posts = $this->getPosts($friends_ids)->where('group_id', $group->id)
                    ->orderBydesc('id')->cursorPaginate(3);

                $page_code = $this->getPageCode($posts);

                if ($request->has('agax')) {
                    $view = view('users.posts.index_posts', compact('posts', 'page_code'))->render();
                    return response()->json(['view' => $view, 'page_code' => $page_code]);
                }
            }
        }

        return view('users.groups.show', compact('posts', 'group', 'group_users_count', 'group_auth', 'page_code'));
    }

    #################################    index_groups   ###################################
    public function index_groups(Request $request)
    {
        $groups_joined = Groups::selection()->whereHas('group_users', fn($q) => $q->where("user_id", Auth::id()))
            ->cursorPaginate(10);

        $page_code = $this->getPageCode($groups_joined);

        if ($request->has('agax')) {
            $view = view('users.posts.index_posts', compact('posts', 'page_code'))->render();
            return response()->json(['view' => $view, 'page_code' => $page_code]);
        }

        return view('users.groups.index', compact('groups_joined'));
    }

    #################################      create    ###################################
    public function create()
    {
        return view('users.groups.create');
    }

    #################################    store   ###################################
    public function store(GroupRequest $request)
    {
        try{
            $photo_name=$this->uploadPhoto($request->file('photo'),'images/groups/',300);

            $group=Groups::create($request->except('photo')+['photo'=>$photo_name]);
            event(new StoreGroupOwner($group->id));

            return redirect()->back()->with(['success'=>__('messages.you created it successfully')]);
        }catch(\Exception){
            return redirect()->back()->with(['error'=>__('messages.something went wrong')]);
        }
    }

    public function show(int $id)
    {

    }

    public function update(GroupRequest $request, Groups $group)
    {
        $group_auth=$this->getGroupAuth($group->id);
        $this->authorize('owner',$group_auth);

        $photo=$request->file('photo');
        if (!$photo) {
            $photo_name=$group->photo;
        }else{
            $photo_name=$this->uploadPhoto($photo,'images/groups/',300);
        }

        $group->update($request->except(['photo','photo_id'])+['photo'=>$photo_name]);

        return response()->json(['success'=>'you updated it successfully','group'=>$group]);
    }

    public function destroy(Groups $group)
    {
        //
    }
}
