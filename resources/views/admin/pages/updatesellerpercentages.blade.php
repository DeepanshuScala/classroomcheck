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

<!-- Main content -->
<section class="content">

    <div class="card card-blue">
        <div class="card-header">
            <h3 class="card-title">{{$pageHeading}}</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ Session::get('error') }}
            </div>
            @endif
            @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ Session::get('success') }}
            </div>
            @endif
            <form action="" method="post">
                @csrf
                <div class="input-group mb-3">
                    <label class="form-control">Sales Commission</label>
                    <input type="number" step="0.01"  max="0.20" min="0.01" class="form-control" placeholder="sale_commission" name="sale_commission" id="sale_commission" value="{{!empty($user->store->sale_commission)?$user->store->sale_commission:env('SALE_COMMISION')}}" required="">
                </div>
                <div class="input-group mb-3">
                    <label class="form-control">Transaction Charges Australia</label>
                    <input type="number" step="0.01"  max="0.20" min="0.01" class="form-control" placeholder="transactioncharge_aus" name="transactioncharge_aus" id="transactioncharge_aus" value="{{!empty($user->store->transactioncharge_aus)?$user->store->transactioncharge_aus:env('TRANSACTION_CHARGE_AUS')}}" required="">
                </div>
                <div class="input-group mb-3">
                    <label class="form-control">Transaction Charges Other</label>
                    <input type="number" step="0.01"  max="0.20" min="0.01" class="form-control" placeholder="transactioncharge_other" name="transactioncharge_other" id="transactioncharge_other" value="{{!empty($user->store->transactioncharge_other)?$user->store->transactioncharge_other:env('TRANSACTION_CHARGE_OTHER')}}" required="">
                </div>

                <div class="input-group mb-3">
                    <label class="form-control">Sales Tax</label>
                    <input type="number" step="0.01" max="0.20" min="0.01" class="form-control" placeholder="salestax" name="salestax" id="salestax" value="{{!empty($user->store->salestax)?$user->store->salestax:env('SALE_TAX')}}" required="">
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-blue text-white">Update</button>
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>

</section>
<!-- /.content -->
@stop