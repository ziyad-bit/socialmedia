<?php

namespace App\Http\Controllers\Users;

use App\Models\Posts;
use App\Traits\Friends_ids;
use Illuminate\Http\Request;
use App\Traits\Shared_posts_ids;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostsRequest;
use App\Traits\UploadImage;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    use Friends_ids , Shared_posts_ids , UploadImage;

    public function index_posts(Request $request)
    {
        $friends_ids     = $this->getFriendsIds();
        $shared_posts_id = $this->getSharedPostsIds($friends_ids);

        $friends_posts=Posts::withCount(['comments','likes','shares'])
                    ->with(['users'=>fn($q)=>$q->selection() ,'likes'=>fn($q)=>$q->where('user_id',Auth::id()),
                        'shares'=>fn($q)=>$q->whereIn('user_id',$friends_ids)->with(['users'=>fn($q)=>$q->selection()])])
                    ->whereIn('user_id',$friends_ids)->orWhereIn('id',$shared_posts_id)->latest()
                    ->paginate(3);

        if ($request->has('agax')) {
            $view=view('users.posts.index_posts',compact('friends_posts'))->render();
            return response()->json(['view'=>$view]);
        }
        
        return view('users.posts.index',compact('friends_posts'));
    }

    public function store(PostsRequest $request)
    {
        $photo=$request->file('photo');
        if ($photo) {
            $photo=$this->uploadphoto($photo,'images/posts');
        }

        $file=$request->file('file');
        if ($file) {
            $file=$this->uploadphoto($file,'images/files');
        }

        $video=$request->file('video');
        if ($video) {
            $video=$this->uploadphoto($video,'images/videos');
        }
        
        Posts::create([
            'user_id' => Auth::id(),
            'photo'   => $photo,
            'file'    => $file,
            'video'   => $video,
            'text'    => $request->text,
        ]);

        return response()->json(['success'=>'you created it successfully']);
    }

    public function update(Request $request, $id)
    {
        //
    }

  
    public function destroy(Posts $user_post)
    {
        $this->authorize('update_or_delete',$user_post);
        $user_post->delete();

        return response()->json(['success_msg'=>'you deleted it successfully']);
    }
}
