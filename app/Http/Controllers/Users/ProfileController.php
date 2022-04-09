<?php

namespace App\Http\Controllers\Users;

use App\Classes\Friends\{FriendsIds,Friends};
use App\Classes\Posts\PostsAbstractFactory;
use App\Traits\{GetFriends, GetPageCode,UploadImage};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\{Hash,Auth};

class ProfileController extends Controller
{
    use GetFriends ,UploadImage , GetPageCode;

    ##################################     index      #################################
    public function index(Request $request)
    {
        $friends       = new FriendsIds();
        $friends_ids   = $friends->fetchIds();
        $friends_count = count($friends_ids);

        array_unshift($friends_ids,Auth::id());

        $posts_factory = new PostsAbstractFactory();
        $posts         = $posts_factory->profilePage()->fetchPosts($friends_ids)->cursorPaginate(3);
        
        $page_code = $this->getPageCode($posts);
        
        if ($request->ajax()) {
            $view = view('users.posts.index_posts', compact('posts','page_code'))->render();
            return response()->json(['view' => $view,'page_code'=>$page_code]);
        }

        return view('users.profile.index',compact('posts','page_code','friends_count'));
    }

    ##################################     show      #################################
    public function show(Request $request)
    {
        $friends_ob = new Friends();
        $friends    = $friends_ob->fetch();

        if ($request->has('agax')) {
            return response()->json(['friends' => $friends]);
        }

        return view('users.profile.show',compact('friends'));
    }

    ##################################     update      #################################
    public function update(UsersRequest $request)
    {
        $user = Auth::user();
        $data = $request->except('old_password','password','photo_id');

        if ($request->password) {
            $data=$data+['password'=>Hash::make($request->password)];
        }

        $user->update($data);
        unset($user->photo ,$user->created_at ,$user->id,$user->updated_at,$user->email_verified_at);

        return response()->json(['success'=>'you updated it successfully','user'=>$user]);
    }

    ##################################     update_photo      #################################
    public function update_photo(UsersRequest $request)
    {
        $photo = $this->uploadPhoto($request->file('photo'),'images/users/',null,292);

        Auth::user()->update(['photo'=>$photo]);

        return response()->json(['success'=>'you updated it successfully','photo'=>$photo]);
    }
}
