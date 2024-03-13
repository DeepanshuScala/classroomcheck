<style>   
    .switch {
        position: relative;
        float: right;
        display: inline-block;
        width: 60px;
        height: 28px;
    }
    .no, .yes{
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        -webkit-transition: .4s;
        transition: .4s;
    }
    .no {
        background-color: #ccc;
    }
    .yes{
         background-color: #4bb553;
    }
    .no:before, .yes:before {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    
    bottom: 3px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    }
    .no:before{
        left: 4px;
    }
    .yes:before {
        right: 4px;
    }
    .round {
    border-radius: 34px;
    }
    .round:before {
    border-radius: 50%;
    }
    .round:before {
    border-radius: 50%;
    }
    #usersList span.hidde{
        display:none; 
    }
</style>
<?php
if (request()->segment(3) == 'buyers')
    $pageHeading = "Buyer";
else if (request()->segment(3) == 'sellers')
    $pageHeading = "Seller";
else
    $pageHeading = "User";
?>
@extends('admin.layouts.master')
@section('title', $pageHeading)
@section('content')
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
                    <li class="breadcrumb-item active">{{ $pageHeading }}s</li>
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
            <h3 class="card-title">{{ $pageHeading }}s</h3>
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
            <div class="col-md-12">
                <ul class="nav nav-pills justify-content-center">
                    <li class="nav-item users">
                        <a class="nav-link {{ (request()->segment(3) == 'buyers') ? 'active' : '' }}" aria-current="page" href="{{ URL('admin/users/buyers')}}">Buyers</a>
                    </li>
                    <li class="nav-item users">
                        <a class="nav-link ml-2 {{ (request()->segment(3) == 'sellers') ? 'active' : '' }}" href="{{ URL('admin/users/sellers')}}">Sellers</a>
                    </li>
                    <!--li class="nav-item users">
                        <a class="nav-link ml-2" href="">Moderators</a>
                    </li-->
                </ul>
            </div>
            <table id="usersList" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Account Status</th>
                        <th>Registration Date</th>
                        @if($pageHeading == 'Buyer')
                            <th>Newsletter</th>
                        @endif
                        @if($pageHeading == 'Seller')
                            <th>Admin Relative</th>
                        @endif
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($users as $key => $val) {
                        $statusTxt = ($val->is_deleted == 0) ? (($val->status == 0) ? 'Inactive' : 'Active'):'Deleted';
                        $statusCls = ($val->is_deleted == 0) ? (($val->status == 0) ? 'danger' : 'success'):'dark';
                        ?>
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $val->first_name." ".$val->surname }}</td>
                            <td>{{ $val->email }}</td>
                            <td>{{ $val->phone }}</td>
                            <td><span class="badge badge-{{$statusCls}}">{{ $statusTxt }}</span></td>
                            <td><span class="hidde">{{date('m-d-Y',strtotime($val->created_at))}}</span>{{ date('d/m/Y',strtotime($val->created_at)) }}</td>
                            @if($pageHeading == 'Buyer')
                                @if(!$val->is_deleted)
                                    @if(!$val->getUserSettings->newsletter)
                                        <td>
                                            <a data-id="{{ $val->id }}" class="btn btn-success text-white btn-xs subscribe" data-value="1" title="Subscribe">
                                                    <i class="fa fa-check-square"></i>
                                            </a>
                                        </td>
                                    @else
                                        <td>
                                            <a data-id="{{ $val->id }}" class="btn btn-danger text-white btn-xs subscribe" data-value="0" title="unsubscribe" data-value="0">
                                                    <i class="fa fa-ban"></i>
                                            </a>
                                        </td>
                                    @endif
                                @else
                                <td></td>
                                @endif
                            @endif
                            @if($pageHeading == 'Seller')
                                <td>
                                    @if(!$val->is_deleted)
                                        {{$val->is_admin_relative==2?'Yes':'No'}}
                                        @if($val->is_admin_relative != 2)
                                            <!-- <span class="badge badge-success">
                                                <a href="{{Request::url().'?id='.$val->id.'&make_admin=1'}}" style="color:black;">Make admin relative</a>
                                            </span> -->
                                            <label class="switch">
                                                <a href="{{Request::url().'?id='.$val->id.'&make_admin=1'}}" style="color:black;"><span class="slider round no"></span></a>
                                            </label>
                                        @elseif($val->is_admin_relative == 2)
                                            <label class="switch">
                                                <a href="{{Request::url().'?id='.$val->id.'&remove_admin=1'}}" style="color:black;"><span class="slider round yes"></span></a>
                                            </label>
                                            <!-- <span class="badge badge-danger">
                                                <a href="{{Request::url().'?id='.$val->id.'&remove_admin=1'}}" style="color:black;">Make Not admin relative</a>
                                            </span> -->
                                        @endif
                                    @endif
                                </td>
                            @endif
                            <td>
                                <a class="btn btn-primary btn-xs" title="User Info" href="{{ URL('admin/users/view-user-info/'.base64_encode($val->id)) }}">
                                    <i class="fa fa-eye"></i>
                                </a>
                                @if(!$val->is_deleted)
                                    @if($val->status == 0)
                                        <a data-id="{{ $val->id }}" class="btn btn-success btn-xs activateUser" title="Activate User">
                                            <i class="fa fa-check-square"></i>
                                        </a>
                                    @else
                                        <a data-id="{{ $val->id }}" class="btn btn-danger text-white btn-xs deactivateUser" title="Deactivate User">
                                            <i class="fa fa-ban"></i>
                                        </a>
                                    @endif
                                @endif
                                @if($pageHeading == 'Seller')
                                <!-- <span class="badge badge-success">
                                    <a href="{{url('/admin').'/sells/'.base64_encode($val->id)}}" style="color:black;">Check Sales</a>
                                </span> 
                                <span class="badge badge-success">
                                    <a href="{{url('/admin').'/promotions/'.base64_encode($val->id)}}" style="color:black;">Check Promotions</a>
                                </span> -->
                                @endif
                                &nbsp;
                                <!--a data-id="{{ $val->id }}" class="btn btn-danger btn-xs deleteUser" title="Delete User">
                                    <i class="fa fa-trash"></i>
                                </a-->
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


@stop


@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        setTimeout(function(){
            $('#usersList thead th:first').click();
        },500);
        var uri = window.location.href.toString();
        if (uri.indexOf("?") > 0) {
            var clean_uri = uri.substring(0, uri.indexOf("?"));
            window.history.replaceState({}, document.title, clean_uri);
        }
        //delete user popup
        $(document).on('click', '.deleteUser', function (e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this user!",
                icon: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-info ml-3'
                },
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?php echo URL('admin/users/delete-user') ?>" + '/' + id;
                }
            });
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

        //Newsletter activate/deactivate
        $(document).on('click','.subscribe',function(e){
            var id = $(this).data('id');
            var text = 'You want to unsubscribe newsletter for this user!';
            if($(this).data('value') == 1){
                text = 'You want to subscribe newsletter for this user!'
            }
            Swal.fire({
                title: 'Are you sure?',
                text: text,
                icon: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-info ml-3'
                },
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?php echo URL('admin/subscribe/') ?>/var id = $(this).data('id');"+id;
                }
            });
        });
    });
</script>
@stop