<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use Illuminate\Http\Request;
use App\Classes\Friends\Friends;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UsersRequest;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Auth};
use App\Traits\{GetPageCode,UploadImage};
use App\Classes\Posts\PostsAbstractFactory;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    use UploadImage , GetPageCode;

    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    ##################################     index auth profile    #################################
    public function index(Request $request, Friends $friends, PostsAbstractFactory $posts_factory):View|JsonResponse|RedirectResponse
    {
        try {
            $auth_id       = Auth::id();
            $friends_ids   = $friends->fetchIds($auth_id );
            $friends_count = count($friends_ids);

            $group_name    = false;

            array_unshift($friends_ids,$auth_id );

            $posts = $posts_factory->usersProfilePage()->fetchPosts(3,$friends_ids,[],null,[],$auth_id );
            
            $page_code = $this->getPageCode($posts);
            $posts     = $posts->map(function($posts){
                    $posts->shares = $posts->shares->take(3);
                    return $posts;
                });

            if ($request->ajax()) {
                $view = view('users.posts.index_posts', compact('posts' , 'group_name'))->render();
                return response()->json(['view' => $view,'page_code'=>$page_code]);
            }

            return view('users.profile.index',compact('posts','page_code','friends_count','group_name'));
        } catch (\Exception) {
            return redirect()->route('posts.index.all')->with('error','something went wrong');
        }
    }

    ##################################     show auth friends    #################################
    public function show(Request $request, Friends $friends):View|JsonResponse
    {
        try {
            $friends = $friends->fetch(Auth::id(),5);

            if ($request->ajax()) {
                $view=view('users.profile.show',compact('friends'))->render();
                return response()->json(['view' => $view]);
            }

            return view('users.profile.show',compact('friends'));
        } catch (\Exception) {
            return redirect()->route('posts.index.all')->with('error','something went wrong');
        }
    }

    ##################################     index user profile    #################################
    public function index_profile(Request $request, string $name , Friends $friends , PostsAbstractFactory $posts_factory):View|JsonResponse
    {
        try {
            $auth_id      = Auth::id();
            $name         = str_replace('-',' ',$name);
            $related_user = $friends->getProfileData($name);
            
            $group_name   = false;

            foreach ($related_user as  $user) {
                $user_friends_ids   = $friends->fetchIds($user->id);
                $mutual_friends_ids = $friends->fetchMutualIds($user->id);
                $mutual_friends_num = count($mutual_friends_ids);
                
                array_unshift($user_friends_ids,$auth_id);
        
                $posts         = $posts_factory->usersProfilePage()->fetchPosts(3,$mutual_friends_ids,[],null,[],$user->id);
            }

            $page_code = $this->getPageCode($posts);
            
            if ($request->ajax()) {
                $view = view('users.posts.index_posts', compact('posts'))->render();
                return response()->json(['view' => $view,'page_code'=>$page_code]);
            }

            return view('users.profile.index_user',compact('group_name','posts','page_code','mutual_friends_num','related_user'));
        } catch (\Exception) {
            return redirect()->route('posts.index.all')->with('error','something went wrong');
        }
    }

    ##################################     show user mutual friends    #################################
    public function show_friends(Request $request, string $name , Friends $friends):View|JsonResponse
    {
        try {
            $user               = User::where('name',$name)->firstOrFail();
            $mutual_friends     = $friends->fetchMutual($user->id,5);

            $page_code = $this->getPageCode($mutual_friends);

            if ($request->ajax()) {
                $view = view('users.profile.show_mutual_friends',compact('mutual_friends'))->render();
                return response()->json(['view' => $view,'page_code'=>$page_code]);
            }

            return view('users.profile.show_mutual_friends',compact('mutual_friends','page_code'));
        } catch (\Exception) {
            return redirect()->route('posts.index.all')->with('error','something went wrong');
        }
    }

    ##################################     update      #################################
    public function update(UsersRequest $request):JsonResponse
    {
        try {
            $user = Auth::user();
            $data = $request->except('old_password','password','photo_id');
    
            if ($request->password) {
                $data=$data+['password'=>$request->password];
            }
    
            $user->update($data);
            unset($user->photo ,$user->created_at ,$user->id,$user->updated_at,$user->email_verified_at);
    
            return response()->json(['success'=>__('messages.you updated it successfully') ,'user'=>$user]);
        } catch (\Exception) {
            return response()->json(['error' => 'something went wrong'],500);
        }
    }

    ##################################     update_photo      #################################
    public function update_photo(UsersRequest $request):JsonResponse
    {
        try {
            $photo = $this->uploadPhoto($request->file('photo'),'images/users/',null,292);

            Auth::user()->update(['photo'=>$photo]);
    
            return response()->json(['success'=>__('messages.you updated it successfully'),'photo'=>$photo]);
        } catch (\Exception) {
            return response()->json(['error' => 'something went wrong'],500);
        }
    }
}
