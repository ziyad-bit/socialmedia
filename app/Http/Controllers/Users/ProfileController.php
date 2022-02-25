<?php

namespace App\Http\Controllers\Users;

use App\Traits\GetPosts;
use App\Traits\GetFriends;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MembersRequest;
use App\Http\Requests\UsersRequest;
use App\Models\User;
use App\Traits\UploadImage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use GetPosts , GetFriends ,UploadImage;

    public function index_profile()
    {
        $auth_id     = Auth::id();
        $friends_ids = $this->getFriends()->pluck('id')->toArray();
        array_unshift($friends_ids,$auth_id);
        
        $posts=$this->getPosts($friends_ids)->where('user_id',$auth_id)->cursorPaginate(3);

        return view('users.profile.index',compact('posts'));
    }

    public function create()
    {
        //
    }

    public function update_profile(UsersRequest $request)
    {
        $user=User::findOrFail(Auth::id());
        if ($request->password) {
            $data=$request->except('old_password','photo_id');
        }else{
            $data=$request->except('old_password','password','photo_id');
        }

        $user->update($data);
        unset($user->photo);
        unset($user->created_at);

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
        $photo=$this->uploadPhoto($request->file('photo'),'images/users/',null,252);

        $user->update(['photo'=>$photo]);
        return response()->json(['success'=>'you updated it successfully','photo'=>$photo]);
    }

    public function destroy($id)
    {
        //
    }
}
