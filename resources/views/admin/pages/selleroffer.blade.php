@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{$pageHeading}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a class="text-blue" href="{{ URL('admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">{{$pageHeading}}</li>
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
            <div class="coupon-code">
                <div class="coupon-code-area">
                    <div class="box-dash mb-4">
                        <h2>100% on your sale</h2>
                        <ul class="offer-list mt-4 mb-3">
                            <li>Start your Classroom Copy online store today to receive 100% on your store sales for 12 months</li>
                            <li>This offer is for a limited time only and applies to new accounts/stores only</li>
                            <li>The advertised 100% on all sales excludes third-party transaction fees and taxes</li>
                        </ul>
                        <p><span class="btn btn-light text-lg offer-code"><b>Offer code :</b> sb26dg3663dg</span></p>
                    </div>
                    <p>
                        Seller offer:
                        @if($result->is_active == 0)
                            <a data-id="{{ $result->id }}" class="btn btn-success btn-xs activateUser" title="Activate Offer">Activate
                                <i class="fa fa-check-square"></i>
                            </a>
                        @else
                            <a data-id="{{ $result->id }}" class="btn btn-danger text-white btn-xs deactivateUser" title="Deactivate offer">Deactivate
                                <i class="fa fa-trash"></i>
                            </a>
                        @endif
                    </p>
                    <div class="box-dash mb-4">
                        <p>Seller Offer Banner :</p>
                        @if(!empty($result->banner))
                            <img src="{{url('storage/uploads/selleroffer/'.$result->banner)}}" class="img-fluid">
                        @endif
                        <p class="mt-3">
                            @if(!empty($result->banner))
                                <a href="{{url('admin/add-seller-banner')}}" class="btn btn-success btn-xs edit" title="Edit banner">Edit
                                    <i class="fa fa-pen"></i>
                                </a>
                                <a href="{{url('admin/delete-seller-banner')}}" class="btn btn-danger btn-xs delete" title="Delete banner">Delete
                                    <i class="fa fa-trash"></i>
                                </a>
                            @else
                                <a href="{{url('admin/add-seller-banner')}}" class="btn btn-success text-white btn-xs addbanner" title="Add banner">Add
                                    <i class="fa fa-plus"></i>
                                </a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>

</section>
<!-- /.content -->
@stop
@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        var uri = window.location.href.toString();
        if (uri.indexOf("?") > 0) {
            var clean_uri = uri.substring(0, uri.indexOf("?"));
            window.history.replaceState({}, document.title, clean_uri);
        }

        $('.offer-code').click(function() {
            var textToCopy = 'sb26dg3663dg';
            var tempTextarea = $('<textarea>');
            $('body').append(tempTextarea);
            tempTextarea.val(textToCopy).select();
            document.execCommand('copy');
            tempTextarea.remove();
            Swal.fire({
                title: 'Done!',
                text: 'Coupon Code Copied',
                icon: 'success',
                showConfirmButton: true,
                //closeOnClickOutside: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                timer: 3000
            });
        });

        //activate user popup
        $(document).on('click', '.delete', function (e) {
            e.preventDefault();
            var link = $(this).attr('href');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to Delete!",
                icon: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-info ml-3'
                },
                confirmButtonText: 'Yes, Delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = link;
                }
            });
        });
        //activate user popup
        $(document).on('click', '.activateUser', function (e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to activate account offer!",
                icon: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-info ml-3'
                },
                confirmButtonText: 'Yes, activate it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?php echo URL('admin/selleroffer/activate-deactivate') ?>" + '/1';
                }
            });
        }); 
        $(document).on('click', '.deactivateUser', function (e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to deactivate account offer!",
                icon: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-info ml-3'
                },
                confirmButtonText: 'Yes, deactivate it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?php echo URL('admin/selleroffer/activate-deactivate') ?>" + '/0';
                }
            });
        });
    });
</script>
@stop