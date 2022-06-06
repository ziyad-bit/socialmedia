<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\LanguagesRequest;
use App\Models\Languages;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class LanguagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins' );
    }

    ####################################      index      ################################
    public function index():View
    {
        $languages=Languages::cursorPaginate(5);
        return view('admins.languages.index',compact('languages'));
    }

    ####################################      create      ################################
    public function create():View
    {
        return view('admins.languages.create');
    }

    ####################################      store      ###############################
    public function store(LanguagesRequest $request):RedirectResponse
    {
        Languages::create($request->validated());

        return redirect()->back()->with('success','you added language successfully');
    }

    ####################################      edit      ###############################
    public function edit(Languages $admins_language):View
    {
        return view('admins.languages.edit',compact('admins_language'));
    }

    ####################################      update      ###############################
    public function update(LanguagesRequest $request,Languages $admins_language):RedirectResponse
    {
        $admins_language->update($request->validated());

        return redirect()->back()->with('success','you updated language successfully');
    }

    ####################################      destroy      ###############################
    public function destroy(Languages $admins_language):RedirectResponse
    {
        $admins_language->delete();
        
        return redirect()->back()->with('success','you deleted language successfully');
    }
}
