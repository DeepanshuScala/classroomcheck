@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Seller Payouts</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a class="text-blue" href="{{ URL('admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Seller Payouts</li>
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
            <table id="promotionList" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Store Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Total Sales</th>
                        <th>Amount to be paid</th>
                        <th>Commission</th>
                        <th>Transaction Charges</th>
                        <th>Sales Tax</th>
                        <th>Amount Already paid</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($sellers as $key => $val) {
                        $sellerinfo = DB::Table('crc_store')->where('user_id',$val->id)->first();
                        $totalsales = 0;
                        $amounttobepaid = 0;
                        $commissioncollected = 0;
                        $transactioncollected = 0;
                        $salestaxcollected = 0;
                        $amountalreadypaid = 0;
                        $payoutinfo = DB::Table('seller_payout_cron_history')->where('seller_user_id',$val->id)->get();
                        foreach($payoutinfo as $pinfo){
                            if(!$pinfo->payout_status){
                                $amounttobepaid += $pinfo->payout_amount;
                            }
                            else{
                                $amountalreadypaid += $pinfo->payout_amount;
                            }
                            $totalsales += $pinfo->payout_amount+$pinfo->commission+$pinfo->transaction_charges+$pinfo->sales_tax;
                            $commissioncollected += $pinfo->commission;
                            $transactioncollected += $pinfo->transaction_charges;
                            $salestaxcollected += $pinfo->sales_tax;
                        }
                    ?>
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $val->first_name }}</td>
                            <td><a href="{{url('/admin').'/sells/'.base64_encode($val->id)}}">{{ $sellerinfo->store_name}}</a></td>
                            <td>{{ $val->email }}</td>
                            <td>{{ $val->phone }}</td>
                            <td>{{'$ '.number_format((float)$totalsales, 2, '.', '')}}
                                <?php
                                /*
                                    $get_prodids = DB::Table('crc_products')->where('user_id',$val->id)->pluck('id')->toArray(); 
                                   
                                    $sellerSellingHistory = DB::Table('crc_order_items')->whereIn('product_id', $get_prodids)
                                                            ->where('status', 1)->where('type','product')
                                                            ->get();
                                    $payOutSellingProdIds = $sellerSellingHistory->pluck('id')->toArray();
                                    $sellerSellingTotalSum  =   DB::Table('crc_order_items')->whereIn('id', $payOutSellingProdIds)->where('type','product')->sum('amount');
                                    echo '$ '.$sellerSellingTotalSum;
                                    $sellerSellingTotalSum  =   DB::Table('crc_order_items')->whereIn('id', $payOutSellingProdIds)->where('type','product')->get();
                                    $sales_tax = 0;
                                    $commission = 0;
                                    $transaction_charge_ttl = 0;
                                    foreach($sellerSellingTotalSum as $ttl1){
                                        $usrinfo = DB::Table('users')->where('id',$ttl1->user_id)->first();

                                        $prodct = DB::Table('crc_products')->where('id',$ttl1->product_id)->first();
                                        
                                        $sellerinfo = DB::Table('crc_store')->where('user_id',$prodct->user_id)->first();
                                        $transaction_charge = ( !empty($usrinfo) && $usrinfo->country != 'Aus') ?(!empty($sellerinfo->transactioncharge_other)?$sellerinfo->transactioncharge_other:env('TRANSACTION_CHARGE_OTHER')):(!empty($sellerinfo->transactioncharge_aus)?$sellerinfo->transactioncharge_aus:env('TRANSACTION_CHARGE_AUS'));
                                        $salescommission = !empty($sellerinfo->sale_commission)?$sellerinfo->sale_commission:env('SALE_COMMISION');
                                        $salescommission = (new \App\Http\Helper\Web)->checkifsellerundermembership($prodct->user_id,$ttl1->created_at,$salescommission);
                                        $salestax = !empty($sellerinfo->salestax)?$sellerinfo->salestax:env('SALE_TAX');

                                        $transaction_charge_ttl += $ttl1->amount*$transaction_charge;
                                        $commission += $ttl1->amount*$salescommission;
                                        $sales_tax += $ttl1->amount*$salestax;
                                    }
                                */
                                ?> 
                            </td>
                            <td>{{'$ '.number_format((float)$amounttobepaid, 2, '.', '')}}
                                <?php
                                /*
                                    $sellerSellingHistory = DB::Table('crc_order_items')->whereIn('product_id', $get_prodids)
                                                            ->where('payout_status', 0)->where('type','product')->where('status', 1)
                                                            ->get();
                                    $payOutSellingProdIds = $sellerSellingHistory->pluck('id')->toArray();
                                    $sellerSellingTotalSum  =   DB::Table('crc_order_items')->whereIn('id', $payOutSellingProdIds)->where('type','product')->get();
                                    $earnings = 0;
                                    foreach($sellerSellingTotalSum as $ttl){
                                        $usrinfo = DB::Table('users')->where('id',$ttl->user_id)->first();
                                        
                                        $prodct = DB::Table('crc_products')->where('id',$ttl->product_id)->first();

                                        $sellerinfo = DB::Table('crc_store')->where('user_id',$prodct->user_id)->first();
                                        $transaction_charge = ( !empty($usrinfo) && $usrinfo->country != 'Aus') ?(!empty($sellerinfo->transactioncharge_other)?$sellerinfo->transactioncharge_other:env('TRANSACTION_CHARGE_OTHER')):(!empty($sellerinfo->transactioncharge_aus)?$sellerinfo->transactioncharge_aus:env('TRANSACTION_CHARGE_AUS'));
                                        $salescommission = !empty($sellerinfo->sale_commission)?$sellerinfo->sale_commission:env('SALE_COMMISION');
                                        $salescommission = (new \App\Http\Helper\Web)->checkifsellerundermembership($prodct->user_id,$ttl->created_at,$salescommission);
                                        $salestax = !empty($sellerinfo->salestax)?$sellerinfo->salestax:env('SALE_TAX');
                                        $earnings  += $ttl->amount - $ttl->amount*$salescommission - $ttl->amount*$transaction_charge - $ttl->amount*$salestax;
                                    }
                                    echo '$ '.number_format((float)$earnings, 2, '.', '');
                                */
                                ?>
                            </td>
                            <td>{{'$ '.number_format((float)$commissioncollected, 2, '.', '')}}</td>
                            <td>{{'$ '.number_format((float)$transactioncollected, 2, '.', '')}}</td>
                            <td>{{'$ '.number_format((float)$salestaxcollected, 2, '.', '')}}</td>
                            <td>{{'$ '.number_format((float)$amountalreadypaid, 2, '.', '')}}
                                <?php
                                /*
                                    $earnings = 0;
                                    $sellerSellingHistory   =   DB::Table('crc_order_items')->whereIn('product_id', $get_prodids)
                                                            ->where('payout_status', 1)
                                                            ->get();
                                    $payOutSellingProdIds   =   $sellerSellingHistory->pluck('id')->toArray();
                                    $sellerSellingTotalSum  =   DB::Table('crc_order_items')->whereIn('id', $payOutSellingProdIds)->get();
                                    foreach($sellerSellingTotalSum as $t){
                                        $usrinfo = DB::Table('users')->where('id',$t->user_id)->first();

                                        $prodct = DB::Table('crc_products')->where('id',$t->product_id)->first();
                                        
                                        $sellerinfo = DB::Table('crc_store')->where('user_id',$prodct->user_id)->first();
                                        
                                        $transaction_charge = ( !empty($usrinfo) && $usrinfo->country != 'Aus') ?(!empty($sellerinfo->transactioncharge_other)?$sellerinfo->transactioncharge_other:env('TRANSACTION_CHARGE_OTHER')):(!empty($sellerinfo->transactioncharge_aus)?$sellerinfo->transactioncharge_aus:env('TRANSACTION_CHARGE_AUS'));
                                        $salescommission = !empty($sellerinfo->sale_commission)?$sellerinfo->sale_commission:env('SALE_COMMISION');
                                        $salescommission = (new \App\Http\Helper\Web)->checkifsellerundermembership($prodct->user_id,$t->created_at,$salescommission);
                                        $salestax = !empty($sellerinfo->salestax)?$sellerinfo->salestax:env('SALE_TAX');

                                        $earnings  += $t->amount - $t->amount*$salescommission - $t->amount*$transaction_charge - $t->amount*$salestax;
                                    }
                                    echo '$ '.number_format((float)$earnings, 2, '.', '');
                                */
                                ?>
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
<script type="text/javascript">
    
</script>
@stop