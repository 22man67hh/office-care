@extends('layouts.app')
@section('header')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions/Edit') }}
        </h2>
@endsection
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('permissions.update',$permission->id) }} " method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="" class="text-lg font-medium">Name</label>
                            <div class="my-3">
<input placeholder="select permissions" type="text" class="border-indigo-100 shadow-sm w-1/2 rounded-lg ring-indigo-400"  name="name" id="" value="{{ old('name', $permission->name ?? '') }}">
@error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
    
@enderror
                            </div>
                            <button class=" px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-800 shadow-md transition duration-150 ease-in-out">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection