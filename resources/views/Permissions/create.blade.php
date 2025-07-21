@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Permissions') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('permissions.store') }}" method="POST">
                        @csrf
                        <div>
                            <label class="text-lg font-medium">Permissions</label>
                            <div class="my-3">
                                <select name="names[]" id="permissionss" multiple 
                                        class="border-indigo-100 shadow-sm w-1/2 rounded-lg ring-indigo-400">
                                    <option value="task_create">Task Create</option>
                                    <option value="task_edit">Task Edit</option>
                                    <option value="task_delete">Task Delete</option>
                                    <option value="task_view">Task View</option>
                                      <option value="task_manipulation">Task Manipulation</option>

                                      <option value="task_assign">Task Assign</option>

                                    <option value="user_create">User Create</option>
                                    <option value="user_edit">User Edit</option>
                                    <option value="user_delete">User Delete</option>
                                    <option value="user_view">User View</option>
                                    <option value="role_create">Role Create</option>
                                    <option value="role_edit">Role Edit</option>
                                    <option value="role_delete">Role Delete</option>
                                    <option value="role_view">Role View</option>
                                    <option value="permission_create">Permission Create</option>
                                    <option value="permission_edit">Permission Edit</option>
                                    <option value="permission_delete">Permission Delete</option>
                                    <option value="permission_view">Permission View</option>
                                    
                                </select>
                                @error('names')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-800 shadow-md transition duration-150 ease-in-out">
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script>
            $(document).ready(function() {
                $('#permissionss').select2({
                    placeholder: "Select permissions",
                    allowClear: true,
                    width: '50%'
                });
            });
        </script>
    @endpush
@endsection