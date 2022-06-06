<?php

namespace App\Http\Controllers\Admins;

use App\Events\StoreGroup;
use App\Models\{Languages,Groups};
use Illuminate\Support\Facades\{Auth,DB};
use App\Http\Requests\GroupRequest;
use App\Http\Controllers\Controller;
use App\Traits\{UploadImage,GetLanguages};
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class GroupsController extends Controller
{
    use GetLanguages , UploadImage;

    public function __construct()
    {
        $this->middleware('auth:admins' );
    }

    ####################################      index      ################################
    public function index():View
    {
        $groups=Groups::selection()->cursorPaginate(5);
        return view('admins.groups.index',compact('groups'));
    }

    ####################################      create      ################################
    public function create():View
    {
        return view('admins.groups.create');
    }

    ####################################      store      ################################
    public function store(GroupRequest $request):RedirectResponse
    {
        try{
            $photo_name = $this->uploadPhoto($request->file('photo'),'images/groups/',300);
            $is_admin   = true;

            event(new StoreGroup($request,$photo_name,$is_admin));

            return redirect()->back()->with(['success'=>__('messages.you created it successfully')]);
        }catch(\Exception){
            DB::rollback();
            return redirect()->back()->with(['error'=>__('messages.something went wrong')]);
        }
    }

    ####################################      edit      ################################
    public function edit(Groups $admins_group):View
    {
        return view('admins.groups.edit',compact('admins_group'));
    }

    ####################################      update      ################################
    public function update(GroupRequest $request,Groups $admins_group):RedirectResponse
    {
        $photo = $request->file('photo');
        if (!$photo) {
            $photo_name = $admins_group->photo;
        }else{
            $photo_name = $this->uploadPhoto($photo,'images/groups/',300);
        }

        $admins_group->update($request->except(['photo','photo_id'])+['photo'=>$photo_name]);

        return redirect()->back()->with(['success'=>__('messages.you updated it successfully')]);
    }

    ####################################      destroy      ################################
    public function destroy(Groups $admins_group):RedirectResponse
    {
        $admins_group->delete();

        return redirect()->back()->with(['success'=>__('messages.you deleted it successfully')]);
    }
}
