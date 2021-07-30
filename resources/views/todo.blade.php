<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <title>TODO APPLICATION</title>
    <style>
        #myForm{
            display:flex;
        }
        .form-group{
            padding: 10px;
        }
        .btn{
            width:7rem;
            height:3.5rem;
        }
        *{
            margin: 0.5em;
        }
    </style>    
</head>
<body>
    <div class="container">
    <header> @include('header/header') </header>
        <div class="row mt-5">
            <div class="col-8">
                <form id="myForm">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <select name="category_id" class="form-control">
                            <option value="">Choose a TODO</option>
                            @foreach ($todos as $todo)
                            <option value="{{ $todo->id }}">{{ $todo->category_id }}</option>
                            @endforeach    
                        </select>
                    </div>
                    <br />
                    <div class="form-group">
                        <input type="text" class="form-control" id="input-text" name="name" placeholder="Add a todo">
                    </div>
                    <br />
                    <button id="submit" class="btn btn-success">Add TODO</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <table class="table table-bordered" id="name" border="5px">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>TODO Item name</th>
                            <th>Category</th>
                            <th>Timestamp</th>
                            <!--<th> Edit </th> --> 
                            <th> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Changes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="updateform">
            {{ csrf_field() }}
            <div class="form-group">
            <label for="">Update Category</label>
            <select name="edit_todo" class="form-control">
                <option value="">Choose a TODO</option>
                            @foreach ($todos as $todo)
                            <option value="{{ $todo->id }}">{{ $todo->category_id }}</option>
                            @endforeach    
            </select>
            </div>
            <div class="form-group">
                <label for="">todo_name</label>
                <input type="text" class="form-control" name="edit_name" placeholder="todo names">    
            </div>    
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="update" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () 
        {
            
            //Data inserted 
            $('#submit').click(function (e) 
            {
                e.preventDefault();
                $.ajax
                ({
                    url: "{{ url('addTodo') }}",
                    type: 'post',
                    datatype: 'json',
                    data: $('#myForm').serialize(),
                    success: function(response) 
                    {
                        $('#myForm')[0].reset();
                        table.ajax.reload();
                    }
                });
            });

            //Data Display
            var table = $('#name').DataTable
            ({
                ajax: "{{ url('getTodo') }}",
                columns: 
                [
                    { "data": "id" },
                    { "data": "name" },
                    { "data": "category_id" },
                    { "data": "created_at" },
                    /*
                    { "data": null, 
                        render: function ( data, type, row ) {
                            return '<button class="btn btn-success" data-id='+row.id+' data-bs-toggle="modal" data-bs-target="#exampleModal" id="edit" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</button>';
                    }},
                    */
                    { "data": null, 
                        render: function ( data, type, row ) {
                            return "<button class='btn btn-danger' id='delete' data-id="+row.id+">Delete</button>";
                    }}
                ],
            });
            

/*            //Edit Modal
        $(document).on('click', '#edit', function(){
            alert($(this).data("id"));
                $.ajax({
                    url: "{{ url('editTodo') }}",
                    type: 'POST',
                    datatype: 'json',
                    data: {
                            "_token": "{{ csrf_token() }}",
                            "id": $(this).data('id')
                        },
                    success: function(response){
                        console.log(response.data);
                    }

                })
        })
*/
        $(document).on('click', '#delete', function ()
            {
                if(confirm('Are you sure you want to delete this TODO Operation?'))
                {
                    $.ajax
                    ({
                        url: "{{ url('deleteTodo') }}",
                        type: 'post',
                        datatype: 'json',
                        data:{
                            "_token": "{{ csrf_token() }}",
                            "id": $(this).data('id')
                        },
                        success: function(response)
                        {
                            table.ajax.reload();
                        }
                    })
                }
            })
    })
    </script>    
</body>
</html>