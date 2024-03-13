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
            <table id="promotionList" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 50px;">Client No.</th>
                        <th>Date Joined</th>
                        <th>Customer Name</th>
                        <th>Store Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $usersarr = [];
                    foreach ($users as $key => $val){
                        if($val->role_id == 1){
                            $usersarr[$val->email]['customer_name'] = $val->first_name.' '.$val->surname;
                        
                            $usersarr[$val->email]['dj'] = date('d/m/Y',strtotime($val->created_at));
                            $usersarr[$val->email]['djsrt'] = date('m-d-Y',strtotime($val->created_at));
                        
                            $usersarr[$val->email]['buyerlink'] = URL('admin/users/view-user-info/'.base64_encode($val->id));
                        }
                        else{
                            $usersarr[$val->email]['sellerid'] = $val->id;
                            if(!isset($usersarr[$val->email]['customer_name'])){
                                $usersarr[$val->email]['customer_name'] = $val->first_name.' '.$val->surname;
                            }
                            if(!isset($usersarr[$val->email]['dj'])){
                                $usersarr[$val->email]['dj'] = date('d/m/Y',strtotime($val->created_at));
                                $usersarr[$val->email]['djsrt'] = date('m-d-Y',strtotime($val->created_at));
                            }
                            
                            if($val->process_completion == 3){
                                $strname = DB::Table('crc_store')->select(['store_name'])->where('user_id',$val->id)->first();
                                $usersarr[$val->email]['store_name'] = !empty($strname)?$strname->store_name:'';
                                $usersarr[$val->email]['sellerlink'] = URL('admin/users/view-user-info/'.base64_encode($val->id));
                            }
                        }
                        
                    }
                    $i=1;
                    foreach($usersarr as $k => $ar){
                        if(isset($ar['store_name'])){
                    ?>
                        <tr>
                            <td>{{$i}}</td>
                            <td><span class="hidde">{{$ar['djsrt']}}</span>{{$ar['dj']}}</td>
                            <td>
                                <?php
                                    if(isset($ar['customer_name'])){
                                ?>
                                {{$ar['customer_name']}}
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
                            <td>
                                <a class="btn btn-primary btn-xs" title="User Info" href="{{ URL('admin/featured-listing-details/'.base64_encode($ar['sellerid'])) }}">
                                    <i class="fa fa-eye"></i>
                            </td>
                        </tr>  
                    <?php 
                            $i++;
                        }
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
        setTimeout(function(){
            $('#promotionList thead th:first').click();
        },500);
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