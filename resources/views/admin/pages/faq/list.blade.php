@extends('admin.layouts.master')
@section('title', $pageHeading)
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-blue">{{ $pageHeading }}</h1>
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
                <a href="{{ URL('admin/faq/add-faq') }}" class="btn btn-warning float-right btn-sm">Add FAQ</a>
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
            <table id="faqList" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($result as $key => $val) {
                        $statusTxt = ($val->status == 0) ? 'Inactive' : 'Active';
                        $statusCls = ($val->status == 0) ? 'danger' : 'success';
                        $answer = '';
                        if ($val->answer != NULL || $val->answer != '')
                            $answer = mb_strimwidth($val->answer, 0, 200, "...");
                        else
                            $answer = 'N/A';
                        ?>
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $val->question }}</td>
                            <td>{{ $answer }}</td>
                            <td><span class="badge badge-{{$statusCls}}">{{ $statusTxt }}</span></td>
                            <td>
                                <?php if ($val->status == 0) { ?>
                                    <a data-id="{{ $val->id }}" class="btn btn-success btn-xs activateFaq" title="Activate FAQ">
                                        <i class="fa fa-check-square"></i>
                                    </a>
                                <?php } else { ?>
                                    <a data-id="{{ $val->id }}" class="btn btn-danger text-white btn-xs deactivateFaq" title="Deactivate FAQ">
                                        <i class="fa fa-ban"></i>
                                    </a>
                                <?php } ?>
                                &nbsp;
                                <a href="{{ URL('admin/faq/update-faq').'/'.$val->id }}" class="btn btn-warning text-white btn-xs" title="Update FAQ">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a data-id="{{ $val->id }}" class="btn btn-danger text-white btn-xs deleteFaq" title="Delete FAQ">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
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
        //activate FAQ popup
        $(document).on('click', '.activateFaq', function (e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to activate this FAQ!",
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
                    window.location.href = "<?php echo URL('admin/faq/activate-deactivate-faq') ?>" + '/' + id + '/1';
                }
            });
        });
        //deactivate FAQ popup
        $(document).on('click', '.deactivateFaq', function (e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to deactivate this FAQ!",
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
                    window.location.href = "<?php echo URL('admin/faq/activate-deactivate-faq') ?>" + '/' + id + '/0';
                }
            });
        });
        //delete FAQ popup
        $(document).on('click', '.deleteFaq', function (e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this FAQ!",
                icon: 'danger',
                showCancelButton: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-info ml-3'
                },
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?php echo URL('admin/faq/delete-faq') ?>" + '/' + id;
                }
            });
        });
    });
</script>
@stop