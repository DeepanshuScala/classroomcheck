<?php
$pageHeading = "Promotion";
?>
@extends('admin.layouts.master')
@section('title', $pageHeading)
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
                <a href="{{ URL('admin/promo/add-promo') }}" class="btn btn-warning float-right btn-sm">Add Promotion</a>
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
            <table id="promotionList" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <!-- <th>Type</th> -->
                        <!-- <th>Usage For</th> -->
                        <th>Title</th>
                        <th>Code</th>
                        <th>Status</th>
                        <th>Start and End Date</th>
                        <th>Created On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($promos as $key => $val) {
                        if ($val->promo_usage_for == 1)
                            $promo_usage_for = "Store";
                        else if ($val->promo_usage_for == 2)
                            $promo_usage_for = "User";
                        else
                            $promo_usage_for = "N/A";
                        if ($val->type == 1)
                            $type = "Private";
                        else
                            $type = "Public";
                        $statusTxt = ($val->status == 0) ? 'Inactive' : 'Active';
                        $statusCls = ($val->status == 0) ? 'danger' : 'success';
                        ?>
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <!-- <td><span class="badge badge-success">{{ $type }}</span></td> -->
                            <!-- <td><span class="badge badge-success">{{ $promo_usage_for }}</span></td> -->
                            <td>{{ $val->title }}</td>
                            <td>{{ $val->promo_code }}</td>
                            <td><span class="badge badge-{{$statusCls}}">{{ $statusTxt }}</span></td>
                            <td>{{date('d/m/Y',strtotime($val->start_at)).' to '.date('d/m/Y',strtotime($val->end_at))}}</td>
                            <td><span class="hidde">{{date('m-d-Y',strtotime($val->created_at))}}</span>{{ date('d/m/Y',strtotime($val->created_at)) }}</td>
                            <td>
                                <?php if ($val->status == 0) { ?>
                                    <a data-id="{{ $val->id }}" class="btn btn-success btn-xs activatePromotion" title="Activate Promotion">
                                        <i class="fa fa-check-square"></i>
                                    </a>
                                <?php } else { ?>
                                    <a data-id="{{ $val->id }}" class="btn btn-danger text-white btn-xs deactivatePromotion" title="Deactivate Promotion">
                                        <i class="fa fa-ban"></i>
                                    </a>
                                <?php } ?>
                                &nbsp;
                                <a href="{{ URL('admin/promo/update-promo').'/'.$val->id }}" class="btn btn-warning text-white btn-xs" title="Update Promotion">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <!--a data-id="{{ $val->id }}" class="btn btn-danger btn-xs deletePromotion" title="Delete Promotion">
                                    <i class="fa fa-trash"></i>
                                </a-->
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
        $(document).on('click', '.activatePromotion', function (e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to activate this promotion!",
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
                    window.location.href = "<?php echo URL('admin/promo/activate-deactivate-promo') ?>" + '/' + id + '/1';
                }
            });
        });
        //deactivate promo popup
        $(document).on('click', '.deactivatePromotion', function (e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to deactivate this promotion!",
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
                    window.location.href = "<?php echo URL('admin/promo/activate-deactivate-promo') ?>" + '/' + id + '/0';
                }
            });
        });
    });
</script>
@stop