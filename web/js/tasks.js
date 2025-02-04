
    function loadTasks() {
        $.ajax({
            url: '/tasks',
            method: 'GET',
            success: function(tasks) {
                $('#task-list').empty();
                //tasks = JSON.parse(tasks);
                tasks.forEach(function(task) {
                    $('#task-list').append(
                        '<div>' +
                         task.title +
                          '<button class="delete" data-id="' +
                           task.id + '">Delete</button>' +
                           '<button class="update" data-id="' +
                            task.id + '">Update</button></div>');
                });
            }
        });
    }

$(document).ready(function() {
    loadTasks();

    //add task
    $('#task-form').on('submit', function(e) {
        e.preventDefault();
        var title = $('#task-title').val();
        if(!title){
            alert('Task title cannot be empty')
            return;
        }
        $.ajax({
            url: '/tasks',
            method: 'POST',
            data: JSON.stringify({ title: title }),
            contentType: 'application/json',
            success: function() {
                $('#task-title').val('');
                loadTasks();
            }
        });
    });

    //update task
    $(document).on('click', '.update', function(){
        var taskId = $(this).data('id');
        $.ajax({
            url: '/tasks/' + taskId,
            method: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify({title: title}),
            success: function(){
                loadTasks();
            }
        })

    });

    //delete task
    $(document).on('click', '.delete', function() {
        var taskId = $(this).data('id');
        $.ajax({
            url: '/tasks/' + taskId,
            method: 'DELETE',
            contentType: 'application/json',
            success: function() {
                loadTasks();
            }
        });
    });
});

function addTask(title) {
    fetch('/tasks', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ title: title })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Task added:', data.task);
            loadTasks(); // Reload tasks
        } else {
            console.error('Error adding task:', data.error);
        }
    });
}

function updateTask(taskId, newTitle) {
    fetch('/tasks/' + taskId, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ title: newTitle })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Task updated:', taskId);
            loadTasks(); // Reload tasks
        } else {
            console.error('Error updating task:', data.error);
        }
    });
}

