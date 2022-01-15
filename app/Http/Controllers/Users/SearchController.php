<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Groups;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->has('search') ? $request->get('search') : null;
        if ($search != null) {
            $users = User::selection()->search($search)->paginate(7);
            $groups = Groups::select('name', 'description', 'photo')->where('trans_lang', default_lang())
                ->search($search)->paginate(4);

            if ($request->has('agax')) {
                $view = view('users.search.next_search', compact('users', 'groups'))->render();
                return response()->json(['view' => $view]);
            }
        }
        $request->flash();
        return view('users\search\index', compact('users', 'groups'));
    }

    public function show_matched_results(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
