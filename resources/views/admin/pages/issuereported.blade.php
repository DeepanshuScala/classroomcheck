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
            @if(isset($uid))
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
            <table id="issuereportedList" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Order Id</th>
                        <th>Product</th>
                        <th>User</th>
                        <th>User Email</th>
                        <th>Seller</th>
                        <th>Subject</th>
                        <th>Issue</th>
                        @if(request()->segment(2) == 'issue-report')
                            <th>Status</th>
                            <th>Action</th>
                            <th>Change Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($sr as $key => $val) {
                        $text = '';
                        switch($val->status){
                            case '0':
                                // code...
                                $text = 'Pending';
                                break;
                            case '1':
                                // code...
                                $text = 'Responded';
                                break;
                            case '2':
                                // code...
                                $text = 'Resolved';
                                break;
                            case '3':
                                // code...
                                $text = 'Archive';
                                break;
                        }
                    ?>
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $val->order_id }}</td>
                            <td>{{ $val->product->product_title }}</td>
                            <td>{{ !empty($val->user)?$val->user->first_name .' '.$val->user->surname:'Deleted user' }}</td>
                            <td><?php if(!empty($val->user)){?><a href="mailto:{{$val->user->email}}">{{$val->user->email}}</a><?php }else{ echo 'Deleted user';} ?></td>
                            <td>
                                <?php $d = DB::table('users')->select(['first_name','surname'])->where('id', $val->product->user_id)->first();
                                ?>
                                {{ $d->first_name .' '.$d->surname}}
                            </td>
                            <td>{{ $val->subject }}</td>
                            <td class="large-content ">
                                <p class="add-read-more show-less-content">{{$val->issue}}</p>
                            </td>
                            @if(request()->segment(2) == 'issue-report')
                                <td><span class="btn text-white btn-xs colorInput">{{ $text }}</span></td>
                                <td><?php if(!empty($val->user)){?><a href="mailto:{{$val->user->email}}" class="btn btn-success btn-xs">Respond</a><?php }else{ echo 'Deleted user';} ?></td>
                                <td>
                                    <form>
                                        <select name="status_change" class="form-control p-0 change-status" data-row-id="{{$val->id}}" onchange="this.className=this.options[this.selectedIndex].className">
                                            <option value="0" class="pending" {{$val->status == 0 ?'Selected':''}}>Pending</option>
                                            <option value="1" class="responded" {{$val->status == 1 ?'Selected':''}}>Responded</option>
                                            <option value="2" class="resolved" {{$val->status == 2 ?'Selected':''}}>Resolved</option>
                                            <option value="3" class="archive" {{$val->status == 3 ?'Selected':''}}>Archive</option>
                                        </select>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

</section>
<!--//send notification Moadal:-->
<div class="modal fade" id="sendbuyernotification" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center" id="error_message">
                    <h3 class="modal-title text-primary" id="staticBackdropLabel">Send Seller Notifiation</h3>
                </div>
                <div class="">
                    <form class="" action="" method="post" name="sendbuyernotification" id="sendnotification">
                        @csrf
                        <input type="hidden" name="buyers" value="all">
                        <input type="hidden" name="resourceid" value="">
                        <div class="my-2 text-center">
                            <input type="submit" class="btn btn-primary btn-round" id="applyGiftCouponFormSubBtn1" value="Send to all" />
                        </div>
                    </form>
                    <p>or<br>
                    Send to Selected</p><br>
                    <form class="" action="" method="post" name="sendbuyernotification" id="sendnotification">
                        @csrf
                        <div class="my-2">
                            <select name="buyers" class="form-control buyers-list"  multiple="multiple">
                                <?php
                                foreach($users as $user){
                                ?>
                                    <option value="{{$user->id}}">{{$user->first_name.' '.$user->surname}}</option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        </br>
                        <input type="hidden" name="resourceid" value="">
                        <div class="my-2 text-center">
                            <input type="submit" class="btn btn-primary btn-round" id="applyGiftCouponFormSubBtn" value="Send" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--//send notification Moadal:-->
<!-- /.content -->
<style type="text/css">
    .add-read-more.show-less-content .second-section,
    .add-read-more.show-less-content .read-less,
    .add-read-more-cart.show-less-content-cart .second-section-cart,
    .add-read-more-cart.show-less-content-cart .read-less-cart {
      display: none;
    }

    .add-read-more.show-more-content .read-more,
    .add-read-more-cart.show-more-content-cart .read-more-cart {
      display: none;
    }
    .add-read-more .read-more,
    .add-read-more .read-less,
    .add-read-more-cart .read-more-cart,
    .add-read-more-cart .read-less-cart {
      font-weight: bold;
      margin-left: 2px;
      cursor: pointer;
      color: #306ec3;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){
        var uri = window.location.href.toString();
        if (uri.indexOf("?") > 0) {
            var clean_uri = uri.substring(0, uri.indexOf("?"));
            window.history.replaceState({}, document.title, clean_uri);
        }
        $(".change-status").on('change',function(){
            window.location.href = '{{Request::url()}}?id='+$(this).attr('data-row-id')+'&status='+$(this).val();
        });
        jQuery(function ($) {
        function AddReadMore() {
          var carLmt = 50;
          var readMoreTxt = " ...Read more";
          var readLessTxt = " Read less";
          $(".add-read-more").each(function () {
             if ($(this).find(".first-section").length)
                return;
             var allstr = $(this).text();
             if (allstr.length > carLmt) {
                var firstSet = allstr.substring(0, carLmt);
                var secdHalf = allstr.substring(carLmt, allstr.length);
                var strtoadd = firstSet + "<span class='second-section'>" + secdHalf + "</span><span class='read-more'  title='Click to Show More'>" + readMoreTxt + "</span><span class='read-less' title='Click to Show Less'>" + readLessTxt + "</span>";
                $(this).html(strtoadd);
             }
          });
          $(document).on("click", ".read-more,.read-less", function () {
             $(this).closest(".add-read-more").toggleClass("show-less-content show-more-content");
          });
        }
        AddReadMore();
        });
    });
</script>
<script type="text/javascript">
    $(function () {
        $('.colorInput').each(function () {
            var status = $(this).closest('span:contains(Pending)').length;
            if (status > 0) {
                $(this).attr('style', 'background-color:orange;')
            }
            var status = $(this).closest('span:contains(Responded)').length;
            if (status > 0) {
                $(this).attr('style', 'background-color:#28a745;')
            }
            var status = $(this).closest('span:contains(Resolved)').length;
            if (status > 0) {
                $(this).attr('style', 'background-color:blue;')
            }
            var status = $(this).closest('span:contains(Archive)').length;
            if (status > 0) {
                $(this).attr('style', 'background-color:red;')
            }  
        });
    });
</script>
@stop