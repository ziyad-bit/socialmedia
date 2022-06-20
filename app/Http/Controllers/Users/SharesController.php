<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShareRequest;
use App\Models\{Posts,Shares};
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SharesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    
    ##################################      store      ###############################
    public function store(ShareRequest $request):JsonResponse
    {
        try {
            $post_id = $request->post_id;
            $data    = ['post_id'=>$post_id,'user_id'=>Auth::id()];
            
            $share = Shares::where($data)->first();
            if ($share) {
                return response()->json(['error'=>'you shared this post before'],422);
            }
    
            Shares::create($data);
    
            $post  = Posts::findOrFail($post_id);
            $share = true;
            $view  = view('users.posts.add_post',compact('post','share'))->render();
    
            return response()->json(['success'=>'you shared this post successfully','view'=>$view]);
        } catch (\Exception) {
            return response()->json(['error' => 'something went wrong'],500);
        }
    }
}
