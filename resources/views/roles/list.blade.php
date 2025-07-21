@extends('layouts.app')

@section('header')
<div class="flex justify-between "> 
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Roles') }}
    </h2>
    <a href="{{ route('roles.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-800 shadow-md transition duration-150 ease-in-out">Create Roles</a>
    </div>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
<x-message></x-message>

           <table class="w-full">
            <thead class="bg-indigo-50">
                <tr class="border-b">
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Name</th>
                     <th class="px-6 py-3 text-left">Permissions</th>

                    <th class="px-6 py-3 text-left">Created</th>
                    <th class="px-6 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">

                @if ($roles->isNotEmpty())
                    @foreach ($roles as $permission)
                        <tr class="border-b">
                            <td class="px-6 py-3 text-left">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3 text-left">{{ $permission->name }}</td>
                            
                              <td class="px-6 py-3 text-left">{{ $permission->permissions->pluck('name')->implode(',') }}</td>

                            <td class="px-6 py-3 text-left">{{ $permission->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-3 text-center">
                                <a href="{{ route('roles.edit', $permission->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form action="{{ route('roles.destroy', $permission->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    
                @endif
             
            </tbody>
           </table>
           <div class="my-3">
{{-- {{ $permissions->links() }} --}}
           </div>
        </div>
        </div>
    </div>
@endsection
