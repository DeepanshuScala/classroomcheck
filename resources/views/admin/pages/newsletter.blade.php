@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $pageHeading }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a class="text-blue" href="{{ URL('admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ $pageHeading }}</li>
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
            <table id="newsletterList" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Store Name</th>
                        <th>Email</th>
                        <!-- <th>Grade</th> -->
                        <th>Subject</th>
                        <!-- <th>Action</th> -->
                        <th>Product</th>
                        <th>Store Web Adress</th>
                        <th>Previous Listing</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($sr as $key => $val) {
                    ?>
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>
                                <a href="{{URL('admin/users/view-user-info/'.base64_encode($val->store_user_id))}}">{{ $val->store_name }}</a>
                            </td>
                            <td>{{ $val->email }}</td>
                            <!-- <td>{{ $val->resource_grade }}</td> -->
                            <td>{{ $val->resource_subject }}</td>
                            <!-- <td> -->
                                <?php
                                // $content = 'Hi,<br>
                                //             Store Name: '.$val->store_name."<br>
                                //             Store URL: ".$val->store_name."<br>
                                //             Email: ".$val->email."<br>
                                //             Resource Grade: ".$val->resource_grade."<br>
                                //             Resource Subject: ".$val->resource_subject."<br>
                                //             Product Price Type: ".$val->product_price_type;
                                $content = 'Hi,
                                            Store Name: '.$val->store_name."
                                            Store URL: ".$val->store_name."
                                            Email: ".$val->email."
                                            Resource Grade: ".$val->resource_grade."
                                            Resource Subject: ".$val->resource_subject."
                                            Product Price Type: ".$val->product_price_type;
                                ?>
                                <!-- <a data-id="{{ $val->id }}" data-content="{{$content}}" class="btn btn-success btn-xs sendbuyernotification" title="Push Notification">
                                    Send Newsletter
                                </a> -->
                            <!-- </td> -->
                            <td>
                                <?php
                                    if(!empty($val->product)){
                                        $getin = DB::table('crc_products')->where('id',$val->product)->first();
                                        if(!empty($getin)){
                                            echo $getin->product_title;
                                        }
                                    }
                                ?></td>
                            <td><a href="{{$val->store_url}}" target="_blank">{{ $val->store_url }}</a></td>
                            <td>{{ $val->previous_listing == 1 ? 'Yes':'No' }}</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

</section>
<!--//send notification Moadal:-->
<div class="modal fade" id="sendusernotification" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
             <div class="modal-header justify-content-end">
                <button type="button" class="bg-transparent border-0" data-dismiss="modal" aria-label="Close">✕</button>
            </div>
            <div class="modal-body">
                <div class="text-center" id="error_message">
                    <h3 class="modal-title text-blue" id="staticBackdropLabel">Send Newsletter</h3>
                </div>
                <div class="">
                    <form class="" action="" method="post" name="sendnewsletter" id="sendnewsletter">
                        @csrf
                        <div class="my-2">
                            <textarea name="mail_content" id="mytextarea" rows="10" cols="60"></textarea>
                        </div>
                        </br>
                        <input type="hidden" name="newsletterid" value="">
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
        $('body .sendbuyernotification').on('click',function(){
            $('input[name="newsletterid"]').val($(this).data('id'));
            $('textarea[name="mail_content"]').val($(this).data('content'));
            $('#sendusernotification').modal('show');
        });
        $('form#sendnewsletter').on('submit',function(e){
            e.preventDefault();
            var formd = $(this).serialize();
            $.ajax({
                url: "{{route('sendbuyernotification')}}",
                type: 'POST',
                data: formd,
            }).done(function (response, status, xhr) {
                $('#sendusernotification').modal('hide');
                swal.fire("Done", "Newsletter Sent Successfully", "success");
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
    });
</script>
@stop