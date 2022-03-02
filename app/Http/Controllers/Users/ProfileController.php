<?php

namespace App\Http\Controllers\Users;

use App\Traits\{GetFriends, GetPageCode, GetPosts,UploadImage};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\{Hash,Auth};

class ProfileController extends Controller
{
    use GetPosts , GetFriends ,UploadImage , GetPageCode;

    ##################################     index      #################################
    public function index(Request $request)
    {
        $auth_id       = Auth::id();
        $friends_ids   = $this->getFriends()->pluck('id')->toArray();
        $friends_count = count($friends_ids);

        array_unshift($friends_ids,$auth_id);
        
        $posts=$this->getPosts($friends_ids)->where('user_id',$auth_id)->orderBydesc('id')
            ->cursorPaginate(3);
        
        $page_code = $this->getPageCode($posts);
        
        if ($request->has('agax')) {
            $view = view('users.posts.index_posts', compact('posts','page_code'))->render();
            return response()->json(['view' => $view,'page_code'=>$page_code]);
        }

        return view('users.profile.index',compact('posts','page_code','friends_count'));
    }

    ##################################     show      #################################
    public function show(Request $request)
    {
        $friends=$this->getFriends()->simplePaginate(4);

        if ($request->has('agax')) {
            return response()->json(['friends' => $friends]);
        }

        return view('users.profile.show',compact('friends'));
    }

    ##################################     update      #################################
    public function update(UsersRequest $request)
    {
        $user=Auth::user();
        $data=$request->except('old_password','password','photo_id');

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
        $user=Auth::user();
        $photo=$this->uploadPhoto($request->file('photo'),'images/users/',null,292);

        $user->update(['photo'=>$photo]);
        return response()->json(['success'=>'you updated it successfully','photo'=>$photo]);
    }
}
