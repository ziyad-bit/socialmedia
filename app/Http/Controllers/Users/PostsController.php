<?php

namespace App\Http\Controllers\Users;

use App\Models\Posts;
use Illuminate\Http\Request;
use App\Classes\Friends\Friends;
use Illuminate\Http\JsonResponse;
use App\Classes\Group\GroupFactory;
use App\Http\Requests\PostsRequest;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Classes\Files\UploadAllFiles;
use Illuminate\Http\RedirectResponse;
use App\Classes\Posts\Posts as customPosts;
use App\Classes\Posts\PostsAbstractFactory;

class PostsController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth', 'verified']);
		$this->middleware(['throttle:6,1'])->only(['store']);
	}

	//#################################       index      ###############################
	public function index_posts(Request $request, Friends $friends, PostsAbstractFactory $posts_factory):View|JsonResponse| RedirectResponse
	{
		try {
			$auth_id     = Auth::id();
			$friends_ids = $friends->fetchIds($auth_id);
			$group_name  = true;

			array_unshift($friends_ids, $auth_id);

			$shared_posts_ids = customPosts::getSharedIds($friends_ids);
			$groupJoinedIds   = GroupFactory::factory('Group')->getJoinedIds($friends_ids);

			//abstract factory design pattern
			$posts = $posts_factory->postsPage()->fetchPosts(3, $friends_ids, $groupJoinedIds, null, $shared_posts_ids);

			if ($request->ajax()) {
				$view = view('users.posts.index_posts', compact('posts', 'group_name'))->render();

				return response()->json(['view' => $view]);
			}

			return view('users.posts.index', compact('posts', 'group_name'));
		} catch (\Exception) {
			return redirect()->route('posts.index.all')->with('error', 'something went wrong');
		}
	}

	//#################################      store      ##################################
	public function store(PostsRequest $request, UploadAllFiles $files):JsonResponse
	{
		try {
			$all_files  = $files->uploadAll($request);
			$group_name = false;

			$post = Posts::create([
				'user_id' => Auth::id(),
				'photo'   => $all_files['photo'],
				'file'    => $all_files['file'],
				'video'   => $all_files['video'],
			] + $request->validated());

			$share = '';

			$view = view('users.posts.add_post', compact('post', 'share', 'group_name'))->render();

			return response()->json(['success' => __('messages.you created it successfully'), 'view' => $view]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}

	//#################################      update      ###############################
	public function update(PostsRequest $request, Posts $post, UploadAllFiles $files):JsonResponse
	{
		try {
			$this->authorize('update_or_delete', $post);

			$all_files = $files->uploadAll($request, $post);

			$post->update([
				'photo' => $all_files['photo'],
				'file'  => $all_files['file'],
				'video' => $all_files['video'],
				'text'  => $request->text,
			]);

			return response()->json(['success' => __('messages.you updated it successfully'), 'post' => $post]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}

	//#################################      destroy      ###############################
	public function destroy(Posts $post):JsonResponse
	{
		try {
			$this->authorize('update_or_delete', $post);
			$post->delete();

			return response()->json(['success_msg' => __('messages.you deleted it successfully')]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}
}
