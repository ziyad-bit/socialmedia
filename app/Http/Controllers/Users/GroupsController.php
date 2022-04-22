<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Events\StoreGroupOwner;
use App\Classes\Friends\Friends;
use App\Classes\Group\GetGroupAuth;
use App\Http\Requests\GroupRequest;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\{Group_users,Groups};
use Illuminate\Support\Facades\Auth;
use App\Traits\{UploadImage,GetPageCode};
use App\Classes\Posts\PostsAbstractFactory;
use App\Traits\GetGroupAuth as TraitsGetGroupAuth;
use Illuminate\Http\{RedirectResponse,JsonResponse};

class GroupsController extends Controller
{
    use GetPageCode,UploadImage,TraitsGetGroupAuth;

    public function __construct()
    {
        $this->middleware(userMiddleware());
    }
    
    #################################    index_posts   ###################################
    public function index_posts(Request $request, Groups $group):View|JsonResponse
    {
        $group_users_count = Groups::whereHas('group_users',fn($q)=>$q->where('role_id','!=',null))->count();
        $group_auth        = GetGroupAuth::getGroupAuth($group->id);

        $posts     = null;
        $page_code = null;
        
        if ($group_auth) {
            if ($group_auth->role_id != null || $group_auth->punish == Group_users::punished) {
                $friends     = new Friends();
                $friends_ids = $friends->fetchIds(Auth::id());
                
                $posts_factory = new PostsAbstractFactory();
                $posts         = $posts_factory->groupPage()->fetchPosts(3,$friends_ids,[],$group->id);

                $page_code = $this->getPageCode($posts);
                $posts     = $posts->map(function($posts){
                        $posts->shares = $posts->shares->take(3);
                        return $posts;
                    });

                if ($request->ajax()) {
                    $view = view('users.posts.index_posts', compact('posts'))->render();
                    return response()->json(['view' => $view, 'page_code' => $page_code]);
                }
            }
        }

        return view('users.groups.show', compact('posts', 'group', 'group_users_count', 'group_auth', 'page_code'));
    }

    #################################    index_groups   ###################################
    public function index_groups(Request $request):View|JsonResponse
    {
        $groups_joined = Groups::selection()->whereHas('group_users', fn($q) => $q->where("user_id", Auth::id()))
            ->cursorPaginate(10);

        $page_code = $this->getPageCode($groups_joined);

        if ($request->ajax()) {
            $view = view('users.posts.index_posts', compact('posts', 'page_code'))->render();
            return response()->json(['view' => $view, 'page_code' => $page_code]);
        }

        return view('users.groups.index', compact('groups_joined'));
    }

    #################################      create    ###################################
    public function create():View
    {
        return view('users.groups.create');
    }

    #################################    store   ###################################
    public function store(GroupRequest $request):RedirectResponse
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

    #################################     update    ###################################
    public function update(GroupRequest $request, Groups $group):JsonResponse
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

        return response()->json(['success'=>__('messages.you updated it successfully')]);
    }

    #################################     delete    ###################################
    public function destroy(Groups $group):RedirectResponse
    {
        $group_auth=$this->getGroupAuth($group->id);
        $this->authorize('owner',$group_auth);

        $group->delete();
        return redirect()->route('groups.index_groups')->with(['success'=>__('messages.you deleted it successfully')]);
    }
}
