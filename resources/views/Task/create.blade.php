@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Create New Task For Office Care Nepal</h2>

    <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg shadow-md border border-green-300">
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-md border border-red-300">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{old('description')}}</textarea>
        </div>

        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">Upload Image (optional)</label>
            <input type="file" name="image" id="image"
                class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-indigo-50 file:text-indigo-700 file:rounded-md hover:file:bg-indigo-100" />
        </div>

        <div>
            <label for="status_id" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status_id" id="status_id" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @foreach ($statuses as $status)
                    <option value="{{ $status->id }}">{{ $status->tasktype }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
            <select name="priority" id="priority" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="low" {{ old('priority')=='low' ? 'selected':'' }}>Low</option>
                <option value="medium" selected>Medium</option>
                <option value="high" {{ old('priority')=='high' ? 'selected':'' }}>High</option>
            </select>
        </div>

        {{-- <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        
            <div>
                <label for="assigned_at" class="block text-sm font-medium text-gray-700">Created_At</label>
                <input type="hidde" name="created_at" id="created_at" value="{{ old('created_at') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div> --}}

        <input type="hidden" name="created_by" value="{{ auth()->user()->id }}"  />

        <div class="text-center">
            <button type="submit"
                class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 shadow-md transition duration-150 ease-in-out">
                Create Task
            </button>
        </div>
    </form>
</div>
@endsection