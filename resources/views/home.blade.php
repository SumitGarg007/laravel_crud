@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h2>Demo Crud Operations</h2>
            <div id="status_data" class="alert alert-danger alert-dismissible fade in" style="display: none;">
                <button type="button" class="close" data-dismiss="alert">&times;</button>                
            </div>
            <form id="crud_operation" method="post">
                {!! csrf_field() !!}
                <div class="form-group">
                  <label for="user_name">Name:</label>
                  <input type="text" class="form-control" id="user_name" placeholder="Enter Name" name="user_name">
                </div>

                <div class="form-group">
                  <label for="user_email">Email:</label>
                  <input type="email" class="form-control" id="user_email" placeholder="Enter email" name="user_email">
                </div>


                <div class="form-group">
                  <label for="user_message">Message:</label>
                  <textarea class="form-control" id="user_message" placeholder="Enter password" name="user_message" rows="6"></textarea>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $.validator.setDefaults({
            submitHandler: function () {
                $.ajax({
                    url: "{{ url('/insert-crud')}}",
                    type: "POST",
                    data: $('#crud_operation').serialize(),
                    dataType: "json",
                    beforeSend: function (xhr) {
                        $("#status_data").hide()
                        $(".card-footer button").prop("disabled", true).addClass('btn-default').removeClass('btn-warning').html('Please Wait <i class="fas fa-sync-alt fa-spin" style="font-size: 16px;color: #007bff;"></i>');
                    }, success: function (resp) {
                        $(".card-footer button").prop("disabled", false).addClass('btn-warning').removeClass('btn-default').html('Submit');
                        if (resp.error_status) {
                            $("#status_data").show().removeClass("alert-success").addClass('alert-danger').html('<strong>Error!</strong> ' + resp.error_status);
                        } else {
                            $("#status_data").show().removeClass("alert-danger").addClass('alert-success').html('<strong>Success!</strong> ' + resp.success_status);
                            $('#crud_operation')[0].reset();
                        }
                    }, error: function () {
                        $(".card-footer button").prop("disabled", false).addClass('btn-warning').removeClass('btn-default').html('Submit');
                        console.log("Please try after some time");
                    }
                });
            }
        });

        
        $('#crud_operation').validate({
            rules: {
                user_name: {
                    required: true,
                },

                user_email: {
                    required: true,
                    email:true
                },

                user_message: {
                    required: true,
                }
            },
            messages: {
                user_name: {
                    required: "This field is required.",
                },

                user_email: {
                    required: "This field is required.",
                    email: "Please enter valid email id"
                },

                user_message: {
                    required: "This field is required.",
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endsection
