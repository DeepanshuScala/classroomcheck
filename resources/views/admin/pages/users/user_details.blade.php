<?php
if ($users->role_id == 1) {
    $pageHeading = "Buyer";
    $url = URL('admin/users/buyers');
} else if ($users->role_id == 2) {
    $pageHeading = "Seller";
    $url = URL('admin/users/sellers');
} else {
    $pageHeading = "User";
    $url = URL('admin/users/buyers');
}
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
                    <li class="breadcrumb-item active">{{ $pageHeading }} Info</li>
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
            <h3 class="card-title">{{ $pageHeading }} Info</h3>
            <a class="btn btn-warning text-white btn-xs float-right" href="{{ $url }}">
                <i class="fa fa-arrow-left"></i>&nbsp;Back
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                @if($pageHeading == 'Seller')
                    <div class="col-md-12">
                        <ul class="nav nav-pills justify-content-center">
                            <li class="nav-item users">
                                <a class="nav-link {{ (request()->segment(3) == 'view-user-info') ? 'active' : '' }}" aria-current="page" href="{{ URL('admin/users/view-user-info/'.base64_encode($users->id)) }}">Account Details</a>
                            </li>
                            <li class="nav-item users">
                                <a class="nav-link ml-2 {{ (request()->segment(2) == 'products') ? 'active' : '' }}" href="{{ URL('admin').'/products/'.base64_encode($users->id)}}">Products</a>
                            </li>
                            <li class="nav-item users">
                                <a class="nav-link ml-2 {{ (request()->segment(2) == 'sells') ? 'active' : '' }}" href="{{url('/admin').'/sells/'.base64_encode($users->id)}}">Sales</a>
                            </li>
                            <li class="nav-item users">
                                <a class="nav-link ml-2 {{ (request()->segment(2) == 'promotions') ? 'active' : '' }}" href="{{url('/admin').'/promotions/'.base64_encode($users->id)}}">Marketing</a>
                            </li>
                            <li class="nav-item users">
                                <a class="nav-link ml-2 {{ (request()->segment(3) == 'sellers') ? 'active' : '' }}" href="{{ URL('admin').'/communications/'.base64_encode($users->id)}}">Communication</a>
                            </li>
                        </ul>
                    </div>
                @endif
                <div class="col-12">
                    <?php
                    $status = (!$users->is_deleted)?(($users->status == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'):'<span class="badge badge-dark">Deleted</span>';
                    ?>
                    <p class="text-muted text-sm"><b>Name : </b> {{ $users->first_name." ".$users->surname }}</p>
                    <p class="text-muted text-sm"><b>Email : </b> {{ $users->email }}</p>
                    <p class="text-muted text-sm"><b>Contact Number : </b> {{ $users->phone }}</p>
                    <p class="text-muted text-sm"><b>Address Line 1 : </b> {{ ($users->address_line1) ?? 'N/A' }}</p>
                    <p class="text-muted text-sm"><b>Address Line 2 : </b> {{ ($users->address_line2) ?? 'N/A' }}</p>
                    <p class="text-muted text-sm"><b>Postal Code : </b> {{ ($users->postal_code) ?? 'N/A' }}</p>
                    <p class="text-muted text-sm"><b>City : </b> {{ ($users->city) ?? 'N/A' }}</p>
                    <p class="text-muted text-sm"><b>State : </b> {{ ($users->state_province_region) ?? 'N/A' }}</p>
                    <p class="text-muted text-sm"><b>Country : </b> {{ ($users->country) ?? 'N/A' }}</p>
                    <p class="text-muted text-sm"><b>About Us : </b> {{ ($users->tell_us_about_you) ?? 'N/A' }}</p>
                    <p class="text-muted text-sm"><b>Additional Info : </b> {{ ($users->detail_additional_information) ?? 'N/A' }}</p>
                    <p class="text-muted text-sm"><b>Account Status : </b> <?php echo $status ?></p>
                    <p class="text-muted text-sm"><b>Account Created : </b> {{ date('d/m/Y',strtotime($users->created_at)) }}</p>
                    
                    <?php if (isset($users->store)) { ?>
                        <p class="text-muted text-sm">
                            <b>Image : </b>
                            <a target="_blank" href="{{ Storage::disk('s3')->url('store/'.$users->store->store_logo) }}">
                                <img src="{{ Storage::disk('s3')->url('store/'.$users->store->store_logo) }}" width="160px" height="160px" class="rounded-circle">
                            </a>
                        </p>
                    <?php }elseif ($users->image != '' && $users->image != null) { ?>
                        <p class="text-muted text-sm">
                            <b>Image : </b>
                            <a target="_blank" href="{{ Storage::disk('s3')->url('profile_picture/'.$users->image) }}">
                                <img src="{{ Storage::disk('s3')->url('profile_picture/'.$users->image) }}" width="160" height="160" class="rounded-circle">
                            </a>
                        </p>
                        <?php


                    }
                    ?>
                    <?php if (isset($users->store)) { ?>
                    <p class="text-muted text-sm">
                        <b>Store banner : </b>
                        <a target="_blank" href="{{ Storage::disk('s3')->url('store/'.$users->store->store_banner) }}">
                            <img src="{{ Storage::disk('s3')->url('store/'.$users->store->store_banner) }}" width="300" >
                        </a>
                    </p>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
        @if(isset($total_sales) && count($total_sales)>0)
            <div class="card-header text-white">
                <h3 class="card-title">Purchase Info</h3>
            </div>
            <div class="card-body">
                    <div class="row mb-2">

                        <div class="col-12">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>From:</td>
                                        <td class="pr-3"><input class="form-control form-control-sm" type="date" id="toDate" data-plugin="datepicker" placeholder="To Date" onchange="selectDate('usersList')"></td>








                                        <td>To:</td>
                                        <td><input class="form-control form-control-sm" type="date" id="fromDate" data-plugin="datepicker" placeholder="From Date" onchange="selectDate('usersList')"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table id="usersList" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Order ID</th>
                                        <th>Products</th>
                                        <th>Customer Name</th>
                                        <th>Total Amount</th>
                                        <th>Tax Paid</th>
                                        <th>Gift card discount</th>
                                        <th>Promotional discount</th>
                                        <th>Invoice</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($total_sales) > 0){
                                    ?>
                                    @foreach($total_sales as $sales)
                                        <?php
                                        //get seller info
                                        $pr = DB::Table('crc_products')->select(['user_id'])->where('id',$sales->product_id)->first();
                                        $sellerinfo = !empty($pr)?DB::Table('crc_store')->where('user_id',$pr->user_id)->first():[];
                                        // $transaction_charge = (!empty($sales->user) && $sales->user->country != 'Aus') ?(!empty($sellerinfo->transactioncharge_other)?$sellerinfo->transactioncharge_other:env('TRANSACTION_CHARGE_OTHER')):(!empty($sellerinfo->transactioncharge_aus)?$sellerinfo->transactioncharge_aus:env('TRANSACTION_CHARGE_AUS'));
                                        // $sale_tax = !empty($sellerinfo->salestax)?$sellerinfo->salestax:env('SALE_TAX');
                                        // $sales_commission = !empty($sellerinfo->sale_commission)?$sellerinfo->sale_commission:env('SALE_COMMISION');
                                        // $sales_commission = (new \App\Http\Helper\Web)->checkifsellerundermembership($pr->user_id,$sales->created_at,$sales_commission);
                                        // if(!empty($sales->product)){
                                        //     $sellerinfo = DB::Table('crc_store')->where('id',$sales->product->store_id)->first();
                                        //     $transaction_charge = (!empty($sales->user) && $sales->user->country != 'Aus')?(!empty($sellerinfo->transactioncharge_other)?$sellerinfo->transactioncharge_other:env('TRANSACTION_CHARGE_OTHER')):(!empty($sellerinfo->transactioncharge_aus)?$sellerinfo->transactioncharge_aus:env('TRANSACTION_CHARGE_AUS')); 

                                        //         $sale_tax = !empty($sellerinfo->salestax)?$sellerinfo->salestax:$sale_tax;
                                        //         $sales_commission = !empty($sellerinfo->sale_commission)?$sellerinfo->sale_commission:$sales_commission;
                                        //         $sales_commission = (new \App\Http\Helper\Web)->checkifsellerundermembership($pr->user_id,$sales->created_at,$sales_commission);
                                        // }
                                        $invoice = Storage::disk('s3')->url('orderinvoice/' .$sales->order_number.'.pdf');
                                        ?>
                                    <tr class="bg-opacity-5">
                                        <td scope="row"><span class="hidde">{{date('m-d-Y',strtotime($sales->created_at))}}</span>{{date('d/m/Y',strtotime($sales->created_at))}}</td>
                                        <td>{{$sales->order_number}}</td>
                                        <td>
                                            @if(count($sales->orderProduct)>0)
                                                @foreach($sales->orderProduct as $k => $sproduct)
                                                    @if($sproduct->type == 'product')
                                                        @php
                                                            $productinfo = DB::Table('crc_products')->where('id',$sproduct->product_id)->first();
                                                        @endphp
                                                        <a href="{{route('product.description',Crypt::encrypt($sproduct->product_id))}}">{{$productinfo->product_title}}</a>
                                                    @elseif($sproduct->type == 'gift')
                                                        <p>Gift Card</p>
                                                    @else
                                                        <p>Deleted Product</p>
                                                    @endif
                                                    @if(count($sales->orderProduct)>$k+1)
                                                        ,
                                                    @endif
                                                @endforeach
                                            @else
                                            Deleted Product
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($sales->user))
                                            <a href="{{URL('admin/users/view-user-info/'.base64_encode($sales->user->id))}}">{{$sales->user->first_name.' '.$sales->user->surname}}</a>
                                            @else
                                            Not Found
                                            @endif
                                        </td>
                                        <td>${{number_format((float)$sales->total_amount+$sales->buyer_tax, 2, '.', '')}}</td>
                                        <td>${{number_format((float)$sales->buyer_tax, 2, '.', '')}}</td>
                                        <td>{{$sales->coupon_type==1?'':'-'}}</td>
                                        <td>{{$sales->coupon_type==2?'$'.number_format((float)$sales->coupon_discount_amount, 2, '.', ''):'-'}}</td>
                                        <td><a href="{{$invoice}}" target="_blank">Show Invoice</a></td>
                                    </tr>
                                    @endforeach
                                    <?php
                                    }
                                    else{
                                    ?>
                                    <tr>
                                        <td colspan="10"><p class="w-auto m-auto btn btn-hover btn-lg px-3 ">No data found</p></td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        @endif
        <!-- /.card-body -->
    </div>

</section>
<!-- /.content -->


@stop


@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        // setTimeout(function(){
        //     $('#usersList thead th:first').click();
        // },500);
    });
</script>
@stop