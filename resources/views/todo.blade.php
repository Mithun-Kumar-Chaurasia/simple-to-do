<!DOCTYPE html>
<html lang="en">
<head>
  <title>To Do App</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <meta name="csrf_token" content="{{ csrf_token() }}" />
</head>
<body>
 
<div class="container p-5">
  <h2 class="text-info">PHP - Simple To Do List App</h2>
  <div class="card mt-3">
    <div class="card-header text-center">
        <input type="text" id="task">
        <button class="btn btn-sm btn-info" id="add_task">Add Task</button>
        <div id="error" class="pt-2"></div>
    </div>
    <div class="card-body text-center" id="card_body">
        {!!$table_data!!}
    </div> 
    <!-- <div class="card-footer">Footer</div> -->
  </div>
</div>


<script>
    $("#add_task").on('click', function() {
        var task = $("#task").val();
        if(task=='') {
            $("#error").html('Task is required');
            $("#task").focus();
            return false;
        } else {
            $("#error").html('');
        }
        
        $.ajax({
            type: "POST",
            "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
            url: '{{route("store-todo")}}',
            data: {'task': task},
            dataType: 'json',
            error: function(response) {
                if (response.status === 422) {
                    var errors = response.responseJSON.errors;
                    if (errors.task) {
                        $('#error').html(errors.task[0]);
                    }
                }
            },
            success: function(data) {
                // console.log(data.message);
                $("#error").html(data.message);
                $("#card_body").html(data.table_data);
            } 
        });

    });

    function delete_task(id) {
        var conf = confirm('Are you sure to delete it?');
        if(conf) {
            $.ajax({
                type: "POST",
                "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: '{{route("task-delete")}}',
                data: {'id': id},
                dataType: 'json',
                success: function(data) {
                    // console.log(data.message);
                    $("#error").html(data.message);
                    $("#card_body").html(data.table_data);
                } 
            });

        }
    }
    function complete_task(id) {
        $.ajax({
            type: "POST",
            "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
            url: '{{route("task-complete")}}',
            data: {'id': id},
            dataType: 'json',
            success: function(data) {
                // console.log(data.message);
                $("#error").html(data.message);
                $("#card_body").html(data.table_data);
            } 
        });
    }
    function show_all() {
        $.ajax({
            type: "GET",
            "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
            url: '{{route("show-all")}}',
            dataType: 'json',
            success: function(data) {
                // console.log(data.message);
                $("#error").html(data.message);
                $("#card_body").html(data.table_data);
            } 
        });
    }
    
</script>
</body>
</html>
