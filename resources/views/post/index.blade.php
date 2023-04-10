<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>

    <section class="p-2 m-2">
        <div class="container">
            <div class="col-sm-4">
                <button id="addButton" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    (+) Add
                </button>
            </div>
            <table class="table table-borderless">
                <tbody>
                    @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->content }}</td>
                        <td>
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="button-addon2"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" id="editButton" href="#" data-id="{{ $post->id }}">Edit</a></li>
                                <li><a class="dropdown-item" id="deleteButton" href="#" data-id="{{ $post->id }}">Delete</a></li>
                            </ul>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Form</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="title" class="col-sm-2 col-form-label text-end">Title :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="title" name="title" placeholder="e.g. John Doe"
                                required>
                        </div>
                    </div>
    
                    <div class="mb-3 row">
                        <label for="content" class="col-sm-2 col-form-label text-end">Content :</label>
                        <div class="col-sm-10">
                            <textarea name="content" id="content" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>

                    <div style="display: block; text-align: -webkit-center;">
                        <button class="btn btn-primary mb-3" id="save"> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        // 02_PROSES SIMPAN
        $('body').on('click', '#addButton', function(e) {
            e.preventDefault();
            $('#exampleModal').modal('show');
            $('#save').click(function() {
                save();
            });
        });
    
        // 03_PROSES EDIT
        $('body').on('click', '#editButton', function(e) {
            var id = $(this).data('id');
            $.ajax({
                url: 'post/' + id + '/edit',
                type: 'GET',
                success: function(response) {
                    console.log(response.result);
                    $('#exampleModal').modal('show');
                    $('#title').val(response.result.title);
                    $('#content').val(response.result.content);
                    $('#save').click(function() {
                        save(id);
                    });
                }
            });
        });
    
        // 04_PROSES Delete
        $('body').on('click', '#deleteButton', function(e) {
            if (confirm('Are you sure?') == true) {
                var id = $(this).data('id');
                $.ajax({
                    url: 'post/delete/' + id,
                    type: 'POST',
                    success: function(html) {
                        location.reload();
                    },
                });
            }
        });
    
        // fungsi simpan dan update
        function save(id = '') {
            if (id == '') {
                var action = 'post/create';
                var method = 'POST';
            } else {
                var action = 'post/update/' + id;
                var method = 'POST';
            }
            console.log(action);
            $.ajax({
                url: action,
                type: method,
                data: {
                    title: $('#title').val(),
                    content: $('#content').val(),
                },
                success: function(html) {
                    location.reload();
                },
            });
        }   
        $('#exampleModal').on('hidden.bs.modal', function() {
            $('#title').val();
            $('#content').val();
        });
    </script>
</body>
</html>