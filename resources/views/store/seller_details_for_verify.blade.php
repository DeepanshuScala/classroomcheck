@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@if(!auth()->user())
@section('breadcrub_section')
<section class="breadcrumb-section bg-light-blue pt-2">
    <div class="container py-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a><i class='fal fa-home-alt'></i> Home</a></li>
                <li class="breadcrumb-item" aria-current="page">User</li>
            </ol>
        </nav>
    </div>
</section>
@endsection('breadcrub_section')
@endif
@section('content')
<?php if ($data['userDetails'] == null) { ?>
    <div class="alert alert-danger">
        <p>User Not Valid</p>
    </div>
<?php } else if ($data['userDetails']->is_admin_relative == 2 || $data['userDetails']->is_admin_relative == 3) { ?>
    <div class="alert alert-danger">
        <p>Link Expired</p>
    </div>
<?php } else {
    ?>
    <!-- Book Bin products section start -->
    <section class="contribution-main">
        <div class="container">
            <div class="row mb-3 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>Name:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <p>{{ $data['userDetails']->first_name." ".$data['userDetails']->surname }}</p>
                    </div>
                </div>
            </div>
            <div class="row mb-3 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>Email:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <p>{{ $data['userDetails']->email }}</p>
                    </div>
                </div>
            </div>
            <div class="row mb-3 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>Address Line1:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <p>{{ ($data['userDetails']->address_line1) ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <div class="row mb-3 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>Address Line2:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <p>{{ ($data['userDetails']->address_line2) ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <div class="row mb-3 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>City:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <p>{{ ($data['userDetails']->city) ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <div class="row mb-3 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>State:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <p>{{ ($data['userDetails']->state_province_region) ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <div class="row mb-3 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>Country:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <p>{{ ($data['userDetails']->country) ?? 'N/A' }}</p>

                    </div>
                </div>
            </div>
            <div class="row mb-3 ">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>Zip/Postal Code:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <p>{{ ($data['userDetails']->postal_code) ?? 'N/A' }}</p>

                    </div>
                </div>
            </div>

            <div class="row text-center my-4 mt-5">
                <div class="col-12">
                    <button type="button" data-id="{{ $data['userDetails']->id }}" id="approve" class="btn btn-primary bg-blue btn-lg px-5 py-3  btn-hover text-uppercase">Approve</button>
                    <button type="button" data-id="{{ $data['userDetails']->id }}" id="reject" class="btn btn-primary bg-blue btn-lg px-5 py-3  btn-hover text-uppercase">Reject</button>
                </div>
            </div>
        </div>
    </section>
    <!-- book bin products section end  -->
<?php } ?>
@endsection

@push('script')
<script>
    //approve user
    $(document).on('click', '#approve', function (e) {
        e.preventDefault();
        var user_id = $(this).data("id");
        var $this = $(this);
        Swal.fire({
            title: 'Are you sure',
            text: "You want to approve user?",
            icon: 'warning',
            showCancelButton: true,
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-info mx-2 bg-blue text-white'
            },
            confirmButtonText: 'Yes, Approve it'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{URL('/verify/relative')}}",
                    type: 'POST',
                    data: {user_id: user_id, status: 2, _token: '{{ csrf_token() }}'},
                    beforeSend: function (xhr) {
                        $this.prop('disabled', true);
                        $('#reject').prop('disabled', true);
                    }
                }).always(function () {
                    $this.prop('disabled', false);
                    $('#reject').prop('disabled', false);
                }).done(function (response, status, xhr) {
                    $this.prop('disabled', false);
                    $('#reject').prop('disabled', false);
                    if (response.success == false) {
                        swal.fire("Unauthorized!", response.message, "error");
                    } else {
                        swal.fire("congratulations!", response.message, "success");
                        $this.hide();
                        $('#reject').hide();
                    }
                }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                    $this.prop('disabled', false);
                    $('#reject').prop('disabled', false);
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
    //reject user
    $(document).on('click', '#reject', function (e) {
        e.preventDefault();
        var user_id = $(this).data("id");
        var $this = $(this);
        Swal.fire({
            title: 'Are you sure',
            text: "You want to reject user?",
            icon: 'warning',
            showCancelButton: true,
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-info mx-2 bg-blue text-white'
            },
            confirmButtonText: 'Yes, Reject it'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{URL('/verify/relative')}}",
                    type: 'POST',
                    data: {user_id: user_id, status: 3, _token: '{{ csrf_token() }}'},
                    beforeSend: function (xhr) {
                        $this.prop('disabled', true);
                        $('#approve').prop('disabled', true);
                    }
                }).always(function () {
                    $this.prop('disabled', false);
                    $('#approve').prop('disabled', false);
                }).done(function (response, status, xhr) {
                    $this.prop('disabled', false);
                    $('#approve').prop('disabled', false);
                    if (response.success == false) {
                        swal.fire("Unauthorized!", response.message, "error");
                    } else {
                        swal.fire("congratulations!", response.message, "success");
                        $this.hide();
                        $('#approve').hide();
                    }
                }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                    $this.prop('disabled', false);
                    $('#approve').prop('disabled', false);
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
</script>
@endpush
