<?php

namespace App\Http\Controllers\Admins;

use App\Models\Groups;
use App\Models\Languages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\GroupRequest;
use App\Http\Controllers\Controller;
use App\Traits\GetLanguages;
use App\Traits\UploadImage;
use Illuminate\Support\Facades\Auth;

class GroupsController extends Controller
{
    use GetLanguages , UploadImage;

    public function __construct()
    {
        $this->middleware([ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]);
    }

    public function index()
    {
        $groups=Groups::selection()->where('trans_lang',default_lang())->cursorPaginate(pagination);
        return view('admins.groups.index',compact('groups'));
    }

    public function create()
    {
        $languages=Languages::select('abbr')->get();
        return view('admins.groups.create',compact('languages'));
    }

    public function store(GroupRequest $request)
    {
        try{
            DB::beginTransaction();

            $group=$request->group;

            $defualt_group = $this->getDefault($group);
            $photo_name    = $this->uploadphoto($request , 'images/groups');

            if (isset($defualt_group['name']) && isset($defualt_group['description'] ) ) {
                $defualt_group_id=Groups::insertGetId([
                    'trans_lang'  => $defualt_group['abbr'],
                    'name'        => $defualt_group['name'],
                    'description' => $defualt_group['description'],
                    'photo'       => $photo_name,
                    'status'      => $request->status,
                    'admin_id'    => Auth::id(),
                    'created_at'  => now(),
                ]);
            }else{
                return redirect()->back()->with('error','you should fill input in '.default_lang().'(default language)');
            }
    
            $othergroups=$this->getOther($group);
    
            if(isset($othergroups)){
                $othergroups_arr=[];
                foreach($othergroups as $othergroup){

                    $othergroups_arr[]=[
                        'trans_lang'  => $othergroup['abbr'],
                        'trans_of'    => $defualt_group_id,
                        'name'        => $othergroup['name'],
                        'description' => $othergroup['description'],
                        'photo'       => $photo_name,
                        'status'      => $request->status,
                        'admin_id'    => Auth::id(),
                        'created_at'  => now(),
                    ];
                }
                
                Groups::insert($othergroups_arr);
            }

            DB::commit();
            return redirect()->back()->with(['success'=>__('messages.you created group successfully')]);

        }catch(\Exception){
            DB::rollback();
            return redirect()->back()->with(['error'=>__('messages.something went wrong')]);
        }
    }

    public function edit(int $id)
    {
        $group=Groups::with('groups')->selection()->findOrfail($id);

        return view('admins.groups.edit',compact('group'));
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        //
    }
}
