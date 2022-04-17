<?php

namespace App\Http\Controllers\Users;

use App\Models\Posts;
use App\Classes\Friends\Friends;
use App\Http\Requests\PostsRequest;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Classes\Files\UploadAllFiles;
use App\Classes\Posts\{SharedPosts,PostsAbstractFactory};
use Illuminate\Http\{JsonResponse,Request};

class PostsController extends Controller
{
    ##################################       index      ###############################
    public function index_posts(Request $request):View|JsonResponse
    {
        $auth_id     = Auth::id();
        $friends     = new Friends();
        $friends_ids = $friends->fetchIds($auth_id);

        array_unshift($friends_ids,$auth_id);

        $shared_posts_ids = SharedPosts::get_ids($friends_ids);

        //abstract factory design pattern
        $posts_factory = new PostsAbstractFactory;
        $posts         = $posts_factory->postsPage()->fetchPosts(3,$friends_ids,null,$shared_posts_ids);
        
        if ($request->ajax()) {
            $view=view('users.posts.index_posts',compact('posts'))->render();
            return response()->json(['view'=>$view]);
        }
        
        return view('users.posts.index',compact('posts'));
    }

    ##################################      store      ##################################
    public function store(PostsRequest $request):JsonResponse
    {
        $files     = new UploadAllFiles();
        $all_files = $files->uploadAll($request);
        
        $post=Posts::create([
            'user_id' => Auth::id(),
            'photo'   => $all_files['photo'],
            'file'    => $all_files['file'],
            'video'   => $all_files['video'],
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

        $files     = new UploadAllFiles();
        $all_files = $files->uploadAll($request,$post);
        
        $post->update([
            'photo'   => $all_files['photo'],
            'file'    => $all_files['file'],
            'video'   => $all_files['video'],
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
