<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role:admin', only: ['index', 'create', 'store', 'edit', 'update', 'destroy']),
            new Middleware('permission:permission_create', only: ['create', 'store']),
            new Middleware('permission:permission_edit', only: ['edit', 'update']),
            new Middleware('permission:permission_delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()


    {
        $permissions = Permission::orderBy('created_at', 'desc')->paginate(10);
             return view('Permissions.list',compact('permissions'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
     return view('Permissions.create');

    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'names' => 'required|array|min:1',
        'names.*' => 'required|string|unique:permissions,name|min:3',
    ]);

    if ($validator->passes()) {
        foreach ($request->names as $name) {
            Permission::create([
                'name' => $name,
                'guard_name' => 'web' 
            ]);
        }
        
        return redirect()->route('permissions.index')
               ->with('success', 'Permissions created successfully.');
    } else {
        return redirect()->back()
               ->withErrors($validator)
               ->withInput();
    }
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
    public function edit( $id)
    {
        $permission=Permission::findOrFail($id);
        return view('Permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
         $validator=Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name,'.$id.',id',
        ]);
if ($validator->passes()) {
$permission->name = $request->name;
            $permission->save();
    return redirect()->route('permissions.index')->with('success', 'Permission Updated successfully.');
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
