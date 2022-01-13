<?php

namespace App\Http\Controllers\Admins;

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
        $this->middleware(adminMiddleware());
    }

    ####################################      index      ################################
    public function index():View
    {
        $groups=Groups::selection()->where('trans_lang',default_lang())->cursorPaginate(pagination);
        return view('admins.groups.index',compact('groups'));
    }

    ####################################      create      ################################
    public function create():View
    {
        $languages=Languages::select('abbr')->get();
        return view('admins.groups.create',compact('languages'));
    }

    ####################################      store      ################################
    public function store(GroupRequest $request):RedirectResponse
    {
        try{
            $group=$request->group;

            $defualt_group = $this->get_data_in_default_lang($group);
            $photo_name    = $this->uploadphoto($request , 'images/groups');

            DB::beginTransaction();

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
    
            $othergroups=$this->get_data_in_Other_langs($group);
    
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

    ####################################      show      ################################
    public function show(int $id):View|RedirectResponse
    {
        $group=Groups::select('trans_of','id')->findOrfail($id);

        if ($group->trans_of != 0) {
            $group=Groups::findOrfail($group->trans_of);
        }
        
        $lang_diff=$this->langs_diff($group);

        if ($lang_diff == []) {
            return redirect()->route('groups.index')->with('success','all languages are added');
        }

        return view('admins.groups.show',compact('lang_diff','group'));
    }

    ####################################      add lang      ################################
    public function add_lang(int $id , GroupRequest $request):RedirectResponse
    {
        $group=(array)$request->group;
        $group=Groups::findOrfail($id);

        Groups::create([
            'trans_lang'  => $request->abbr,
            'trans_of'    => $id,
            'name'        => $group['name'],
            'description' => $group['description'],
            'photo'       => $group->photo,
            'status'      => $group->status,
            'admin_id'    => Auth::id(),
        ]);

        return redirect()->back()->with(['success'=>'you added new language successfully for this group']);
    }

    ####################################      edit      ################################
    public function edit(int $id):View
    {
        $group=Groups::with('groups')->selection()->findOrfail($id);

        if ($group->trans_of != 0) {
            $group=Groups::with('groups')->selection()->findOrfail($group->trans_of);
        }

        return view('admins.groups.edit',compact('group'));
    }

    ####################################      update      ################################
    public function update(GroupRequest $request,int $id):RedirectResponse
    {
        $group         = Groups::findOrfail($id);
        $request_group = array_values($request->group);

        $group->update([
            'name'        => $request_group[0]['name'],
            'description' => $request_group[0]['description'],
        ]);

        return redirect()->back()->with(['success'=>__('messages.you updated it successfully')]);
    }

    ####################################      change      ################################
    public function change(GroupRequest $request,int $id):RedirectResponse
    {
        $group      = Groups::findOrfail($id);
        if ($group->trans_of != 0) {
            $group=Groups::findOrfail($group->trans_of);
        }

        $groups_ids = $group->groups->pluck('id')->toArray();
        array_push($groups_ids,$id);

        if ($request->photo) {
            $photo_name   = $this->uploadphoto($request , 'images/groups');
            Groups::whereIn('id',$groups_ids)->update([
                    'photo'  => $photo_name,
                    'status' => $request->status
                ]);
        }else{
            Groups::whereIn('id',$groups_ids)->update([
                'status'=>$request->status
            ]);
        }
        
        return redirect()->back()->with(['success'=>__('messages.you updated it successfully')]);
    }

    ####################################      destroy      ################################
    public function destroy(int $id):RedirectResponse
    {
        $group      = Groups::findOrfail($id);
        $group->delete();

        return redirect()->back()->with(['success'=>__('messages.you deleted it successfully')]);
    }
}
