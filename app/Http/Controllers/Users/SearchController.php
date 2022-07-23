<?php

namespace App\Http\Controllers\Users;

use App\Classes\Search\GetSearchFactory;
use App\Classes\Search\PaginateSearchFactory;
use App\Events\StoreSearches;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Models\Searches;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth', 'verified']);
	}

	//######################################    index    #####################################
	public function index(SearchRequest $request, PaginateSearchFactory $search_factory): View | JsonResponse | RedirectResponse
	{
		try {
			$search = $request->search;

			/** @var  \App\Classes\Search\PaginateSearch $search_ins */
			$search_ins = $search_factory->createSearch();

			$friends       = $search_ins->paginateFriends($search, 3);
			$users         = $search_ins->paginateUsers($search, 3);
			$groups_joined = $search_ins->paginateGroupsJoined($search, 3);
			$groups        = $search_ins->paginateGroups($search, 3);

			$next_page = true;
			if (!$groups->hasMorePages() && !$users->hasMorePages() && !$friends->hasMorePages() && !$groups_joined->hasMorePages()) {
				$next_page = false;
			}

			if ($request->ajax()) {
				$view = view('users.search.next_search', compact('users', 'groups', 'friends', 'groups_joined'))->render();

				return response()->json(['view' => $view, 'next_page' => $next_page]);
			} else {
				$request->flash();
				event(new StoreSearches($search));
			}

			return view('users.search.index', compact('users', 'groups', 'friends', 'groups_joined'));
		} catch (\Exception) {
			return redirect()->route('posts.index.all')->with('error', 'something went wrong');
		}
	}

	//######################################    show    #####################################
	//show matched results under search input
	public function show(SearchRequest $request, GetSearchFactory $search_factory): JsonResponse
	{
		try {
			$search = $request->search;

			/** @var  \App\Classes\Search\GetSearch $search_ins */
			$search_ins = $search_factory->createSearch();

			$friends       = $search_ins->get_friends($search, 3);
			$users         = $search_ins->getUsers($search, 3);
			$groups_joined = $search_ins->getGroupsJoined($search, 3);
			$groups        = $search_ins->getGroups($search, 3);

			return response()->json(['users' => $users, 'friends' => $friends, 'groups' => $groups, 'groups_joined' => $groups_joined]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}

	//######################################    show_recent    #####################################
	public function show_recent(): JsonResponse
	{
		try {
			$recent_searches = Searches::selection()->where('user_id', Auth::id())->limit(5)
			->orderByDesc('id')->get();

			return response()->json(['recent_searches' => $recent_searches]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}
}
