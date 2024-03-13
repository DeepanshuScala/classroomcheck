@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('content')
<style type="text/css">
    span.hidde{
        display:none; 
    }
</style>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Suggest a Resource</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a class="text-blue" href="{{ URL('admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Suggest a Resource</li>
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
            <h3 class="card-title w-100">{{ $pageHeading }}</h3>
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
            <table id="promotionList" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Grade</th>
                        <th>Subject</th>
                        <th>Resource Type</th>
                        <th>Description</th>
                        <th>Notification Sent Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($sr as $key => $val) {
                    ?>
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $val->name }}</td>
                            <td>{{ $val->email }}</td>
                            <td>{{ $val->gradeLevel->grade }}</td>
                            <td>{{ isset($val->subject->name)?$val->subject->name:'' }}</td>
                            <td>{{ $val->resource->name }}</td>
                            <td>{{ $val->description  }}</td>
                            <td><span class="hidde">{{date('d M, Y',strtotime($val->sent_date))}}</span>{{ date('d/m/Y',strtotime($val->sent_date))}}</td>
                            <td>
                                @if(!$val->is_sent_to_seller)
                                    <a data-id="{{ $val->id }}" class="btn btn-success btn-xs sendbuyernotification" title="Push Notification">
                                        Send Seller Notification
                                    </a>
                                @else
                                    <a data-id="#" class="btn btn-secondary btn-xs" title="Push Notification">
                                        Notification Sent
                                    </a>
                                @endif
                                <!-- <form class="" action="" method="post" name="sendbuyernotification" id="sendnotification">
                                    @csrf
                                    <div class="my-2">
                                        <select name="buyers" class="form-control" style="display:none;">
                                            <option value="all" selected>Send to all</option>
                                        </select>
                                    </div>
                                    </br>
                                    <input type="hidden" name="resourceid" value="{{ $val->id }}">
                                    <div class="my-2 text-center">
                                        <input type="submit" class="btn btn-success btn-xs" id="applyGiftCouponFormSubBtn" value="Send Seller Notification" />
                                    </div>
                                </form> -->
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

</section>
<!--//send notification Moadal:-->
<div class="modal fade" id="sendbuyernotification" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
             <div class="modal-header justify-content-end">
                <button type="button" class="bg-transparent border-0" data-dismiss="modal" aria-label="Close">✕</button>
            </div>
            <div class="modal-body">
                <div class="text-center" id="error_message">
                    <h3 class="modal-title text-blue" id="staticBackdropLabel">Send Seller Notification</h3>
                </div>
                <div class="">
                    <form class="" action="" method="post" name="sendbuyernotification" id="sendnotification">
                        @csrf
                        <div class="my-2">
                            <select name="buyers" class="form-control" style="display:none;">
                                <option value="all" selected>Send to all</option>
                                <?php
                                foreach($users as $user){
                                ?>
                                    <option value="{{$user->id}}">{{$user->first_name.' '.$user->surname}}</option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        </br>
                        <input type="hidden" name="resourceid" value="">
                        <div class="my-2 text-center">
                            <input type="submit" class="btn btn-primary bg-blue px-4 py-2" id="applyGiftCouponFormSubBtn" value="Send" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--//send notification Moadal:-->
<!-- /.content -->
<script type="text/javascript">
    $(document).ready(function(){
        $('.sendbuyernotification').on('click',function(){
            $('input[name="resourceid"]').val($(this).data('id'));
            $('#sendbuyernotification').modal('show');
        });
        $('form#sendnotification').on('submit',function(e){
            e.preventDefault();
            var formd = $(this).serialize();
            $.ajax({
                url: "{{route('sendsellernotification')}}",
                type: 'POST',
                data: formd,
                beforeSend: function (xhr) {
                    //$("#filterSearchSubmitBtn").prop('disabled', true);
                }
            }).done(function (response, status, xhr) {
               swal.fire("Done", "Notification Sent Successfully", "success");
                setTimeout(function(){
                    location.reload();
                },3000);
            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                if (xhr.status == 419 && xhr.statusText == "unknown status") {
                    swal.fire("Unauthorized! Session expired", "Please login again", "error");
                }
                else{
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        swal.fire(xhr.responseJSON.message, "Please try again", "error");
                    } else {
                        swal.fire('Unable to process your request', "Please try again", "error");
                    }
                }
            });
            
        })
        setTimeout(function(){
            $('#promotionList thead th:first').click();
        },500);
    });
</script>
@stop