<?php

namespace App\Http\Controllers\Users;

use App\Models\Likes;
use App\Http\Requests\LikesRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LikesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    
    public function store(LikesRequest $request):JsonResponse
    {
        try {
            $like_arr=['user_id'=>Auth::id(),'post_id'=>$request->post_id];

            $like=Likes::where($like_arr)->first();
    
            if ($like) {
                $like->delete();
            }else{
                Likes::create($like_arr);
            }
    
            return response()->json();
        } catch (\Exception) {
            return response()->json(['error' => 'something went wrong'],500);
        }
    }
}
