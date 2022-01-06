<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    private $role;
    private $permission;
    function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
        $this->middleware('permission:roles-list', ['only' => ['index','show']]);
        $this->middleware('permission:roles-create', ['only' => ['create','store']]);
        $this->middleware('permission:roles-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:roles-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->role->with('permissions')->paginate(10);
        return view('tenant.dashboard.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = $this->permission->get();
        return view('tenant.dashboard.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = $this->role->create(['name' => $request->name]);
        $role->syncPermissions($request->input('permission'));
        return redirect()->route('roles.index')->with('toast_success', trans('system.role_created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!$role = $role = $this->role->find($id))
            return redirect()->route('dashboard');
        $permissions = $this->permission->get();
        return view('tenant.dashboard.roles.edit', compact('role', 'permissions'));
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
        if(!$role = $role = $this->role->find($id))
            return redirect()->route('dashboard');
        $role->update($request->all());
        $role->syncPermissions($request->input('permission'));
        return redirect()->back()->with('toast_success', trans('system.role_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!$role = $this->role->find($id))
            return redirect()->route('dashboard');
        $role->delete();
        return redirect()->back()->with('toast_success', trans('system.role_deleted'));
    }
}
