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
                    <li class="breadcrumb-item active">{{ $pageHeading }}s</li>
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
            <h3 class="card-title w-100">{{ $pageHeading }}s
                <a href="{{ URL('admin/resource/add-resource') }}" class="btn btn-warning float-right btn-sm">Add Resource</a>
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
            <div class="col-md-12">
                <ul class="nav nav-pills justify-content-center">
                    <li class="nav-item users">
                        <a class="nav-link {{ (request()->segment(2) == 'subject') ? 'active' : '' }}" aria-current="page" href="{{ URL('admin/subject/list')}}">Subjects</a>
                    </li>
                    <li class="nav-item users">
                        <a class="nav-link ml-2 {{ (request()->segment(2) == 'grade') ? 'active' : '' }}" href="{{ URL('admin/grade/list')}}">Year Levels</a>
                    </li>
                    <li class="nav-item users">
                        <a class="nav-link ml-2 {{ (request()->segment(2) == 'resource') ? 'active' : '' }}" href="{{ URL('admin/resource/list')}}">Resource Types</a>
                    </li>
                    <li class="nav-item users">
                        <a class="nav-link ml-2 {{ (request()->segment(2) == 'type') ? 'active' : '' }}" href="{{ URL('admin/type/list')}}">File Types</a>
                    </li>
                </ul>
            </div>
            <table id="resourceList" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($result as $key => $val) {
                        $statusTxt = ($val->status == 0) ? 'Inactive' : 'Active';
                        $statusCls = ($val->status == 0) ? 'danger' : 'success';
                        ?>
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $val->name }}</td>
                            <td><span class="badge badge-{{$statusCls}}">{{ $statusTxt }}</span></td>
                            <td>
                                <?php if ($val->status == 0) { ?>
                                    <a data-id="{{ $val->id }}" class="btn btn-success btn-xs activateResource" title="Activate Resource">
                                        <i class="fa fa-check-square"></i>
                                    </a>
                                <?php } else { ?>
                                    <a data-id="{{ $val->id }}" class="btn btn-danger text-white btn-xs deactivateResource" title="Deactivate Resource">
                                        <i class="fa fa-ban"></i>
                                    </a>
                                <?php } ?>
                                &nbsp;
                                <a href="{{ URL('admin/resource/update-resource').'/'.$val->id }}" class="btn btn-warning text-white btn-xs" title="Update Resource">
                                    <i class="fa fa-edit"></i>
                                </a>
                                &nbsp;
                                <a href="{{ URL('admin/resource/delete-resource').'/'.$val->id }}" class="btn btn-danger text-white btn-xs " title="Delete" onclick="return confirm('Are you sure you want to delete?')">
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
        //activate promotion popup
        $(document).on('click', '.activateResource', function (e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to activate this resource type!",
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
                    window.location.href = "<?php echo URL('admin/resource/activate-deactivate-resource') ?>" + '/' + id + '/1';
                }
            });
        });
        //deactivate promo popup
        $(document).on('click', '.deactivateResource', function (e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to deactivate this resource type!",
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
                    window.location.href = "<?php echo URL('admin/resource/activate-deactivate-resource') ?>" + '/' + id + '/0';
                }
            });
        });
    });
</script>
@stop