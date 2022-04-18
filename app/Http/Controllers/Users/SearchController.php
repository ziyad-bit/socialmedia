<?php

namespace App\Http\Controllers\Users;

use App\Classes\Search\{PaginateSearchFactory,GetSearchFactory};
use App\Events\StoreSearches;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Models\Searches;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware(userMiddleware());
    }
    
    #######################################    index    #####################################
    public function index(SearchRequest $request)//: View | JsonResponse
    {
        $search = $request->search;

        //factory method design pattern
        $search_factory = new PaginateSearchFactory($search , 4);

        $friends       = $search_factory->createSearch()->paginateFriends();
        $users         = $search_factory->createSearch()->paginateUsers();
        $groups_joined = $search_factory->createSearch()->paginateGroupsJoined();
        $groups        = $search_factory->createSearch()->paginateGroups();

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
    }

    #######################################    show    #####################################
    //show matched results under search input
    public function show(SearchRequest $request): JsonResponse
    {
        $search_factory = new GetSearchFactory($request->search , 3);

        $friends       = $search_factory->createSearch()->get_friends();
        $users         = $search_factory->createSearch()->getUsers();
        $groups_joined = $search_factory->createSearch()->getGroupsJoined();
        $groups        = $search_factory->createSearch()->getGroups();

        return response()->json(['users' => $users ,'friends'=> $friends ,'groups' => $groups ,'groups_joined' => $groups_joined]);
    }

    #######################################    show_recent    #####################################
    public function show_recent(): JsonResponse
    {
        $recent_searches = Searches::selection()->where('user_id', Auth::id())->limit(5)
            ->orderByDesc('id')->get();

        return response()->json(['recent_searches' => $recent_searches]);
    }
}
