
    function loadTasks() {
        $.ajax({
            url: '/tasks',
            method: 'GET',
            success: function(tasks) {
                $('#task-list').empty();
                tasks = JSON.parse(tasks);
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


    $('#task-form').on('submit', function(e) {
        e.preventDefault();
        const title = $('#task-title').val();
        $.ajax({
            url: '/tasks',
            method: 'POST',
            data: JSON.stringify({ title: title }),
            //contentType: 'application/json',
            success: function() {
                loadTasks();
            }
        });
    });

    $(document).on('click', '.update', function(){

    });

    $(document).on('click', '.delete', function() {
        const taskId = $(this).data('id');
        $.ajax({
            url: '/tasks/' + taskId,
            method: 'DELETE',
            success: function() {
                loadTasks();
            }
        });
    });

$(document).ready(function() {
    loadTasks();
});
