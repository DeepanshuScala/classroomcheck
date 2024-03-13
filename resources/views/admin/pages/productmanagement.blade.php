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
             <div class="row">
                @if(isset($sellerinfo))
                    <div class="col-md-12 mb-5">
                        <ul class="nav nav-pills justify-content-center">
                            <li class="nav-item users">
                                <a class="nav-link {{ (request()->segment(3) == 'view-user-info') ? 'active' : '' }}" aria-current="page" href="{{ URL('admin/users/view-user-info/'.base64_encode($uid)) }}">Account Details</a>
                            </li>
                            <li class="nav-item users">
                                <a class="nav-link ml-2 {{ (request()->segment(2) == 'products') ? 'active' : '' }}" href="{{ URL('admin').'/products/'.base64_encode($uid)}}">Products</a>
                            </li>
                            <li class="nav-item users">
                                <a class="nav-link ml-2 {{ (request()->segment(2) == 'sells') ? 'active' : '' }}" href="{{url('/admin').'/sells/'.base64_encode($uid)}}">Sales</a>
                            </li>
                            <li class="nav-item users">
                                <a class="nav-link ml-2 {{ (request()->segment(2) == 'promotions') ? 'active' : '' }}" href="{{url('/admin').'/promotions/'.base64_encode($uid)}}">Marketing</a>
                            </li>
                            <li class="nav-item users">
                                <a class="nav-link ml-2 {{ (request()->segment(2) == 'communications') ? 'active' : '' }}" href="{{ URL('admin').'/communications/'.base64_encode($uid)}}">Communication</a>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
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
            <table id="promotionList" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Product No.</th>
                        <th>Date</th>
                        <th>Product Title</th>
                        <th>Category</th>
                        <th>Year Level</th>
                        <th>Resource Type</th>
                        <th>File Type</th>
                        <th>Store Name</th>
                        <th>Total Sales</th>
                        <th>Sale Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($products as $key => $val) {
                    ?>
                        <tr>
                            <td>{{ 1000+$val->id }}</td>
                            <td><span class="hidde">{{date('m-d-Y',strtotime($val->created_at))}}</span>{{ date('d/m/Y',strtotime($val->created_at)) }}</td>

                            <td>
                                <a href="{{route('product.description',Crypt::encrypt($val->id))}}">{{ $val->product_title }}</a>
                            </td>
                            <td>{{ $val->productSubjectArea->name}}</td>
                            <td>
                                <?php
                                    $grdlvl = explode(',',$val->year_level);
                                    
                                    foreach($grdlvl as $key => $glvl){
                                        $g = DB::Table('crc_grade_levels')->select(['grade'])->where('id',$glvl)->first();
                                        echo $g->grade.($key+1 != count($grdlvl)?',':'');
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    $rsrc_type = DB::Table('crc_resource_types')->select(['name'])->where('id',$val->resource_type)->first();
                                    echo $rsrc_type->name;
                                ?>
                            </td>
                            <td>{{ $val->product_type }}</td>
                            <td>
                                <?php
                                    $strname = DB::Table('crc_store')->select(['store_name'])->where('user_id',$val->user_id)->first();

                                ?>
                                <a href="{{URL('admin/users/view-user-info/'.base64_encode($val->user_id))}}"><?php echo $strname->store_name;?></a>
                            </td>
                            <td>
                                <?php
                                    $sales = DB::Table('crc_order_items')->where('product_id',$val->id)->where('type','product')->where('status',1);
                                    echo count($sales->get());
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo '$ '.number_format((float)$val->single_license, 2, '.', '');
                                ?>
                            </td>
                            <td>
                                <a data-id="{{$val->id}}" class="btn btn-danger text-white btn-xs delete-tab-btn" title="Delete Product">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
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
        $(document).ready(function () {
            // setTimeout(function(){
            //     $('#promotionList thead th:first').click();
            // },500);
        });
        $(document).on('click','.delete-tab-btn',function(e){
            e.preventDefault();
            var prod_id = $(this).attr('data-id');
            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                    url: "{{url('admin/delete-product')}}",
                    type: 'POST',
                    data: {product_id: prod_id,_token: '{{ csrf_token() }}'},
                    beforeSend: function (xhr) {

                    }
                }).done(function (response, status, xhr) {
                    if (response.success === true) {
                        location.reload();
                    }
                    if (response.success === false) {

                    }
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
              }
            });
            
        });
    });
</script>
@stop