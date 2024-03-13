@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<section class="inner_page">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="inner_page_title">
                    <h1>Card List</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="store-dashboard my-md-0 my-3">
                    <a href="{{ URL('/buyer/payment-system') }}">
                        <img src="{{asset('images/store-icon.png')}}" class="img-fluid me-1 my-1"> Payment Systems
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if (Session::has('error')) {
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
<?php } if (Session::has('success')) { ?>
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
<section class="add_product_section">
    <div class="container">
        <div class="row mb-3">
            <?php
            if (count($data['result']) > 0) {
                foreach ($data['result'] as $row) {
                    $cardNumberArr = str_split(base64_decode($row['card_number']), 4);
                    ?>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4">
                        <div class="card-payment-list">
                            <h6>{{ $row['brand'] }} <span><sup>****</sup>{{ $cardNumberArr[3] }}</span></h6>
                            <p class="card-holder-name">{{ $row['card_holder_name'] }}</p>
                            <div class="d-flex justify-content-between">
                                <a href="{{ URL('/buyer/update-card').'/'.$row['id'] }}" class="btn-hover btn btn-primary bg-blue btn-lg px-4 my-2 me-2 w-50 text-uppercase">
                                    Edit
                                </a>
                                <a class="btn-hover btn btn-primary bg-blue btn-lg px-4 my-2 ms-2 text-uppercase removeCard w-50" data-id="{{$row['id']}}">
                                    Remove                                 
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-12 col-sm-6 col-md-6 col-lg-6 mb-5">
                        <div class="align-items-center">
                            <div class="card p-3 bank_card">
                                <div class="d-flex justify-content-between align-items-center">
                                    <img src="https://i.imgur.com/gfp4wrR.png" width="50" />  
                                    <h1>{{ $row['brand'] }}</h1>
                                </div>
                                <div class="px-2 card_number mt-3 d-flex justify-content-between align-items-center">
                                    <span>{{ $cardNumberArr[0] }}</span>
                                    <span>{{ $cardNumberArr[1] }}</span>
                                    <span>{{ $cardNumberArr[2] }}</span>
                                    <?php //if (isset($cardNumberArr[3])) { ?>
                                        <span>{{ $cardNumberArr[3] }}</span>
                                    <?php// } ?>
                                </div>
                                <div class="p-4 bank_card_border mt-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="cardholder">Card Holder</span>
                                        <span class="card_expires">Expires</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="card_name">{{ $row['card_holder_name'] }}</span>
                                        <span class="card_date">{{ $row['exp_month']."/".$row['exp_year'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <a href="{{ URL('/buyer/update-card').'/'.$row['id'] }}" class="btn btn-warning btn-sm mt-3">
                                    <i class="fa fa-pencil fa-lg text-light"></i>
                                </a>
                                <a class="btn btn-danger btn-sm mt-3 ml-3 removeCard" data-id="{{$row['id']}}">
                                    <i class="fa fa-trash fa-lg text-light"></i>
                                </a>
                            </div>
                        </div>
                    </div> -->
                    <?php
                }
            } else {
                ?>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="alert alert-danger" role="alert">
                        No Card Exist Yet
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>


@endsection
@push('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-creditcardvalidator/1.2.0/jquery.creditCardValidator.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //remove card
        $('.removeCard').click(function (e) {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this card!",
                icon: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-info ms-2'
                },
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?php echo URL('/buyer/remove-card') ?>" + '/' + id;
                }
            });
        });
    });
</script>
@endpush