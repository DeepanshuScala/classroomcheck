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
                <div class="col-md-12 mb-5">
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
                            <a class="nav-link ml-2 {{ (request()->segment(3) == 'sellers') ? 'active' : '' }}" href="{{ URL('admin').'/communications/'.base64_encode($users->id)}}}">Communication</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <?php
                    $status = ($users->status == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                    ?>
                    <p class="text-muted text-md"><b>Name : </b> {{ $users->first_name." ".$users->surname }}</p>
                    <p class="text-muted text-md"><b>Email : </b> {{ $users->email }}</p>
                    <p class="text-muted text-md"><b>Store Name : </b> {{ $store->store_name }}</p>
                    @if(request()->segment(2) == 'view-user-info')
                        <p class="text-muted text-md"><b>Contact Number : </b> {{ $users->phone }}</p>
                        <p class="text-muted text-md"><b>Address Line 1 : </b> {{ ($users->address_line1) ?? 'N/A' }}</p>
                        <p class="text-muted text-md"><b>Address Line 2 : </b> {{ ($users->address_line2) ?? 'N/A' }}</p>
                        <p class="text-muted text-md"><b>Postal Code : </b> {{ ($users->postal_code) ?? 'N/A' }}</p>
                        <p class="text-muted text-md"><b>City : </b> {{ ($users->city) ?? 'N/A' }}</p>
                        <p class="text-muted text-md"><b>State : </b> {{ ($users->state_province_region) ?? 'N/A' }}</p>
                        <p class="text-muted text-md"><b>Country : </b> {{ ($users->country) ?? 'N/A' }}</p>
                        <p class="text-muted text-md"><b>About Us : </b> {{ ($users->tell_us_about_you) ?? 'N/A' }}</p>
                        <p class="text-muted text-md"><b>Additional Info : </b> {{ ($users->deatail_additional_information) ?? 'N/A' }}</p>
                        <p class="text-muted text-md"><b>Account Status : </b> <?php echo $status ?></p>
                        <p class="text-muted text-md"><b>Account Created : </b> {{ date('d M, Y',strtotime($users->created_at)) }}</p>
                    @endif
                </div>
                @if(request()->segment(2) == 'view-user-info')
                    <div class="col-6">   
                        <p class="text-muted text-md">
                            <b>Image : </b>
                            <?php if ($users->image != '' && $users->image != null) { ?>
                                <a target="_blank" href="{{ url('storage/uploads/profile_picture/'.$users->image) }}">
                                    <img src="{{ url('storage/uploads/profile_picture/'.$users->image) }}" height="200px" width="200px">
                                </a>
                                <?php
                            } else {
                                echo "N/A";
                            }
                            ?>
                        </p>
                    </div>
                @endif
            </div>
        </div>
        @if(isset($total_sales))
            <div class="card-header text-white">
                <h3 class="card-title">Sales Info</h3>
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
                                    <th>Product Title</th>
                                    <th>Customer Name</th>
                                    <th>Qty</th>
                                    <th>Sale Price</th>
                                    <th>Commission</th>
                                    <th>Transaction Fee</th>
                                    <th>Sales Tax Collected</th>
                                    <th>Earning</th>
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
                                    ?>
                                <tr class="bg-opacity-5">
                                    <td scope="row"><span class="hidde">{{date('m-d-Y',strtotime($sales->created_at))}}</span>{{date('d/m/Y',strtotime($sales->created_at))}}</td>
                                    <td>{{ !empty($sales->order)? $sales->order->order_number : 'Not found' }}</td>



                                    <td>
                                        @if(!empty($sales->product))
                                        <a href="{{route('product.description',Crypt::encrypt($sales->product->id))}}">{{$sales->product->product_title}}</a>
                                        @else
                                        'Deleted Product'
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($sales->user))
                                        <a href="{{URL('admin/users/view-user-info/'.base64_encode($sales->user->id))}}">{{$sales->user->first_name.' '.$sales->user->surname}}</a>
                                        @else
                                        Not Found
                                        @endif
                                    </td>
                                    <td>{{$sales->quantity}}</td>
                                    <td>${{number_format((float)$sales->amount, 2, '.', '')}}</td>
                                    <td>${{number_format((float)$sales->commission, 2, '.', '')}}</td>
                                    <td>${{number_format((float)$sales->transaction_charges, 2, '.', '')}}</td>
                                    <td>${{number_format((float)$sales->sales_tax, 2, '.', '')}}</td>
                                    <td>${{number_format((float)($sales->amount - $sales->commission - $sales->transaction_charges - $sales->sales_tax ), 2, '.', '')}}</td>
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

        @if(isset($total_hostasale))
            <div class="card-header text-white">
                <h3 class="card-title">Host a Sale Info's</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <table>
                            <tbody>
                                <tr>
                                    <td>From:</td>
                                    <td class="pr-3"><input class="form-control form-control-sm" type="date" id="toDate1" data-plugin="datepicker" placeholder="To Date" onchange="selectDate('usersList1')"></td>








                                    <td>To:</td>
                                    <td><input class="form-control form-control-sm" type="date" id="fromDate1" data-plugin="datepicker" placeholder="From Date" onchange="selectDate('usersList1')"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table id="usersList1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Discount %</th>
                                    <th>No. Of Product</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(count($total_hostasale) > 0){
                                ?>
                                @foreach($total_hostasale as $key => $value)
                                <tr class="bg-opacity-5">
                                    <td>{{$key+1}}</td>
                                    <td>{{$value->discount}}%</td>
                                    <td>
                                        <?php  
                                            if($value->products == 'Entire Store'){
                                                echo 'Entire Store';
                                            }
                                            else{
                                                echo count(explode(',', $value->products));
                                            }
                                        ?> 
                                    </td>
                                    <td><span class="hidde">{{date('m-d-Y',strtotime($value->start_date))}}</span>{{date('d/m/Y',strtotime($value->start_date))}}</td>
                                    <td><span class="hidde">{{date('m-d-Y',strtotime($value->end_date))}}</span>{{date('d/m/Y',strtotime($value->end_date))}}</td>
                                    <td><a href="{{route('admin.viewasale').'/'.Crypt::encrypt($value->id)}}"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
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

        @if(isset($confirmedMarketingResult))
            <div class="card-header text-white">
                <h3 class="card-title">Featured Listing</h3>
            </div>
            <div class="card-body">
                <div class="row">
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
                        <table id="usersList" class="table table-bordered table-striped feature">
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
                                if(count($confirmedMarketingResult) > 0){
                                ?>
                                @foreach ($confirmedMarketingResult as $key => $confirmMarketing)
                                <tr class="bg-opacity-5">
                                    <td><span class="hidde">{{date('m-d-Y',strtotime($confirmMarketing['date']))}}</span>{{ date('d/m/Y',strtotime($confirmMarketing['date'])) }}</td>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script type="text/javascript">
    function selectDate(classname) {
        let table = $('#'+classname).DataTable();
        table.draw();
    }
    $(document).ready(function () {
        var table = $('#usersList1').DataTable();
        var headers = table.columns().header().toArray();
        // setTimeout(function(){
        //     $('#usersList thead th:first').click();
        // },500);
        $.fn.dataTable.ext.search.push( function( settings, data, dataIndex ) { 
        
            if(settings.sTableId == 'usersList1'){
                var toDate = $('#toDate1').val();
                var fromDate = $('#fromDate1').val();
                var dateField = data[3];
            }
            else{
                var toDate = $('#toDate').val();
                var fromDate = $('#fromDate').val(); 
                var dateField = data[0];
            }
          
            let formatedToDate = toDate ? new Date(moment(toDate, "YYYY-MM-DD")) : '';
            let formatedFromDate = fromDate ? new Date(moment(fromDate, "YYYY-MM-DD")) : '';
            
            let formatedDateField = dateField ? new Date(moment(dateField, "MM-DD-YYYY")) : '';
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
    });
</script>
@stop