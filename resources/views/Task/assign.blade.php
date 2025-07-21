@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Assign Task</h1>
            <a href="{{ route('tasks.index') }}" class="text-indigo-600 hover:text-indigo-800">
                Back to Tasks
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6 border border-gray-200">
            <h2 class="text-xl font-semibold mb-2">{{ $task->title }}</h2>
            <p class="text-gray-600 mb-4">{{ $task->description }}</p>
            <div class="flex items-center space-x-4 text-sm">
                <span class="px-2 py-1 rounded-full 
                    @if($task->priority == 'high') bg-red-100 text-red-800
                    @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-800
                    @else bg-green-100 text-green-800 @endif">
                    {{ ucfirst($task->priority) }} priority
                </span>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('tasks.assign', $task->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="user_id">
                        Assign to User
                    </label>
                    <select name="user_id" id="user_id" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select a user</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" 
                                @if($task->assigned_to == $user->id) selected @endif>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                <div class="flex justify-end">
                    <button type="submit" 
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        Assign Task
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection