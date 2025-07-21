@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-center animate-fade-in">Task Management Board</h1>
    
    <div class="bg-white p-4 rounded-lg shadow-md mb-6 animate-slide-down">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex-1 flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
                <div class="w-full md:w-1/3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filter by User</label>
                    <select id="user-filter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="w-full md:w-1/3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filter by Status</label>
                    <select id="status-filter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all">
                        <option value="">All Statuses</option>
                        @foreach($statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->tasktype }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="w-full md:w-1/3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filter by Date</label>
                    <input type="date" id="date-filter" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all">
                </div>
            </div>
            
            <div class="flex items-end">
                <button id="reset-filters" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-all">
                    Reset Filters
                </button>
            </div>
        </div>
    </div>

    <div class="flex justify-between items-center mb-6 animate-slide-down">
        <div class="flex space-x-4">
            <a href="{{ route('tasks.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 shadow-md transition-all hover:scale-105 transform">
                Create New Task
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg shadow-md border border-green-300 animate-fade-in">
        {{ session('success') }}
    </div>
    @endif

    <div id="task-board" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-{{ count($statuses) }} gap-4">
        @foreach($statuses as $status)
        <div class="bg-gray-50 rounded-lg p-4 shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300 animate-fade-in-up">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">{{ $status->tasktype }}</h2>
                <span class="bg-gray-200 px-2 py-1 rounded-full text-xs">{{ $status->tasks->count() }}</span>
            </div>
            
            <div 
                id="status-{{ $status->id }}" 
                class="min-h-[100px] space-y-3 status-column"
                data-status-id="{{ $status->id }}"
            >
                @foreach($status->tasks as $task)
                <div 
                    id="task-{{ $task->id }}" 
                    class="bg-white p-4 rounded-lg shadow cursor-move task-card hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1"
    draggable="{{ $status->tasktype !== 'Completed' ? 'true' : 'false' }}"
                    data-task-id="{{ $task->id }}"
                    data-user-id="{{ $task->creator->id }}"
                    data-status-id="{{ $status->id }}"
                    data-assigned-date="{{ \Carbon\Carbon::parse($task->created_at)->format('Y-m-d') }}"
    data-is-completed="{{ $status->tasktype === 'Completed' ? 'true' : 'false' }}"
                >
                    @if($task->image)
                    <div class="mb-3 overflow-hidden rounded-lg">
                        <img 
                            src="{{ asset('/storage/' . $task->image) }}" 
                            alt="Task image" 
                            class="w-full h-32 object-cover transition-all duration-500 hover:scale-105 transform"
                        >
                    </div>
                    @endif

                    <div class="flex justify-between items-start">
                        <h3 class="font-medium text-gray-800">{{ $task->title }}</h3>
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($task->priority == 'high') bg-red-100 text-red-800
                            @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-800
                            @else bg-green-100 text-green-800 @endif">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </div>
                    
                    @if($task->description)
                    <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $task->description }}</p>
                    @endif
                    
                    <div class="flex justify-between items-center mt-3 text-xs text-gray-500">
                        <div>
                            <span class="block">Created At: {{ \Carbon\Carbon::parse($task->created_at)->format('M d, Y') }}</span>
                            <span class="text-indigo-600">@ {{ $task->creator->name }}</span>
                            
                        </div>
                          <div>
                            <span class="block">Assigned At: {{ \Carbon\Carbon::parse($task->assigned_at)->format('M d, Y') }}</span>
<span class="text-indigo-600">
    @To {{ $task->assignee->name ?? 'Unassigned' }}
</span>                            
                        </div>
                        <div class="flex space-x-2">

                            @can('task_assign')
                                
                           

<a href="{{ route('tasks.assign', $task->id) }}" 
   class="text-indigo-600 hover:text-indigo-900 mr-2"
   title="Assign task"
   data-action="assign">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
    </svg>
</a>
 @endcan

 @can('task_complete')
     


<form action="{{ route('tasks.complete', $task->id) }}" 
      method="POST" 
      class="inline-block text-indigo-600 hover:text-indigo-900 mr-2"
      title="{{ $status->tasktype === 'Completed' ? 'Task already completed' : 'Complete task' }}"
      @if($status->tasktype === 'Completed') disabled @endif>
    @csrf
    @method('PUT')
    <button type="submit" class="focus:outline-none" data-action="complete"
            @if($status->tasktype === 'Completed') disabled @endif>
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M5 14L9 17L18 6" stroke="currentColor" stroke-width="2"
                  @if($status->tasktype === 'Completed') stroke="#a3a3a3" @endif/>
        </svg>
    </button>
</form>
 @endcan

 @can('task_edit')
     

                            <a href="{{ route('tasks.edit', $task->id) }}" class="text-indigo-600 hover:text-indigo-800 transition-colors cursor-pointer"
                                data-action="edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>

                             @endcan

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@push('styles')
<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    .animate-slide-down {
        animation: slideDown 0.5s ease-out;
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes slideDown {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    @keyframes fadeInUp {
        from { transform: translateY(10px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/dragg.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filters = {
            user: document.getElementById('user-filter'),
            status: document.getElementById('status-filter'),
            date: document.getElementById('date-filter'),
            reset: document.getElementById('reset-filters')
        };

        function applyFilters() {
            const userValue = filters.user.value;
            console.log('User Filter:', userValue);
            const statusValue = filters.status.value;
            const dateValue = filters.date.value;
            
            document.querySelectorAll('.task-card').forEach(card => {
                const matchesUser = !userValue || card.dataset.userId === userValue;
                console.log('Card User:', card.dataset, 'Matches:', matchesUser);
                const matchesStatus = !statusValue || card.dataset.statusId === statusValue;
                const matchesDate = !dateValue || card.dataset.assignedDate === dateValue;
                
                if (matchesUser && matchesStatus && matchesDate) {
                    card.classList.remove('hidden');
                    card.classList.add('animate-fade-in');
                } else {
                    card.classList.add('hidden');
                }
            });
        }

        filters.user.addEventListener('change', applyFilters);
        filters.status.addEventListener('change', applyFilters);
        filters.date.addEventListener('change', applyFilters);
        filters.reset.addEventListener('click', () => {
            filters.user.value = '';
            filters.status.value = '';
            filters.date.value = '';
            applyFilters();
        });
    });
</script>
@endpush