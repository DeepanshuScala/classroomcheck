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
                @if($allow_add)
                <a href="{{ URL('admin/content/add-testimonial') }}" class="btn btn-warning float-right btn-sm">Add Testimonials</a>
                @endif
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
            <table id="webContentList" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Content</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($result as $key => $val) {
                        $description = '';
                        if ($val->content != NULL || $val->content != '')
                            $description = mb_strimwidth($val->content, 0, 200, "...");
                        else
                            $description = 'N/A';
                        ?>
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $val->name }}</td>
                            <td>{{ $description }}</td>
                            <td><img
                            src="{{ url('storage/uploads/testimonials/'.$val->image) }}" height="50px" width="50px"></td>
                            <td>
                                <a href="{{ URL('admin/content/update-testimonial').'/'.$val->id }}" class="btn btn-warning text-white btn-xs" title="Update Testimonials">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a data-id="{{ $val->id }}" class="btn btn-danger text-white btn-xs deleteTestimonial" title="Delete Blog">
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
        //delete Blog popup
        $(document).on('click', '.deleteTestimonial', function (e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this Testimonial!",
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
                    window.location.href = "<?php echo URL('admin/content/delete-testimonial') ?>" + '/' + id;
                }
            });
        });
    });
</script>
@stop