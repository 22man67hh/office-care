@extends('layouts.app')

@section('header')
<div class="flex justify-between "> 
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Users') }}
    </h2>
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
                     <th class="px-6 py-3 text-left">Email</th>
                     <th class="px-6 py-3 text-left">Roles</th>

                    <th class="px-6 py-3 text-left">Created</th>
                    <th class="px-6 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">

                @if ($users->isNotEmpty())
                    @foreach ($users as $permission)
                        <tr class="border-b">
                            <td class="px-6 py-3 text-left">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3 text-left">{{ $permission->name }}</td>
                            
                              <td class="px-6 py-3 text-left">{{ $permission->email }}</td>
                              <td class="px-6 py-3 text-left">{{ $permission->roles->pluck('name')->implode(', ') }}</td>

                            <td class="px-6 py-3 text-left">{{ $permission->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-3 text-center">
                                <a href="{{ route('users.edit', $permission->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form action="{{ route('users.destroy', $permission->id) }}" method="POST" class="inline-block">
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
{{ $users->links() }}
           </div>
        </div>
        </div>
    </div>
@endsection
