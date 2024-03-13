@extends('admin.layouts.master')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Add Promotion</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a class="text-blue" href="{{ URL('admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Add Promotion</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">

    <div class="card card-blue">
        <div class="card-header">
            <h3 class="card-title">Add Promotion</h3>
            <a class="btn btn-warning text-white btn-xs float-right" href="{{url()->previous()}}">
                <i class="fa fa-arrow-left"></i>&nbsp;Back
            </a>
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
            <form action="" method="post" name="addPromotionForm" id="addPromotionForm">
                @csrf
                <!-- <div class="form-group">
                    <label>Type</label>
                    <select class="form-control" name="type" id="type" required="">
                        <option value="0" <?php if (old('type') == "0") { ?> selected="" <?php } ?>>Public</option>
                        <option value="1" <?php if (old('type') == "1") { ?> selected="" <?php } ?>>Private</option>
                    </select>
                </div> -->

                <!-- <div class="form-group">
                    <label>Usage For</label>
                    <select class="form-control" name="promo_usage_for" id="promo_usage_for" required="">
                        <option value="" disabled="" selected="">Select Promotion Usage For</option>
                        <option value="1" <?php if (old('promo_usage_for') == 1) { ?> selected="" <?php } ?>>Store</option>
                        <option value="2" <?php if (old('promo_usage_for') == 2) { ?> selected="" <?php } ?>>User</option>
                    </select>
                </div> -->

                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control" required="" placeholder="Title">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <input type="text" name="description" id="description" value="{{ old('description') }}" class="form-control" required="" placeholder="Description">
                </div>

                <div class="form-group">
                    <label class="w-100">Promotion Code <a class="btn btn-blue text-white btn-xs float-right generateCode">Auto Generator</a></label>
                    <input type="text" name="promo_code" id="promo_code" value="{{ old('promo_code') }}" class="form-control" required="" placeholder="Promotion Code">
                </div>

                <div class="form-group">
                    <label>Start-End Date</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control float-right" id="start_end_date" name="start_end_date" value="{{ old('start_end_date') }}" autocomplete="off">
                    </div>                    
                </div>

                <div class="form-group">
                    <label>Discount Type</label>
                    <select class="form-control" name="discount_in" id="discount_in" required="">
                        <option value="" disabled="" selected="">Select Discount Type</option>
                        <option value="1" <?php if (old('discount_in') == 1) { ?> selected="" <?php } ?>>Flat Rate</option>
                        <option value="2" <?php if (old('discount_in') == 2) { ?> selected="" <?php } ?>>Percentage</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="change-type">Amount($)</label>
                    <input type="number" name="amount" id="amount" value="{{ old('amount') }}" class="form-control" required="" placeholder="Amount">
                </div>

                <button type="submit" class="btn btn-blue text-white">Add</button>
            </form>
        </div>
        <!-- /.card-body -->
    </div>

</section>
<!-- /.content -->
@stop

@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        //get generate random promotion code
        $('.generateCode').click(function (e) {
            $.ajax({
                url: "<?php echo URL('admin/promo/get-rendom-promotion-code') ?>",
                type: "get",

            }).done(function (response, status, xhr) {
                var result = JSON.parse(response);
                $('#promo_code').val(result.random_number);
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

        $("#discount_in").on('change',function(){
            if($(this).val() == "1"){
                $(".change-type").html('Amount($)');
            }
            else if($(this).val() == "2"){
                $(".change-type").html('Percentage(%)');
            }
        });
    });
</script>
@stop