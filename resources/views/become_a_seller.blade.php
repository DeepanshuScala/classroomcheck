@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<?php
$is_process_completed = 0;
$isproductadded = false;
if (Auth::check()) {
    $checkproduct = DB::Table('crc_products')->where('user_id',auth()->user()->id)->get();
    if(count($checkproduct)>0){
        $isproductadded = true;
    } 
    $is_process_completed = auth()->user()->process_completion;
}
$getofferbanner = DB::Table('seller_offer')->first();
if (Session::has('error')) {
    ?>
    <script>
        Swal.fire({
            title: 'Oops!',
            text: "{{ Session::get('error') }}",
            icon: 'error',
            showConfirmButton: false,
            timer: 2000,
            //closeOnClickOutside: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
        });
    </script>
<?php }if (Session::has('success')) { ?>
    <script>
        Swal.fire({
            title: 'Congratulations!',
            text: "{{ Session::get('success') }}",
            icon: 'success',
            showConfirmButton: false,
            timer: 2000,
            //closeOnClickOutside: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
        });
    </script>
<?php } ?>
<!-- page title start -->
<section class="inner_page">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="inner_page_title">
                    <h1 class="mb-3">sell your resources</h1>
                    <p>Your own online store is simply a few steps away!
                    </p>
                </div>
            </div>
            <?php if (Auth::check() && (auth()->user()->role_id == 2 && auth()->user()->process_completion == 3)) { ?>
                <div class="col-md-4">
                    <div class="store-dashboard my-md-0 my-3">
                        <a href="{{ URL('dashboard/seller') }}">
                            <img src="{{asset('images/store-icon.png')}}" class="img-fluid me-1 my-1"> Store Dashboard
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="row mt-5">
            @if(!empty($getofferbanner) && !empty($getofferbanner->banner))
                <div class="col-12">
                    <div class="become-banner1 text-center">
                        <a href="{{ route('storeDashboard.aboutSelling') }}">
                            <img src="{{url('storage/uploads/selleroffer/'.$getofferbanner->banner)}}" class="d-none1 d-md-block w-100 img-fluid" alt="slide-1">
                        </a>
                            <!-- <div class="become-bnr-txt">
                                <h1 class="blue">BECOME A SELLER</h1>
                                @if((new \App\Http\Helper\Web)->checkofferstatus())
                                    <p class="lead">Start selling today to receive 100% on all sales.</p>
                                @endif
                                <h6 class="blue text-uppercase condition-apply">Conditions apply</h6>
                                <a href="{{ route('storeDashboard.aboutSelling') }}">
                                <button type="button" class="find-out-more btn btn-primary bg-blue btn-lg px-4 my-3 me-md-2 text-uppercase btn-hover">Find Out More</button>
                                </a>
                            </div> -->
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>


<!-- page title end  -->
<!-- Book Bin products section start -->
<section class="products_dashboard">
    <div class="container">
        <div class="row align-items-top mb-5">
            <div class="col-lg-4 col-md-4">
                <div class="das-box text-center mb-md-0 mb-4">
                    <img src="{{asset('images/user-plus-icon.png')}}" alt="products icon" class="img-fluid ">
                    <h4>Step 1</h4>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="right-product-details">
                    <h4>Become a member of Classroom Copy</h4>
                    <p>Whether you are buying or selling, you will need to become a member of Classroom Copy.<br>
                        Don’t worry…it’s FREE to join!
                    </p>
                    <?php if (Auth::check() && auth()->user()->role_id == 2) { ?>
                        <a type="button" href="javascript:void(0)" class="bg-black btn btn-primary bg-blue btn-lg px-5 py-2 btn-hover text-uppercase">Sign up Completed</a>
                        
                    <?php } else if (Auth::check() && auth()->user()->role_id == 1) { ?>
                        <a type="button" href="javascript:void(0)" onclick="unauthorize_user(); return false;" class="btn btn-primary bg-blue btn-lg px-5 py-2 btn-hover text-uppercase">Complete Sign Up</a>
                    <?php } else { ?>
                        <a type="button" href="{{route('store.dashboard.join.now')}}" class="btn btn-primary bg-blue btn-lg px-5 py-2 btn-hover text-uppercase">Complete Sign Up</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="row align-items-top mb-5">
            <div class="col-lg-4 col-md-4">
                <div class="das-box text-center mb-md-0 mb-4">
                    <img src="{{asset('images/home-setting.png')}}" alt="products icon" class="img-fluid ">
                    <h4>Step 2</h4>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="right-product-details">
                    <h4>Set Up Your Store</h4>
                    <p>Setup your store now by creating a store name,
                        adding a logo and banner and providing other
                        relevant information.
                    </p>
                    @if(Auth::check() && auth()->user()->role_id == 2)
                    @if($data['is_store_added'] == 0)
                    <a type="button" href="{{route('storeDashboard.storeSetup')}}" class="btn btn-primary bg-blue btn-lg px-5 py-2 btn-hover text-uppercase">Set Up Store</a>
                    @else
                    <a type="button" href="{{route('storeDashboard.storeSetup')}}" class="btn btn-primary bg-blue btn-lg px-5 py-2 btn-hover text-uppercase bg-black">Update Store</a>
                    @endif
                    @endif
                    @if(Auth::check() && auth()->user()->role_id == 1)
                    <a type="button" href="javascript:void(0)" onclick="unauthorize_user(); return false;" class="btn btn-primary bg-blue btn-lg px-5 py-2 btn-hover text-uppercase">Set Up Store</a>
                    @endif
                    @if(!Auth::check())
                    <a type="button" href="javascript:void(0)" onclick="unauthorize_user(); return false;" class="btn btn-primary bg-blue btn-lg px-5 py-2 btn-hover text-uppercase">Set Up Store</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row align-items-top mb-5">
            <div class="col-lg-4 col-md-4">
                <div class="das-box text-center mb-md-0 mb-4">
                    <img src="{{asset('images/card-cloud.png')}}" alt="products icon" class="img-fluid ">
                    <h4>Step 3</h4>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="right-product-details">
                    <h4>Set up Payment System</h4>
                    <p>Setup a Stripe account to send and receive payments.

                    </p>
                    @if(Auth::check() && auth()->user()->role_id == 2)
                    @if(auth()->user()->process_completion == 2)
                    <a type="button" href="{{ URL('/store-payment-setup') }}" class="btn btn-primary bg-blue btn-lg px-5 py-2 btn-hover text-uppercase">Complete Payment System</a>
                    @elseif(auth()->user()->process_completion == 3)
                    <a type="button" href="javascript:void(0)" class="btn btn-primary bg-blue btn-lg px-5 py-2 btn-hover text-uppercase bg-black">Payment System Completed</a>
                    @else
                    <a type="button" href="javascript:void(0)" onclick="process_not_completed('payment'); return false;" class="btn btn-primary bg-blue btn-lg px-5 py-2 btn-hover text-uppercase">Complete Payment System</a>
                    @endif
                    @endif
                    @if(Auth::check() && auth()->user()->role_id == 1)
                    <a type="button" href="javascript:void(0)" onclick="unauthorize_user(); return false;" class="btn btn-primary bg-blue btn-lg px-5 py-2 btn-hover text-uppercase">Complete Payment System</a>
                    @endif
                    @if(!Auth::check())
                    <a type="button" href="javascript:void(0)" onclick="unauthorize_user(); return false;" class="btn btn-primary bg-blue btn-lg px-5 py-2 btn-hover text-uppercase">Complete Payment System</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row align-items-top">
            <div class="col-lg-4 col-md-4">
                <div class="das-box text-center mb-md-0 mb-4">
                    <img src="{{asset('images/upload-blue-icon.png')}}" alt="products icon" class="img-fluid ">
                    <h4>Step 4</h4>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="right-product-details">
                    <h4>Add Products To Your Store</h4>
                    <p>Whether you are buying or selling, you will need to become a member of Classroom Copy.<br>
                        Don’t worry…it’s FREE to join!                    
                    </p>
                    @if(Auth::check() && auth()->user()->role_id == 2)
                    @if(auth()->user()->process_completion == 3)
                    <a type="button" href="{{route('storeDashboard.addProduct')}}" class="btn btn-primary {{$isproductadded?'bg-black':''}} bg-blue btn-lg px-5 py-2 btn-hover text-uppercase">Add Products</a>
                    @else
                    <a type="button" href="javascript:void(0)" class="btn btn-primary bg-blue btn-lg px-5 py-2 btn-hover text-uppercase" onclick="process_not_completed('product'); return false;">Add Products</a>
                    @endif
                    @endif
                    @if(Auth::check() && auth()->user()->role_id == 1)
                    <a type="button" href="javascript:void(0)" onclick="unauthorize_user(); return false;" class="btn btn-primary bg-blue btn-lg px-5 py-2 btn-hover text-uppercase">Add Products</a>
                    @endif
                    @if(!Auth::check())
                    <a type="button" href="javascript:void(0)" onclick="unauthorize_user(); return false;" class="btn btn-primary bg-blue btn-lg px-5 py-2 btn-hover text-uppercase">Add Products</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- book bin products section end  -->
@endsection

@push('script')
<script>
    $(document).ready(function () {
        $('#isAdminRelative').click(function () {
            Swal.fire({
                title: 'Are you sure',
                text: "You want to send request for admin relative?",
                icon: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-info mx-2 bg-blue text-white'
                },
                confirmButtonText: 'Yes, Relative'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?php echo URL('/add-admin-relative') ?>";
                }
            });
        });
    });
    function unauthorize_user() {
        Swal.fire({
            title: 'Oops!',
            text: 'Please register/login as a Store User to process Store Set Up.',
            icon: 'error',
            showConfirmButton: false,
            timer: 2000,
            //closeOnClickOutside: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
        });
    }
    function process_not_completed(type) {
        var is_process_completed = "{{ $is_process_completed }}";
        var title = "Oops!";
        var alertType = "error";
        if (type == 'payment') {
            if (is_process_completed == 0)
                var msg = "Please complete register process to set up payment";
            if (is_process_completed == 1)
                var msg = "Please add store to set up payment";
            if (is_process_completed == 3) {
                var msg = "Payment system completed";
                title = "";
                alertType = "success";
            }
        }
        if (type == 'product') {
            if (is_process_completed == 0)
                var msg = "Please complete register process to add product";
            if (is_process_completed == 1)
                var msg = "Please add store to add product";
            if (is_process_completed == 2)
                var msg = "Please complete all 3 step to add products.";
        }
        Swal.fire({
            title: title,
            text: msg,
            icon: alertType,
            showConfirmButton: false,
            timer: 2000,
            //closeOnClickOutside: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
        });
    }
</script>
@endpush