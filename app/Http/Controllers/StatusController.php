<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class StatusController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role:admin', only: ['index', 'create', 'store', 'edit', 'update', 'destroy']),
            new Middleware('permission:status_create', only: ['create', 'store']),
            new Middleware('permission:status_edit', only: ['edit', 'update']),
            new Middleware('permission:status_delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $statuses = Status::all();
        return view('Status.index', compact('statuses'));
    }

    public function create()
    {
        return view('Status.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tasktype' => 'required|string|unique:statuses,tasktype',
        ]);

        Status::create($request->only('tasktype'));

        return redirect()->route('statuses.index')->with('success', 'Status created successfully.');
    }

    public function edit(Status $status)
    {
        return view('Status.edit', compact('status'));
    }

    public function update(Request $request, Status $status)
    {
        $request->validate([
            'tasktype' => 'required|string|unique:statuses,tasktype,' . $status->id,
        ]);

        $status->update($request->only('tasktype'));

        return redirect()->route('statuses.index')->with('success', 'Status updated successfully.');
    }

    public function destroy(Status $status)
    {
        $status->delete();
        return redirect()->route('statuses.index')->with('success', 'Status deleted successfully.');
    }

    public function show($id)
{
}

}
