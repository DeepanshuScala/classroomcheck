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
             <div class="row mb-2">
                <div class="col-12">
                    <table>
                        <tbody>
                            <tr>
                                <td>From:</td>
                                <td class="pr-3"><input class="form-control form-control-sm" type="date" id="toDate" data-plugin="datepicker" placeholder="To Date" onchange="selectDate('promotionList')"></td>








                                <td>To:</td>
                                <td><input class="form-control form-control-sm" type="date" id="fromDate" data-plugin="datepicker" placeholder="From Date" onchange="selectDate('promotionList')"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <table id="membermanagementList" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Client No.</th>
                        <th>Date Joined</th>
                        <th>Customer Name</th>
                        <th>Store Name</th>
                        <th>Account Type</th>
                        <th>Buyer Account Status</th>
                        <th>Seller Account Status</th>
                        <th>No. of Purchases</th>
                        <th>Total Purchases $</th>
                        <th>Customer Action</th>
                        <th>Seller Action</th>
                        <th>Delete</th>
                        <th>No. of Sales</th>
                        <th>Total Sales $</th>
                        <th>Country</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $usersarr = [];
                    foreach ($users as $key => $val){
                        if($val->role_id == 1){
                            $usersarr[$val->email]['customerid'] = $val->id;
                            $usersarr[$val->email]['customerstatus'] = $val->status;
                            $usersarr[$val->email]['customer_is_deleted'] = $val->is_deleted;
                            $usersarr[$val->email]['customer_name'] = $val->first_name.' '.$val->surname;
                            
                            //Get Purchases
                            $purchases = DB::Table('crc_order_items')->where('user_id',$val->id)->where('type','product')->where('status',1); 
                            $usersarr[$val->email]['numberofpurchases'] = count($purchases->get());
                            $usersarr[$val->email]['totalpurchases'] = number_format((float)$purchases->sum('amount'), 2, '.', '');
                            $usersarr[$val->email]['country'] = $val->country;
                            $usersarr[$val->email]['status'] = $val->status == 1 ? 'Active':'In-active';
                            $usersarr[$val->email]['type'] = 'Buyer';
                            $usersarr[$val->email]['dj'] = date('d/m/Y',strtotime($val->created_at));
                            $usersarr[$val->email]['djsrt'] = date('m-d-Y',strtotime($val->created_at));
                            
                            $usersarr[$val->email]['id'] = $val->id;
                            $usersarr[$val->email]['buyerlink'] = URL('admin/users/view-user-info/'.base64_encode($val->id));
                        }
                        else{
                            $usersarr[$val->email]['sellerid'] = $val->id;
                            $usersarr[$val->email]['sellerstatus'] = $val->status;
                            $usersarr[$val->email]['seller_is_deleted'] = $val->is_deleted;
                            if(!isset($usersarr[$val->email]['customer_name'])){
                                $usersarr[$val->email]['customer_name'] = $val->first_name.' '.$val->surname;
                            }
                            if(!isset($usersarr[$val->email]['country'])){
                                $usersarr[$val->email]['country'] = $val->country;
                            }
                            if(!isset($usersarr[$val->email]['status'])){
                                $usersarr[$val->email]['status'] = $val->status == 1 ? 'Active':'In-active';
                            }
                            if(!isset($usersarr[$val->email]['dj'])){
                                $usersarr[$val->email]['dj'] = date('d/m/Y',strtotime($val->created_at));
                                $usersarr[$val->email]['djsrt'] = date('m-d-Y',strtotime($val->created_at));
                            }
                           
                            if(!isset($usersarr[$val->email]['id'])){
                                $usersarr[$val->email]['id'] = $val->id;
                            }
                            
                            if($val->process_completion == 3){
                                
                                if(isset($usersarr[$val->email]['type'])){
                                    $usersarr[$val->email]['type'] .= '/Seller';
                                }
                                else{
                                    $usersarr[$val->email]['type'] = 'Seller';    
                                }
                                
                                $strname = DB::Table('crc_store')->select(['store_name'])->where('user_id',$val->id)->first();
                                $usersarr[$val->email]['store_name'] = !empty($strname)?$strname->store_name:'';

                                //Get Sales
                                $seller_prods = [];
                                $get_seller_prods = DB::Table('crc_products')->select(['id'])->where('user_id',$val->id)->where('is_paid_or_free','paid')->get();
                                if(count($get_seller_prods)>0){
                                    foreach($get_seller_prods as $pro){
                                        $seller_prods[] = $pro->id;
                                    }
                                }
                                $sales = DB::Table('crc_order_items')->whereIn('product_id',$seller_prods)->where('type','product')->where('status',1); 
                                $usersarr[$val->email]['numberofsales'] = count($sales->get()); 
                                $usersarr[$val->email]['totalsales'] = number_format((float)$sales->sum('amount'), 2, '.', '');
                                $usersarr[$val->email]['sellerlink'] = URL('admin/users/view-user-info/'.base64_encode($val->id));
                            }
                        }
                        
                    }
                    $i=1;
                    foreach($usersarr as $k => $ar){
                    ?>
                        <tr>
                            <td>{{$i}}</td>
                            <td><span class="hidde">{{$ar['djsrt']}}</span>{{$ar['dj']}}</td>
                            <td>
                                <?php
                                    if(isset($ar['customer_name'])){
                                ?>
                                <a href="{{isset($ar['buyerlink'])?$ar['buyerlink']:'#'}}">{{$ar['customer_name']}}</a>
                                <?php
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if(isset($ar['store_name'])){
                                ?>
                                <a href="{{$ar['sellerlink']}}">{{$ar['store_name']}}</a>
                                <?php
                                    }
                                ?>
                            </td>
                            <td>{{isset($ar['type'])?$ar['type']:''}}</td>
                            <td>
                                <?php
                                    if(isset($ar['customerstatus']) && $ar['customerstatus']){
                                ?>
                                    <span class="badge badge-success">Active</span>
                                <?php
                                    }
                                    elseif(isset($ar['customer_is_deleted']) && $ar['customer_is_deleted']){
                                ?>
                                    <span class="badge badge-dark">Deleted</span>
                                <?php
                                    }
                                    else{
                                ?>
                                    <span class="badge badge-danger">Inactive</span>
                                <?php
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if($ar['sellerstatus']){
                                ?>
                                    <span class="badge badge-success">Active</span>
                                <?php
                                    }
                                    elseif($ar['seller_is_deleted']){
                                ?>
                                    <span class="badge badge-dark">Deleted</span>
                                <?php
                                    }
                                    else{
                                ?>
                                    <span class="badge badge-danger">Inactive</span>
                                <?php
                                    }
                                ?>
                            </td>
                            <td>{{isset($ar['numberofpurchases'])?$ar['numberofpurchases']:'0'}}</td>
                            <td>{{isset($ar['totalpurchases'])?'$ '.$ar['totalpurchases']:'$ 0'}}</td>
                            
                            <td>
                                @if(!$ar['customer_is_deleted'])
                                    @if(isset($ar['customerstatus']) && !$ar['customerstatus'])
                                        <a data-id="{{isset($ar['customerid'])?$ar['customerid']:''}}" class="btn btn-success btn-xs activateUser" title="Activate User">
                                            <i class="fa fa-check-square"></i>
                                        </a>
                                    @else
                                        <a data-id="{{isset($ar['customerid'])?$ar['customerid']:'' }}" class="btn btn-danger text-white btn-xs deactivateUser" title="Deactivate User">
                                            <i class="fa fa-ban"></i>
                                        </a>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if(!$ar['seller_is_deleted'])
                                    @if(!$ar['sellerstatus'])
                                        <a data-id="{{ $ar['sellerid'] }}" class="btn btn-success btn-xs activateUser" title="Activate User">
                                            <i class="fa fa-check-square"></i>
                                        </a>
                                    @else
                                        <a data-id="{{ $ar['sellerid'] }}" class="btn btn-danger text-white btn-xs deactivateUser" title="Deactivate User">
                                            <i class="fa fa-ban"></i>
                                        </a>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if(!$ar['seller_is_deleted'])
                                    <a data-id="{{ $ar['id'] }}" class="btn btn-danger btn-xs deleteUser" title="Delete User">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                @endif
                            </td>
                            <td>{{isset($ar['numberofsales'])?$ar['numberofsales']:'0'}}</td>
                            <td>{{isset($ar['totalsales'])?'$ '.$ar['totalsales']:'$ 0.00'}}</td>
                            <td>{{isset($ar['country'])?$ar['country']:''}}</td>
                        </tr>  
                    <?php 
                    $i++;
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
        setTimeout(function(){
            $('#usersList thead th:first').click();
        },500);
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
        //delete user
        $(document).on('click', '.deleteUser', function (e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete account for this user!",
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
                    window.location.href = "<?php echo URL('admin/users/delete-user') ?>" + '/' + id ;
                }
            });
        });
    });
</script>
@stop