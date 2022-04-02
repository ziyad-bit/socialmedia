<?php

namespace App\Http\Controllers\Users;

use App\Events\StoreSearches;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Models\{User,Groups,Searches};
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    #######################################    index    #####################################
    public function index(SearchRequest $request):View|JsonResponse
    {
        $search=$request->search;
        
        $users = User::with(['auth_add_friends:id','friends_add_auth:id'])->selection()
            ->notAuth()->search($search)->paginate(4);

        $groups = Groups::min_selection()->search($search)->paginate(4);
        
        $next_page=true;
        if (!$groups->hasMorePages() && !$users->hasMorePages()) {
            $next_page=false;
        }

        if ($request->has('agax')) {
            $view = view('users.search.next_search', compact('users', 'groups'))->render();
            return response()->json(['view' => $view,'next_page'=>$next_page]);
        }else{
            $request->flash();
            event(new StoreSearches($search));
        }

        return view('users.search.index', compact('users', 'groups'));
    }

    #######################################    show    #####################################
    //show matched results under search input
    public function show(SearchRequest $request):JsonResponse
    {
        $search = $request->search;
        
        $users  = User::selection()->notAuth()->search($search)->limit(4)->get();
        $groups = Groups::min_selection()->defaultLang()->search($search)->limit(4)->get();
        
        return response()->json(['users' => $users,'groups'=>$groups]);
    }

    #######################################    show_recent    #####################################
    public function show_recent():JsonResponse
    {
        $recent_searches=Searches::selection()->where('user_id',Auth::id())->limit(5)
            ->orderByDesc('id')->get();

        return response()->json(['recent_searches' => $recent_searches]);
    }
}
