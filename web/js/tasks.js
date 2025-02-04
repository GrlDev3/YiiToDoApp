
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
            //contentType: 'application/json',
            success: function() {
                $('#task-title').val('');
                loadTasks();
            }
        });
    });

    $(document).on('click', '.update', function(){
        const taskId = $(this).data('id');
        $.ajax({
            url: '/tasks/' + taskId,
            method: 'PUT',
            data: JSON.stringify({title: title}),
            success: function(){
                loadTasks();
            }
        })

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
});
