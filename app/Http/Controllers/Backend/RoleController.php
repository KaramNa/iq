<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:roles-create', ['only' => ['create','store']]);
        $this->middleware('can:roles-read',   ['only' => ['show', 'index']]);
        $this->middleware('can:roles-update',   ['only' => ['edit','update']]);
        $this->middleware('can:roles-delete',   ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        $roles =  Role::where(function($q)use($request){
            if($request->id!=null)
                $q->where('id',$request->id);
            if($request->q!=null)
                $q->where('name','LIKE','%'.$request->q.'%')->orWhere('display_name','LIKE','%'.$request->q.'%')->orWhere('description','LIKE','%'.$request->q.'%');
        })->orderBy('id','DESC')->paginate();
        return view('admin.roles.index',compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>"required|unique:roles,name",
            'display_name'=>"required|min:3",
        ]);
        $role = Role::create([
            'name'=>$request->name,
            'display_name'=>$request->display_name,
            'description'=>$request->description,
        ]);
        $role->syncPermissions($request->permissions);
        toastr()->success("تمت العملية بنجاح");
        return redirect()->route('admin.roles.index');
    }

    public function show(Request $request,Role $role)
    {
        $permissions = $role->permissions()->groupBy('table')->get();
        //dd($permissions);
        return view('admin.roles.show',compact('role','permissions'));
    }

    public function edit(Request $request,Role $role)
    {
        return view('admin.roles.edit',compact('role'));
    }

    public function update(Request $request,Role $role)
    {
        $request->validate([
            'name'=>"required|unique:roles,name,".$role->id,
            'display_name'=>"required|min:3",
        ]);
        $role->update([
            'name'=>$request->name,
            'display_name'=>$request->display_name,
            'description'=>$request->description,
        ]);
        $role->syncPermissions($request->permissions);
        toastr()->success("تمت العملية بنجاح");
        return redirect()->route('admin.roles.index');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        toastr()->success("تمت العملية بنجاح");
        return redirect()->route('admin.roles.index');
    }
}
