<?php

namespace App\Http\Controllers\Users;

use App\Traits\GetPosts;
use App\Traits\GetFriends;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequest;
use App\Models\User;
use App\Traits\UploadImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use GetPosts , GetFriends ,UploadImage;

    public function index_profile(Request $request)
    {
        $auth_id     = Auth::id();
        $friends_ids = $this->getFriends()->pluck('id')->toArray();
        array_unshift($friends_ids,$auth_id);
        
        $posts=$this->getPosts($friends_ids)->where('user_id',$auth_id)->orderBydesc('id')
            ->cursorPaginate(3);

        $page_code='';
        if ($posts->hasMorePages()) {
            $page_code = $posts->nextCursor()->encode();
        }

        if ($request->has('agax')) {
            $view = view('users.posts.index_posts', compact('posts','page_code'))->render();
            return response()->json(['view' => $view,'page_code'=>$page_code]);
        }

        return view('users.profile.index',compact('posts','page_code'));
    }

    public function create()
    {
        //
    }

    public function update_profile(UsersRequest $request)
    {
        $user=Auth::user();
        $data=$request->except('old_password','password','photo_id');

        if ($request->password) {
            $data=$data+['password'=>Hash::make($request->password)];
        }

        $user->update($data);
        unset($user->photo ,$user->created_at ,$user->id);

        return response()->json(['success'=>'you updated it successfully','user'=>$user]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update_photo(UsersRequest $request)
    {
        $user=User::findOrFail(Auth::id());
        $photo=$this->uploadPhoto($request->file('photo'),'images/users/',null,292);

        $user->update(['photo'=>$photo]);
        return response()->json(['success'=>'you updated it successfully','photo'=>$photo]);
    }

    public function destroy($id)
    {
        //
    }
}
