@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Contact Us</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a class="text-blue" href="{{ URL('admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Contact Us</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="card card-blue">
        <div class="card-header text-white">
            <h3 class="card-title w-100">Contact Us</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible removeAlert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ Session::get('error') }}
            </div>
            @endif
            @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible removeAlert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ Session::get('success') }}
            </div>
            @endif
            <table id="feedbackList" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Topic</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($sr as $key => $val) {
                        $button = '<a href="'.$val->email.'" data-id="'.$val->id.'" class="btn btn-success btn-xs respond">Respond</a>';
                        if($val->status == 1){
                            $button = '<button href="#" class="btn btn-secondary btn-xs">Responded</button>';
                        }
                    ?>
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $val->name }}</td>
                            <td>
                                <a href="{{URL('admin/users/view-user-info/'.base64_encode($val->user_id))}}">{{ $val->email }}</a>
                            </td>
                            <td>{{ $val->phone }}</td>
                            <td>{{ $val->topic }}</td>
                            <td>{{ $val->message }}</td>
                            <td><?php echo $button?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

</section>
<!-- /.content -->
<script type="text/javascript">
    $(document).ready(function(){
        $(".respond").on('click',function(e){
            e.preventDefault();
            var mail = $(this).attr('href');
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{route('updatefeedbackstatus')}}",
                type: 'POST',
                data: {id: id, _token: '{{ csrf_token() }}'},
        
            }).done(function (response, status, xhr) {
                if (response.success === true) {
                    $("a.respond[data-id='"+id+"']").html('Responded');
                    $("a.respond[data-id='"+id+"']").attr('class','btn btn-secondary btn-xs');
                    $("a.respond[data-id='"+id+"']").attr('href','#');
                    window.location = 'mailto:' + mail;
                }
                if (response.success === false) {
                }
            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                if (xhr.status == 419 && xhr.statusText == "unknown status") {
                    swal.fire("Unauthorized! Session expired", "Please login again", "error");
                } else {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        swal.fire(xhr.responseJSON.message, "Please try again", "error");
                    } else {
                        swal.fire('Unable to process your request', "Please try again", "error");
                    }
                }
            });
        });
    });
</script>
@stop