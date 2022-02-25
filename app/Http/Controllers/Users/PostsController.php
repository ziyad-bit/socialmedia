<?php

namespace App\Http\Controllers\Users;

use App\Models\Posts;
use App\Traits\{Shared_posts_ids,GetFriends, GetPosts, UploadFile, UploadImage};
use Illuminate\Http\{JsonResponse,Request};
use App\Http\Controllers\Controller;
use App\Http\Requests\PostsRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    use GetFriends , Shared_posts_ids , UploadImage ,UploadFile , GetPosts;

    ##################################      index_posts      ###############################
    public function index_posts(Request $request):View|JsonResponse
    {
        $friends_ids     = $this->getFriends()->pluck('id')->toArray();
        array_unshift($friends_ids,Auth::id());

        $shared_posts_id = $this->getSharedPostsIds($friends_ids);

        $posts=$this->getPosts($friends_ids)->whereIn('user_id',$friends_ids)
            ->orWhereIn('id',$shared_posts_id)->latest()->paginate(3);

        if ($request->has('agax')) {
            $view=view('users.posts.index_posts',compact('friends_posts'))->render();
            return response()->json(['view'=>$view]);
        }
        
        return view('users.posts.index',compact('posts'));
    }

    ##################################      store      ##################################
    public function store(PostsRequest $request):JsonResponse
    {
        $photo=$request->file('photo');
        if ($photo) {
            $photo=$this->uploadPhoto($photo,'images/posts/',560);
        }

        $file=$request->file('file');
        if ($file) {
            $file=$this->uploadFile($file,'images/files');
        }

        $video=$request->file('video');
        if ($video) {
            $video=$this->uploadFile($video,'images/videos');
        }
        
        $post=Posts::create([
            'user_id' => Auth::id(),
            'photo'   => $photo,
            'file'    => $file,
            'video'   => $video,
            'text'    => $request->text,
        ]);

        $share='';
        $view=view('users.posts.add_post',compact('post','share'))->render();
        return response()->json(['success'=>'you created it successfully','view'=>$view]);
    }

    ##################################      update      ###############################
    public function update(PostsRequest $request,Posts $user_post):JsonResponse
    {
        $this->authorize('update_or_delete',$user_post);

        $photo=$user_post->photo;
        if ($request->file('photo')) {
            $photo=$request->file('photo');
            $photo=$this->uploadPhoto($photo,'images/posts',560);
        }

        $file=$user_post->file;
        if ($request->file('file')) {
            $file=$request->file('file');
            $file=$this->uploadFile($file,'images/files');
        }

        $video=$user_post->video;
        if ($request->file('video')) {
            $video=$request->file('video');
            $video=$this->uploadFile($video,'images/videos');
        }
        
        $user_post->update([
            'photo'   => $photo,
            'file'    => $file,
            'video'   => $video,
            'text'    => $request->text,
        ]);

        return response()->json(['success'=>'you updated it successfully','post'=>$user_post]);
    }

    ##################################      destroy      ###############################
    public function destroy(Posts $user_post):JsonResponse
    {
        $this->authorize('update_or_delete',$user_post);
        $user_post->delete();

        return response()->json(['success_msg'=>'you deleted it successfully']);
    }
}
