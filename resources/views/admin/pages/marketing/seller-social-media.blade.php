@extends('admin.layouts.master')
@section('title', $pageHeading)
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-blue">{{ $pageHeading }} Management</h1>
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
            <h3 class="card-title w-100">{{ $pageHeading }}
            </h3>
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
            <table id="subjectList" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Store URL</th>
                        <th>Store Name</th>
                        <th>Email</th>
                        <th>Store FB URL</th>
                        <th>Store Insta URL</th>
                        <th>Explain Submission</th>
                        <th>Submission Type Details</th>
                        <th>Resource Grade</th>
                        <th>Resource Subject</th>
                        <th>Submission Type</th>
                        <th>Media</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($sr as $key => $val) {
                    ?>
                        <tr>
                            <td>{{ $key+1 }}</td>

                            <td>
                                <a href="{{ $val->storeurl }}">{{ $val->storeurl }}</a>
                            </td>
                            <td>{{ $val->store_name}}</td>
                            <td>{{ $val->email }}</td>
                            <td>{{ $val->store_fb_url }}</td>
                            <td>{{ $val->store_insta_url }}</td>
                            <td>{{ $val->explain_submission }}</td>
                            <td>{{ $val->submission_type_details }}</td>
                            <td>{{ $val->resource_grade }}</td>
                            <td>{{ $val->resource_subject }}</td>
                            <td>{{ $val->submission_type }}</td>
                            <td>
                                <?php
                                    if(!empty($val->media)){
                                ?>
                                <a href="{{Storage::disk('s3')->url('store/seller_socialmedia/'.$val->media)}}" download>Download media({{$val->media}})</a>
                                <?php
                                    }
                                ?>
                            </td>
                        </tr>
                    <?php 
                        } 
                    ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

</section>
<!-- /.content -->


@stop


@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        //activate promotion popup
        $(document).on('click', '.activateSubject', function (e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to activate this subject!",
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
                    window.location.href = "<?php echo URL('admin/subject/activate-deactivate-subject') ?>" + '/' + id + '/1';
                }
            });
        });
        //deactivate promo popup
        $(document).on('click', '.deactivateSubject', function (e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to deactivate this subject!",
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
                    window.location.href = "<?php echo URL('admin/subject/activate-deactivate-subject') ?>" + '/' + id + '/0';
                }
            });
        });
    });
</script>
@stop