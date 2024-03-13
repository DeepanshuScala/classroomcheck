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
                <a href="{{ URL('admin/blog/add-blog') }}" class="btn btn-warning float-right btn-sm">Add Blog</a>
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
            <table id="blogsList" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Title</th>
                        <th>Short Description</th>
                        <th>Image 1</th>
                        <th>Image 2</th>
                        <th>Image 3</th>
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
                        if ($val->short_description != NULL || $val->short_description != '')
                            $short_description = mb_strimwidth($val->short_description, 0, 200, "...");
                        else
                            $short_description = 'N/A';
                        ?>
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $val->title }}</td>
                            <td>{{ $short_description }}</td>
                            <td>
                                <?php if ($val->image1 != '' || $val->image1 != null) { ?>
                                    <a href="{{ url('storage/uploads/blogs/' . $val->image1) }}" target="_blank">
                                        <img src="{{ url('storage/uploads/blogs/' . $val->image1) }}" height="50px" width="50px">
                                    </a>
                                <?php } else { ?>
                                    N/A
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($val->image2 != '' || $val->image2 != null) { ?>
                                    <a href="{{ url('storage/uploads/blogs/' . $val->image2) }}" target="_blank">
                                        <img src="{{ url('storage/uploads/blogs/' . $val->image2) }}" height="50px" width="50px">
                                    </a>
                                <?php } else { ?>
                                    N/A
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($val->image3 != '' || $val->image3 != null) { ?>
                                    <a href="{{ url('storage/uploads/blogs/' . $val->image3) }}" target="_blank">
                                        <img src="{{ url('storage/uploads/blogs/' . $val->image3) }}" height="50px" width="50px">
                                    </a>
                                <?php } else { ?>
                                    N/A
                                <?php } ?>
                            </td>
                            <td><span class="badge badge-{{$statusCls}}">{{ $statusTxt }}</span></td>
                            <td class="w-80">
                                <?php if ($val->status == 0) { ?>
                                    <a data-id="{{ $val->id }}" class="btn btn-success btn-xs activateBlog" title="Activate Blog">
                                        <i class="fa fa-check-square"></i>
                                    </a>
                                <?php } else { ?>
                                    <a data-id="{{ $val->id }}" class="btn btn-danger text-white btn-xs deactivateBlog" title="Deactivate Blog">
                                        <i class="fa fa-ban"></i>
                                    </a>
                                <?php } ?>
                                
                                <a href="{{ URL('admin/blog/update-blog').'/'.$val->id }}" class="btn btn-warning text-white btn-xs mx-1" title="Update Blog">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a data-id="{{ $val->id }}" class="btn btn-danger text-white btn-xs deleteBlog" title="Delete Blog">
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
        //activate Blog popup
        $(document).on('click', '.activateBlog', function (e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to activate this Blog!",
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
                    window.location.href = "<?php echo URL('admin/blog/activate-deactivate-blog') ?>" + '/' + id + '/1';
                }
            });
        });
        //deactivate Blog popup
        $(document).on('click', '.deactivateBlog', function (e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to deactivate this Blog!",
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
                    window.location.href = "<?php echo URL('admin/blog/activate-deactivate-blog') ?>" + '/' + id + '/0';
                }
            });
        });
        //delete Blog popup
        $(document).on('click', '.deleteBlog', function (e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this Blog!",
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
                    window.location.href = "<?php echo URL('admin/blog/delete-blog') ?>" + '/' + id;
                }
            });
        });
    });
</script>
@stop