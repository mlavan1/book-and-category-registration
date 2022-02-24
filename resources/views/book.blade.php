<!DOCTYPE html>
<html lang="en-us">
<head>
    <title>Book Registration</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        .book-container{
            margin-left:120px;
            margin-top:50px;
        }
        *{
            font-size:12px;
        }
    </style>
</head>
<body>
    
    {{-- Cateogry Registration --}}

    {{-- Table Content --}}


<div class="container">
    <h1>Category</h1><br>
    <a class="btn btn-success" href="javascript:void(0)" id="createNewBook"> Create New Category</a><br><br>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Category Name</th>    
                <th width="300px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>


{{-- Modal Class --}}

   
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="bookForm" name="bookForm" class="form-horizontal">
                   <input type="hidden" name="book_id" id="book_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Category" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
                     <span id ="notification"></span>
                    <br><br>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<br>


{{-- Book Registration --}}


<div class="book-container">
    <h1>Book</h1>
    <a class="btn btn-success" href="javascript:void(0)" id="createNewBookHandler"> Create New Book</a><br><br>
    <div class="modal fade" id="ajaxModel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading2"></h4>
                </div>
                <div class="modal-body">
                    <form id="bookForm2" name="bookForm2" class="form-horizontal">
                       <input type="hidden" name="book_id" id="book_id">
                        <div class="form-group">
                            
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="bookName" name="bookName" placeholder="Enter Category" value="" maxlength="50" required=""><br>
                            </div>
    
                            <label for="name" class="col-sm-2 control-label">Category</label>
                            <div class="col-sm-12">
                                <select name="categorySelector" id="categorySelector" class="form-control" style="width:300px;" >
                                    @foreach ($books as $book )
                                    <option value="{{ $book->title}}">{{ $book->title}}</option>
                                    @endforeach
                                </select><br>
                            </div>
    
                            <label for="name" class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="Price" name="Price" placeholder="Enter Category" value="" maxlength="50" required=""><br>
                            </div>
    
                            <label for="name" class="col-sm-2 control-label">Author</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="Author" name="Author" placeholder="Enter Category" value="" maxlength="50" required=""><br>
                            </div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                         <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button><br>
                         <span id ="notification"></span>
                        <br><br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>  
<script type="text/javascript">
  $(function () {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });


    // Display Table Data


    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('books.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'title', name: 'title'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });


    // When Create Categeory Button is Clicked


    $('#createNewBook').click(function () {
        $('#saveBtn').val("create-book");
        $('#book_id').val('');
        $('#bookForm').trigger("reset");
        $('#modelHeading').html("Create New Category");
        $('#ajaxModel').modal('show');
    });

    
    // When Create New Book Button Clicked

    $('#createNewBookHandler').click(function () {
        $('#saveBtn').val("create-book");
        $('#book_id').val('');
        $('#bookForm').trigger("reset");
        $('#modelHeading2').html("Create New Book");
        $('#ajaxModel2').modal('show');
    });



    // Edit Book Button


    $('body').on('click', '.editBook', function () {
      var book_id = $(this).data('id');
      $.get("{{ route('books.index') }}" +'/' + book_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Book");
          $('#saveBtn').val("edit-book");
          $('#ajaxModel').modal('show');
          $('#book_id').val(data.id);
          $('#title').val(data.title);
          $('#author').val(data.author);
      })
   });


   // Save Button in  modal


    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Saved');
        $('notification').html('Data Saved Successfully !');
    
        $.ajax({
          data: $('#bookForm').serialize(),
          url: "{{ route('books.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#bookForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });

    

    /* Book Form Save Button */


    $('#saveBtn2').click(function (e) {
        e.preventDefault();
        $(this).html('Saved');
        $('notification').html('Data Saved Successfully !');
    
        $.ajax({
          data: $('#bookForm2').serialize(),
          url: "/books/input",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#bookForm2').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn2').html('Save Changes');
          }
      });
    });
    

    // Delete Book Button


    $('body').on('click', '.deleteBook', function () {
     
        var book_id = $(this).data("id");
        confirm("Are You sure want to delete ?");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('books.store') }}"+'/'+book_id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
     
  });


</script>
</body>
</html>