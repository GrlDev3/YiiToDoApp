$(document).ready(function() {
    function loadTasks() {
        $.ajax({
            url: '/site',
            method: 'GET',
            success: function(tasks) {
                console.log(...tasks);
                $('#task-list').empty();
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

    loadTasks();

    $('#task-form').on('submit', function(e) {
        e.preventDefault();
        const title = $('#task-title').val();
        $.ajax({
            url: '/site',
            method: 'POST',
            data: JSON.stringify({ title: title }),
            contentType: 'application/json',
            success: function() {
                loadTasks();
            }
        });
    });

    $(document).on('click', '.update', function(){
        const taskId = $(this).data('id');
        $.ajax({
            url: '/site/' + taskId,
            method: 'PUT',
            data: JSON.stringify({ title: title }),
            contentType: 'application/json',
            success: function() {             
                loadTasks();
            }
        });
    });

    $(document).on('click', '.delete', function() {
        const taskId = $(this).data('id');
        $.ajax({
            url: '/site/' + taskId,
            method: 'DELETE',
            success: function() {
                loadTasks();
            }
        });
    });
});
