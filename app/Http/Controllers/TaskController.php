<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Status;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller implements HasMiddleware
{

public static function middleware(): array
{
    return [

new Middleware('permission:task_create',only: ['create', 'store']),
new Middleware('permission:task_edit', only: ['edit', 'update']),
new Middleware('permission:task_delete', only: ['destroy']),
new Middleware('permission:task_manipulation', only: ['complete','updateStatus']),
new Middleware('permission:task_assign', only: ['processAssignment','assign']),



    ];
}


    public function index()
    {
        $statuses = Status::all();
    $users = User::all();
 $tasks = Task::with(['assignee', 'creator', 'status'])
                ->orderByPriority()
                ->get();
    return view('Task.index', compact('statuses', 'users','tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
           $statuses = Status::all();
    $users = User::all();

    return view('Task.create', compact('statuses', 'users'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status_id' => 'required|exists:statuses,id',
        'assigned_to' => 'nullable|exists:users,id',
        'priority' => 'required|in:low,medium,high',
        'created_at' => 'nullable|date',
        'completed_at' => 'nullable|date',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $validated['created_by'] = auth()->id();
    $validated['created_at'] = $validated['created_at'] ?? now();

    if ($request->hasFile('image')) {
        try {
            $imagePath = $request->file('image')->store('task_images', 'public');
            $validated['image'] = $imagePath;
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()])
                ->withInput();
        }
    }

    try {
        Task::create($validated);
        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    } catch (\Exception $e) {
        return redirect()->back()
            ->withErrors(['error' => 'Failed to create task: ' . $e->getMessage()])
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
    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        $statuses = Status::all();
        $users = User::all();

        return view('Task.edit', compact('task', 'statuses', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, $id)
{
    $task = Task::findOrFail($id);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status_id' => 'required|exists:statuses,id',
        'assigned_to' => 'nullable|exists:users,id',
        'priority' => 'required|in:low,medium,high',
        'created_at' => 'nullable|date',
        'completed_at' => 'nullable|date',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'remove_image' => 'nullable|boolean' 
    ]);

    if ($request->has('remove_image')) {
        if ($task->image) {
            Storage::disk('public')->delete($task->image);
        }
        $validated['image'] = null;
    } elseif ($request->hasFile('image')) {
        try {
            if ($task->image) {
                Storage::disk('public')->delete($task->image);
            }
            
            $imagePath = $request->file('image')->store('task_images', 'public');
            $validated['image'] = $imagePath;
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()])
                ->withInput();
        }
    } else {
        unset($validated['image']);
    }

    try {
        $task->update($validated);
        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    } catch (\Exception $e) {
        return redirect()->back()
            ->withErrors(['error' => 'Failed to update task: ' . $e->getMessage()])
            ->withInput();
    }
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);

        // Delete the image if it exists
        if ($task->image) {
            Storage::disk('public')->delete($task->image);
        }

        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }

   public function updateStatus(Request $request, Task $task)
{
    $request->validate([
        'status_id' => 'required|exists:statuses,id'
    ]);

    $task->update([
        'status_id' => $request->status_id
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Task status updated successfully',
        'task' => $task->fresh() 
    ]);

    
}



public function assign(Task $task)
{
    $users = User::where('id', '!=', auth()->id())->get();
    return view('Task.assign', compact('task', 'users'));
}

public function complete(Task $task)
{
    $task->update([
        'status_id' => Status::where('name', 'Completed')->first()->id,
        'completed_at' => now()
    ]);
    return redirect()->route('tasks.index')
        ->with('success', 'Task marked as completed successfully!');}
public function processAssignment(Request $request, Task $task)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id'
    ]);

    $task->update([
        'assigned_to' => $validated['user_id'],
        'assigned_at' => now(),
        // 'status_id' => Status::where('name', 'Assigned')->first()->id
    ]);

    return redirect()->route('tasks.index')
        ->with('success', 'Task assigned successfully!');
}
}
