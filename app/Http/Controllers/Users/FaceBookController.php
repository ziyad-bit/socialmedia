<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FaceBookController extends Controller
{
	public function __construct()
	{
		$this->middleware(['guest:web']);
	}

	//##############################      redirect      ##############################
	public function redirect()
	{
		return Socialite::driver('facebook')->redirect();
	}

	//##############################      callback      ##############################
	public function callback()
	{
		$facebook_user=Socialite::driver('facebook')->stateless()->user();

		$user=User::where('facebook_id', $facebook_user->id)->first();

		if (!$user) {
			$user=User::create([
				'name'=>$facebook_user->name,
				'email'=>$facebook_user->email,
				'facebook_id'=>$facebook_user->id,
				'email_verified_at'=>now(),
			]);
		}

		Auth::login($user);

		return redirect()->route('posts.index.all');
	}
}
