
document.addEventListener('DOMContentLoaded', function() {
    console.log('Drag and drop initialized');
    
    let draggedTask = null;

    document.querySelectorAll('[data-action="edit"]').forEach(link => {
        link.addEventListener('click', function(e) {
            window.location = this.href;
        });
    });

    document.querySelectorAll('.task-card').forEach(card => {
        card.addEventListener('dragstart', function(e) {
            if (e.target.closest('[data-action="edit"], [data-action="delete"], [data-action="assign"], [data-action="complete"]')) {
                console.log('Action link clicked, preventing drag');
                e.preventDefault();
                e.stopPropagation();
                return;
            }
            
            console.log('Drag started');
            draggedTask = this;
            setTimeout(() => this.style.opacity = '0.4', 0);
            e.dataTransfer.setData('text/plain', this.id);
        });

        card.addEventListener('dragend', function() {
            console.log('Drag ended');
            this.style.opacity = '1';
            draggedTask = null;
        });
    }); // This closes the task-card forEach

    document.querySelectorAll('.status-column').forEach(column => {
        column.addEventListener('dragover', function(e) {
            e.preventDefault();
            console.log('Dragging over column');
            this.style.backgroundColor = '#f0f4f8';
        });

        column.addEventListener('dragleave', function() {
            this.style.backgroundColor = '';
        });

        column.addEventListener('drop', function(e) {
            e.preventDefault();
            console.log('Dropped on column');
            this.style.backgroundColor = '';

            if (draggedTask) {
                this.appendChild(draggedTask);
                const taskId = draggedTask.dataset.taskId;
                const statusId = this.dataset.statusId;
                console.log(`Moving task ${taskId} to status ${statusId}`);
                updateTaskStatus(taskId, statusId);
            }
        });
    });

    function updateTaskStatus(taskId, statusId) {
        console.log('Attempting API call...');
        fetch(`/tasks/${taskId}/update-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status_id: statusId })
        })
        .then(response => {
            console.log('API response status:', response.status);
            return response.json();
        })
        .then(data => {
            toastr.success(data.message)
        })
        .catch(error => {
            toastr.error(error.message);
        });
    }
});