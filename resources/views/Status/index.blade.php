@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded shadow">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Task Statuses</h1>
        <a href="{{ route('statuses.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Add New</a>
    </div>

    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
    </div>
    @endif

    <table class="w-full border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 p-2">ID</th>
                <th class="border border-gray-300 p-2">Task Type</th>
                <th class="border border-gray-300 p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($statuses as $status)
            <tr>
                <td class="border border-gray-300 p-2 text-center">{{ $status->id }}</td>
                <td class="border border-gray-300 p-2">{{ $status->tasktype }}</td>
                <td class="border border-gray-300 p-2 text-center">
                    <a href="{{ route('statuses.edit', $status->id) }}" class="text-indigo-600 hover:underline mr-2">Edit</a>

                    <form action="{{ route('statuses.destroy', $status->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure to delete this status?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="3" class="text-center p-4">No statuses found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
