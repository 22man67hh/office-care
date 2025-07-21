<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role:admin', only: ['index', 'create', 'store', 'edit', 'update', 'destroy']),
            new Middleware('permission:role_create', only: ['create', 'store']),
            new Middleware('permission:role_edit', only: ['edit', 'update']),
            new Middleware('permission:role_delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('created_at', 'desc')->paginate(10);
        return view('roles.list', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions=Permission::OrderBy('name','ASC')->get();
        return view('roles.create',[
            'permissions' => $permissions
        
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|unique:roles,name',
        'permissions' => 'nullable|array',
        'permissions.*' => 'exists:permissions,id', 
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $role = Role::create([
        'name' => $request->name,
    ]);

    if (!empty($request->permissions)) {
        $validPermissions = Permission::whereIn('id', $request->permissions)
            ->pluck('name')
            ->toArray();

        $role->syncPermissions($validPermissions); 
    }

    return redirect()
        ->route('roles.index')
        ->with('success', 'Role created successfully');
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roles = Role::findOrFail($id);
        $permissions = Permission::orderBy('name', 'ASC')->get();
        $assignedPermissions = $roles->permissions->pluck('id')->toArray();

        return view('roles.edit', compact('roles', 'permissions', 'assignedPermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $role->name = $request->name;
        $role->save();

        $permissions=$request->permissions ?? [];
        $permissionName= Permission::whereIn('id', $permissions)
            ->pluck('name')
            ->toArray();
        $role->syncPermissions($permissionName);
        return redirect()
            ->route('roles.index')
            ->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
