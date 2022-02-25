<?php

namespace App\Http\Controllers\Users;

use App\Models\Likes;
use App\Http\Requests\LikesRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LikesController extends Controller
{
    public function store(LikesRequest $request):JsonResponse
    {
        $like_arr=['user_id'=>Auth::id(),'post_id'=>$request->post_id];

        $like=Likes::where($like_arr)->first();

        if ($like) {
            $like->delete();
        }else{
            Likes::create($like_arr);
        }

        return response()->json();
    }
}
