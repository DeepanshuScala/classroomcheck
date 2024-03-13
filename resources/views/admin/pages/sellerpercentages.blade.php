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
            <table id="sellerpercentageList" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Store Name</th>
                        <th>Seller Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Sale Commission</th>
                        <th>Transaction charge Australia</th>
                        <th>Transaction charge Other</th>
                        <th>Sales tax</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                	@foreach($result as $key => $value)
                		@if(isset($value->store) && !empty($value->store))
		                	<tr>
		                		<td>{{$key+1}}</td>
		                		<td>{{isset($value->store) && !empty($value->store)?$value->store->store_name:''}}</td>
		                		<td>{{$value->first_name.' '.$value->surname}}</td>
		                		<td>{{$value->email}}</td>
		                		<td>{{$value->phone}}</td>
		                		<td>{{!empty($value->store->sale_commission)?number_format((float) ($value->store->sale_commission), 2, '.', ''):env('SALE_COMMISION')}}</td>
		                		<td>{{!empty($value->store->transactioncharge_aus)?number_format((float) ($value->store->transactioncharge_aus), 2, '.', ''):env('TRANSACTION_CHARGE_AUS')}}</td>
		                		<td>{{!empty($value->store->transactioncharge_other)?number_format((float) ($value->store->transactioncharge_other), 2, '.', ''):env('TRANSACTION_CHARGE_OTHER')}}</td>
		                		<td>{{!empty($value->store->salestax)?number_format((float) ($value->store->salestax), 2, '.', ''):env('SALE_TAX')}}</td>
		                		<td>
		                			<a class="btn btn-primary btn-xs" title="User Info" href="{{url('/admin/edit-percentages/'.base64_encode($value->id))}}">
	                                    <i class="fa fa-pen"></i>
	                                </a>
	                            </td>
		                	</tr>
		                @endif
	                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

</section>
<!-- /.content -->
@stop