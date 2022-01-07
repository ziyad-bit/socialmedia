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
        $this->middleware(adminMiddleware());
    }

    ####################################      index      ################################
    public function index():View
    {
        $languages=Languages::cursorPaginate(pagination);
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
    public function edit(int $id):View
    {
        $language=Languages::findOrfail($id);

        return view('admins.languages.edit',compact('language'));
    }

    ####################################      update      ###############################
    public function update(LanguagesRequest $request,int $id):RedirectResponse
    {
        $language=Languages::findOrfail($id);
        $language->update($request->validated());

        return redirect()->back()->with('success','you updated language successfully');
    }

    ####################################      destroy      ###############################
    public function destroy(int $id):RedirectResponse
    {
        $language=Languages::findOrfail($id);

        $language->delete();
        return redirect()->back()->with('success','you deleted language successfully');
    }
}
