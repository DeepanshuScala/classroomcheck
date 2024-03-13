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
            <table id="promotionList" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Product</th>
                        <th>Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    	foreach ($confirmedMarketingResult as $key => $confirmMarketing){
                    ?>
                        <tr>
	                        <td><span class="hidde">{{date('d M, Y',strtotime($confirmMarketing['date']))}}</span>{{ date('d/m/Y',strtotime($confirmMarketing['date'])) }}</td>
	                        <td>
	                            <?php
	                            if(is_numeric($confirmMarketing['category'])){
	                                $r = DB::table('crc_subject_details')->select(['name'])->where('id',$confirmMarketing['category'])->first();
	                                if(!is_null($r)){
	                                    echo $r->name;
	                                }
	                            }
	                            ?> 
	                        </td>
	                        <td>{{ $confirmMarketing['product_title'] }}</td>
	                        <td>${{ number_format($confirmMarketing['amount'],2) }} {{ env('CURRENCY') }}</td>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script type="text/javascript">
    function selectDate(classname) {
        let table = $('#'+classname).DataTable();
        table.draw();
    }
    $(document).ready(function () {
        $('#usersList1').DataTable();
        
        $.fn.dataTable.ext.search.push( function( settings, data, dataIndex ) { 
        
            if(settings.sTableId == 'usersList1'){
                var toDate = $('#toDate1').val();
                var fromDate = $('#fromDate1').val();
                var dateField = data[1];
            }
            else{
                var toDate = $('#toDate').val();
                var fromDate = $('#fromDate').val(); 
                var dateField = data[1];
            }
          
            let formatedToDate = toDate ? new Date(moment(toDate, "YYYY-MM-DD")) : '';
            let formatedFromDate = fromDate ? new Date(moment(fromDate, "YYYY-MM-DD")) : '';
           
            let formatedDateField = dateField ? new Date(moment(dateField, "DD/MM/YYYY")) : '';
            if(formatedToDate && formatedFromDate && formatedDateField) {
            return formatedToDate.getTime() <= formatedDateField.getTime() && formatedDateField.getTime() <= formatedFromDate.getTime()
            } else if(formatedToDate && !formatedFromDate && formatedDateField) {
            return formatedToDate.getTime() <= formatedDateField.getTime()
            } else if(!formatedToDate && formatedFromDate && formatedDateField) {
            return formatedDateField.getTime() <= formatedFromDate.getTime()
            } else if(!formatedToDate && !formatedFromDate) {
            return true
            }
            return false; 
        });

        //activate user popup
        $(document).on('click', '.activateUser', function (e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to activate account for this user!",
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
                    window.location.href = "<?php echo URL('admin/users/activate-deactivate-user') ?>" + '/' + id + '/1';
                }
            });
        });
        //activate user popup
        $(document).on('click', '.deactivateUser', function (e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to deactivate account for this user!",
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
                    window.location.href = "<?php echo URL('admin/users/activate-deactivate-user') ?>" + '/' + id + '/0';
                }
            });
        });
    });
</script>
@stop