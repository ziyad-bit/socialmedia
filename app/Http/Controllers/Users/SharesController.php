<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShareRequest;
use App\Models\Shares;
use Illuminate\Support\Facades\Auth;

class SharesController extends Controller
{
    public function store(ShareRequest $request)
    {
        $data=['post_id'=>$request->post_id,'user_id'=>Auth::id()];
        
        $share=Shares::where($data)->first();
        if ($share) {
            return response()->json(['error'=>'you shared this post before'],404);
        }

        Shares::create($data);
        return response()->json(['success'=>'you shared this post successfully']);
    }
}
