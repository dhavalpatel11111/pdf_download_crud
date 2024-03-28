<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
</head>

<body>
    <div class="container bg-light mt-3">

        <div class="container">
            <button type="button" class="btn btn-primary mt-5" id="add_user_btn">
                Add User
            </button>
        </div>



        <!-- Modal -->
        <div class="modal fade" id="user_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="user_form_id" enctype="myltmultipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="fname" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name">
                            </div>

                            <input type="hidden" name="hid" id="hid">

                            <div class="mb-3">
                                <label for="lname" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="E-mail">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            </div>

                            <div class="mb-3">
                                <label for="c_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="c_password" name="c_password" placeholder="Confirm Password">
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Gender</label>
                                <input type="radio" name="gender" id="male" value="male">Male
                                <input type="radio" name="gender" id="female" value="female">Female
                                <input type="radio" name="gender" id="other" value="other">Other
                            </div>

                            <div class="mb-3">
                                <label for="formFile" class="form-label">User Image</label>
                                <input class="form-control" type="file" id="img" name="img">
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option selected>Open this select menu</option>
                                    <option value="1">Active</option>
                                    <option value="0">In-Active</option>
                                </select>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>




        <div class="container mt-3 p-3">

            <table class="table table-striped" id="table">
                <thead>
                    <th>No.</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>E-mail</th>
                    <th>Password</th>
                    <th>Confirm Password</th>
                    <th>Gender</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Action</th>
                </thead>
                <tbody id="tbody">

                </tbody>
            </table>

        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {

            $("#add_user_btn").on("click", function() {
                $("#user_modal").modal('show');
            })

            $("#user_modal").on("hide.bs.modal", function() {
                $("#user_form_id").trigger("reset");
                $("#hid").val("");

            })



            let list = $('#table').dataTable({
                searching: true,
                paging: true,
                pageLength: 10,

                "ajax": {
                    url: "/user_list",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'fname'
                    },
                    {
                        data: 'lname'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'password'
                    },
                    {
                        data: 'c_password'
                    },
                    {
                        data: 'gender'
                    },
                    {
                        data: 'img'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'action'
                    }
                ],
            });


        });
        $("#user_form_id").submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: "/add_user",
                type: "POST",
                processData: false,
                contentType: false,
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                success: function(response) {
                    console.log('response:', response)
                    var data = JSON.parse(response);
                    console.log('data:', data)
                    if (data.status == 0) {
                        Swal.fire({
                            title: "Done!",
                            text: data.mesege,
                            icon: "success"
                        });
                        $("#user_modal").modal('hide');
                        $("#user_form_id").trigger("reset");
                        $('#table').DataTable().ajax.reload();
                        $("#hid").val("");

                    } else {
                        Swal.fire({
                            title: "Sorry",
                            text: data.mesege,
                            icon: "error"
                        });
                    }
                }
            });
        });







        $(document).on("click", "#del", function() {
            var headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            var dataid = $(this).data("id");


            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
                title: "Are you sure You Want to delete this data?",

                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        cache: false,
                        url: "/delete_user",
                        headers: headers,
                        data: {
                            id: dataid
                        },
                        success: function(responce) {
                            // console.log('responce:', responce);
                            if (responce['status'] == 1) {
                                // toastr.success(responce['mesege']);

                            } else {
                                // toastr.error(responce['mesege']);
                                Swal.fire({
                                    title: "Sorry",
                                    text: responce['mesege'],
                                    icon: "error"
                                });
                            }
                            $('#table').DataTable().ajax.reload();

                        }
                    })
                    swalWithBootstrapButtons.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });

                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",

                        icon: "error"
                    });
                }
            });

        });


        $(document).on("click", "#edit", function() {



            var headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            var id = $(this).data("id");

            $.ajax({
                type: "POST",
                cache: false,
                url: "/edit_user",
                headers: headers,
                data: {
                    id: id
                },
                success: function(responce) {
                    console.log('edit responce :', responce);
                    $('#user_modal').modal('show');
                    if (responce.status == 0) {
                        $("#hid").val(responce.data.id);
                        $("#fname").val(responce.data.fname);
                        $("#lname").val(responce.data.lname);
                        $("#email").val(responce.data.email);
                        $("#password").val(responce.data.password);
                        $("#c_password").val(responce.data.c_password);
                        $('input[name="gender"][value="' + responce.data.gender + '"]').prop('checked', true);
                        $("#status").val(responce.data.status);
                        $("#submit").html("Update");
                    } else {
                        Swal.fire({
                            title: responce.messege,
                            text: responce.messege,
                            icon: "success"
                        });
                    }
                }
            })
        });

    </script>
</body>

</html>