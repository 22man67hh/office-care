@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit User') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label class="text-lg font-medium"> Name</label>
                            <div class="my-3">
                                <input 
                                    type="text" 
                                    class="border-indigo-100 shadow-sm w-1/2 rounded-lg ring-indigo-400" 
                                    name="name" 
                                    value="{{ old('name', $user->name) }}"
                                    placeholder="Enter role name"
                                    required
                                >
                                @error('name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                             <label class="text-lg font-medium"> Email</label>
                            <div class="my-3">
                                <input 
                                    type="text" 
                                    class="border-indigo-100 shadow-sm w-1/2 rounded-lg ring-indigo-400" 
                                    name="email" 
                                    value="{{ old('email', $user->email) }}"
                                    placeholder="Enter Eamail"
                                    required
                                >
                                @error('email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="grid grid-cols-3 gap-3 mb-4">
                                <label class="col-span-3 text-lg font-medium">Roles</label>
                                @foreach($roles as $role)
                                    <div class="flex items-center">
                                        <input 
    {{-- {{ ($hasRoles->contains($role->id)) ? 'checked' : '' }} --}}
    {{ in_array($role->id, $hasRoles) ? 'checked' : '' }}
                                            type="checkbox" 
                                            name="role[]" 
                                            value="{{ $role->id }}" 
                                            id="role-{{ $role->id }}" 
                                            class="mr-2 rounded"
                                        >
                                        <label for="role-{{ $role->id }}" class="text-sm">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                                @error('role')
                                    <span class="text-red-500 text-sm col-span-3">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="flex space-x-4">
                                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-800 shadow-md transition duration-150 ease-in-out">
                                    Update 
                                </button>
                                <a href="{{ route('users.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 shadow-md transition duration-150 ease-in-out">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection