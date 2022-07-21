<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comments;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CommentsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admins');
	}

	//###################################      index      ################################
	public function index():View
	{
		$comments = Comments::cursorPaginate(5);

		return view('admins.comment.index', compact('comments'));
	}

	//###################################      edit      ###############################
	public function edit(comments $admins_comment):View
	{
		return view('admins.comment.edit', compact('admins_comment'));
	}

	//###################################      update      ###############################
	public function update(CommentRequest $request, comments $admins_comment):RedirectResponse
	{
		$admins_comment->update($request->except('post_id'));

		return redirect()->back()->with('success', 'you updated it successfully');
	}

	//###################################      destroy      ###############################
	public function destroy(comments $admins_comment):RedirectResponse
	{
		$admins_comment->delete();

		return redirect()->back()->with('success', 'you deleted it successfully');
	}
}
