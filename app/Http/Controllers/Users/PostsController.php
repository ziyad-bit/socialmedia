<?php

namespace App\Http\Controllers\Users;

use App\Classes\Friends\FriendsIds;
use App\Classes\Posts\PostsAbstractFactory;
use App\Classes\Posts\PostsPage;
use App\Models\Posts;
use App\Traits\{Shared_posts_ids, GetPageCode, UploadFile, UploadImage};
use Illuminate\Http\{JsonResponse,Request};
use App\Http\Controllers\Controller;
use App\Http\Requests\PostsRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    use  Shared_posts_ids , UploadImage ,UploadFile , GetPageCode;

    ##################################      index_posts      ###############################
    public function index_posts(Request $request):View|JsonResponse
    {
        $friends     = new FriendsIds();
        $friends_ids = $friends->fetchIds();
        array_unshift($friends_ids,Auth::id());

        $shared_posts_id = $this->getSharedPostsIds($friends_ids);

        $posts_factory = new PostsAbstractFactory;
        $posts         = $posts_factory->postsPage()->fetchPosts($friends_ids,null,$shared_posts_id)->simplePaginate(3);
        
        if ($request->ajax()) {
            $view=view('users.posts.index_posts',compact('posts'))->render();
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
    public function update(PostsRequest $request,Posts $post):JsonResponse
    {
        $this->authorize('update_or_delete',$post);

        $photo=$post->photo;
        if ($request->file('photo')) {
            $photo=$request->file('photo');
            $photo=$this->uploadPhoto($photo,'images/posts',560);
        }

        $file=$post->file;
        if ($request->file('file')) {
            $file=$request->file('file');
            $file=$this->uploadFile($file,'images/files');
        }

        $video=$post->video;
        if ($request->file('video')) {
            $video=$request->file('video');
            $video=$this->uploadFile($video,'images/videos');
        }
        
        $post->update([
            'photo'   => $photo,
            'file'    => $file,
            'video'   => $video,
            'text'    => $request->text,
        ]);

        return response()->json(['success'=>'you updated it successfully','post'=>$post]);
    }

    ##################################      destroy      ###############################
    public function destroy(Posts $post):JsonResponse
    {
        $this->authorize('update_or_delete',$post);
        $post->delete();

        return response()->json(['success_msg'=>'you deleted it successfully']);
    }
}
