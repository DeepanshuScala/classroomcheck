@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!-- page title start -->
<section class="inner_page">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="inner_page_title">
                    <h1>My Classroom Contributions</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="store-dashboard my-md-0 my-3">
                     <a href="{{route('accountDashboard.contributions')}}"><img src="{{asset('images/store-icon.png')}}" class="img-fluid me-1 my-1"> Classroom Contributions</a>
                </div>
            </div>
        </div>                    
        <div class="row justify-content-end">
            <div class="col-md-5 text-end">
                <ul class="navbar list-edit mb-0 mt-4 ps-0" id="view-menu-list">  
                    <li>
                        <a href="{{route('accountDashboard.classroomContributions')}}">Add a listing</a>
                    </li>
                    <li>
                        <a href="{{route('accountDashboard.contributionsEditView')}}">Edit Listings</a>
                    </li>
                    <li>
                        <a href="{{route('accountDashboard.contributionsView')}}">View Listings</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- page title end  -->

<!-- Book Bin products section start -->
<section class="contribution-main new-contribution">
    <div class="container">
        <!-- <div class="row mb-4 mb-md-5">
            <div class="col-12">
                <h4>HELP YOUR COMMUNITY PURCHASE QUALITY EDUCATIONAL RESOURCES</h4>
            </div>
        </div> -->
        <form class="" name="editContributionForm" id="editContributionForm" method="post" enctype="multipart/form-data">
            <input type="hidden" name="contribution_id" id="contribution_id" value="{{ $data['result']->id }}">
            <div class="row mb-4 align-items-center">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>Username:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <p class="mb-0">{{ $data['result']->user_name }}</p>

                    </div>
                </div>
            </div>
            <div class="row position-relative">
                <div class="col-md-6">
                    <div class="row mb-4 align-items-center">
                        <div class="col-md-4 col-12">
                            <div class="labels">
                                <p>First Name:</p>
                            </div>
                        </div>
                        <div class="col-md-8 col-12">
                            <div class="profile-txt ">
                                <input type="text" id="first_name" name="first_name" value="{{ $data['result']->first_name }}" class="form-custom-input" placeholder="Enter first name ">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-4 align-items-center">
                        <div class="col-md-4 col-12">
                            <div class="labels">

                                <p>Last Name:</p>
                            </div>
                        </div>
                        <div class="col-md-8 col-12">
                            <div class="profile-txt ">
                                <input type="text" id="surname" name="surname" value="{{ $data['result']->surname }}" class="form-custom-input" placeholder="Enter last name ">
                            </div>
                        </div>
                    </div>
                </div>
                <!--                <button type="button" class="pen-edit setup-edit border-0 bg-transparent position-absolute top-0 text-end">
                                    <img src="{{asset('images/pen-edit.png')}}" class="img-fluid">
                                </button>-->
            </div>
            <div class="row mb-4 position-relative">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>Fundraising Title:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <input type="text" id="fundraising_title" name="fundraising_title" value="{{ $data['result']->fundraising_title }}" class="form-custom-input" placeholder="Enter fundraising title  (max. 100 Characters)">
                    </div>
                </div>
                <!--                <button type="button" class="pen-edit setup-edit border-0 bg-transparent position-absolute top-0 text-end">
                                    <img src="{{asset('images/pen-edit.png')}}" class="img-fluid">
                                </button>-->
            </div>
            <div class="row mb-4  position-relative">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>Fundraising Slogan:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <input type="text" id="fundraising_slogan" name="fundraising_slogan" value="{{ $data['result']->fundraising_slogan }}" class="form-custom-input" placeholder="Enter fundraising slogan  (max. 100 Characters)">
                    </div>
                </div>
                <!--                <button type="button" class="pen-edit setup-edit border-0 bg-transparent position-absolute top-0 text-end">
                                    <img src="{{asset('images/pen-edit.png')}}" class="img-fluid">
                                </button>-->
            </div>
            <div class="row mb-4 position-relative">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>Fundraising Banner:</p>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="profile-txt mb-md-0 mb-3">
                        <div class="drop-zone">
                            @if(!empty(@$data['result']->fundraising_banner))
                            <?php 
                            $fundraising_banner = url('storage/uploads/contributions/' . $data['result']->fundraising_banner);
                            ?>
                            <div class="drop-zone__thumb" data-label="1662377127_store_banner.jfif" style="background-image:url('{{$fundraising_banner}}')"></div>
                            @else
                            <h4 class="drop-zone__prompt">Banner Image 
                                <small>Select file or <br>
                                    drag and drop<br>
                                    Max 5 MB</small>
                            </h4>
                            @endif
                            <input type="file" name="fundraising_banner" id="fundraising_banner" class="drop-zone__input" accept="image/jpg,image/png,image/jpeg,image/JPG,image/JPEG,image/PNG">
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-4 col-12">
                    <img src="{{ url('storage/uploads/contributions/' . $data['result']->fundraising_banner) }}" class="img-fluid">
                </div> -->
                <!--                <button type="button" class="pen-edit setup-edit border-0 bg-transparent position-absolute top-0 text-end">
                                    <img src="{{asset('images/pen-edit.png')}}" class="img-fluid">
                                </button>-->
            </div>
            <div class="row mb-4 position-relative">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>About the Fundraiser:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ">
                        <textarea type="text" id="about_fundraiser" name="about_fundraiser" class="form-custom-input " rows="6" placeholder="Enter about the fundraiser  (max. 2000 Characters)">{{ $data['result']->about_fundraiser }}</textarea>
                    </div>
                </div>
                <!--                <button type="button" class="pen-edit setup-edit border-0 bg-transparent position-absolute top-0 text-end">
                                    <img src="{{asset('images/pen-edit.png')}}" class="img-fluid">
                                </button>-->
            </div>
            <div class="row mb-4 position-relative">
                <div class="col-md-2 col-12">
                    <div class="labels">
                        <p>Target Amount:</p>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="profile-txt ms-12">
                        <div class="row">
                            <div class="col-1 lic-paid">
                                <span>AUD $</span>
                            </div>
                            <div class="col-11 ps-0">
                                <input type="number" onkeypress="return /[0-9]/i.test(event.key)" value="{{ $data['result']->target_amount }}" id="target_amount" name="target_amount" class="form-custom-input" placeholder="Enter amount" min="1">
                            </div>
                        </div>
                    </div>
                </div>
                <!--                <button type="button" class="pen-edit setup-edit border-0 bg-transparent position-absolute top-0 text-end">
                                    <img src="{{asset('images/pen-edit.png')}}" class="img-fluid">
                                </button>-->
            </div>
            <div class="row mb-4 mt-5">
                <div class="col-md-2 col-12">
                </div>
                <div class="col-md-10 col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked="">
                        <label class="form-check-label" for="flexCheckDefault">
                            I agree that all funds received via Classroom Contributions will be credited to my Classroom Copy Account, with the deduction of related or outstanding fees. I also understand that these credits cannot be redeemed for cash or transferred to other accounts.
                        </label>
                    </div>
                    <p class="text-danger text-sm" style="display: none" id="checkBoxError">Please check checkbox to proceed</p>
                </div>

            </div>

            <div class="row text-center mt-5">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary bg-blue btn-lg px-5 py-3  btn-hover text-uppercase" id="UpdateContributionSubBtn">Update</button>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- book bin products section end  -->
@endsection

@push('script')
<script>
    $(function(){
    var current = location.pathname;
    $('#view-menu-list li a').each(function(){
        var $this = $(this);
        // if the current path is like this link, make it active
        if($this.attr('href').indexOf(current) !== -1){
            $this.addClass('active-nav');
        }
    })
})
</script>
<script>
    //$(document).ready(function () {
    $("form[name='editContributionForm']").submit(function (event) {
        event.preventDefault();
        var contribution_id = $('#contribution_id').val();
        $("#UpdateContributionSubBtn").prop('disabled', true);
        $("#UpdateContributionSubBtn").html('Processing...');
        $("#user_name").css('border', '0px');
        $("#first_name").css('border', '0px');
        $("#surname").css('border', '0px');
        $("#fundraising_title").css('border', '0px');
        $("#fundraising_slogan").css('border', '0px');
        $("#about_fundraiser").css('border', '0px');
        $("#target_amount").css('border', '0px');
        $('#checkBoxError').css('display', 'none');
        $(".drop-zone").parent('.profile-txt').css('border', '0px');
        var fundraising_banner = $('#fundraising_banner').prop('files')[0];
        
        

        if ($('#first_name').val() == '' || $.trim($('#first_name').val()).length == 0) {
            if ($.trim($('#first_name').val()).length == 0)
                $('#first_name').val('')
            $('#first_name').focus().select();
            $("#first_name").css('border', '1px solid red');
            $("#first_name").after('<span class="error text-danger error_msg">Enter your first name</span>');
            $("#UpdateContributionSubBtn").prop('disabled', false);
            $("#UpdateContributionSubBtn").html('Set up now');
            return false;
        }
        else if($.trim($('#first_name').val()).length > 100){
            $('#first_name').focus().select();
            $("#first_name").css('border', '1px solid red');
            $("#first_name").after('<span class="error text-danger error_msg">Please Enter Max 100 character First Name.</span>');
            $("#UpdateContributionSubBtn").prop('disabled', false);
            $("#UpdateContributionSubBtn").html('Set up now');
            return false;
        }

        if ($('#surname').val() == '' || $.trim($('#surname').val()).length == 0) {
            if ($.trim($('#surname').val()).length == 0)
                $('#surname').val('')
            $('#surname').focus().select();
            $("#surname").css('border', '1px solid red');
            $("#surname").after('<span class="error text-danger error_msg">Enter your Last name</span>');
            $("#UpdateContributionSubBtn").prop('disabled', false);
            $("#UpdateContributionSubBtn").html('Set up now');
            return false;
        }
        else if($.trim($('#surname').val()).length > 100){
            $('#surname').focus().select();
            $("#surname").css('border', '1px solid red');
            $("#surname").after('<span class="error text-danger error_msg">Please Enter Max 100 character last name.</span>');
            $("#UpdateContributionSubBtn").prop('disabled', false);
            $("#UpdateContributionSubBtn").html('Set up now');
            return false;
        }

        if ($('#fundraising_title').val() == '' || $.trim($('#fundraising_title').val()).length == 0) {
            if ($.trim($('#fundraising_title').val()).length == 0)
                $('#fundraising_title').val('')
            $('#fundraising_title').focus().select();
            $("#fundraising_title").css('border', '1px solid red');
            $("#fundraising_title").after('<span class="error text-danger error_msg">Enter your fundraising title</span>');
            $("#UpdateContributionSubBtn").prop('disabled', false);
            $("#UpdateContributionSubBtn").html('Set up now');
            return false;
        }
        else if($.trim($('#fundraising_title').val()).length > 100){
            $('#fundraising_title').focus().select();
            $("#fundraising_title").css('border', '1px solid red');
            $("#fundraising_title").after('<span class="error text-danger error_msg">Please Enter Max 100 character Fundraising Title.</span>');
            $("#UpdateContributionSubBtn").prop('disabled', false);
            $("#UpdateContributionSubBtn").html('Set up now');
            return false;
        }

        if ($('#fundraising_slogan').val() == '' || $.trim($('#fundraising_slogan').val()).length == 0) {
            if ($.trim($('#fundraising_slogan').val()).length == 0)
                $('#fundraising_slogan').val('')
            $('#fundraising_slogan').focus().select();
            $("#fundraising_slogan").css('border', '1px solid red');
            $("#fundraising_slogan").after('<span class="error text-danger error_msg">Enter your fundraising slogan</span>');
            $("#UpdateContributionSubBtn").prop('disabled', false);
            $("#UpdateContributionSubBtn").html('Set up now');
            return false;
        }
        else if($.trim($('#fundraising_slogan').val()).length > 100){
            $('#fundraising_slogan').focus().select();
            $("#fundraising_slogan").css('border', '1px solid red');
            $("#fundraising_slogan").after('<span class="error text-danger error_msg">Please Enter Max 100 character Fundraising Slogan.</span>');
            $("#UpdateContributionSubBtn").prop('disabled', false);
            $("#UpdateContributionSubBtn").html('Set up now');
            return false;
        }

        // if (fundraising_banner == undefined) {
            
        //     $(".drop-zone").parent('.profile-txt').css('border', '1px solid red');
        //     $(".banner-img ").after('<span class="error text-danger error_msg">Please Add a banner.</span>');
        //     $('#fundraising_banner').focus().select();
        //     $("#fundraising_banner").css('border', '1px solid red');
        //     $("#UpdateContributionSubBtn").prop('disabled', false);

        //     $("#UpdateContributionSubBtn").html('Set up now');
        //     return false;
        // }
        if ($('#about_fundraiser').val() == '' || $.trim($('#about_fundraiser').val()).length == 0) {
            if ($.trim($('#about_fundraiser').val()).length == 0)
                $('#about_fundraiser').val('')
            $('#about_fundraiser').focus().select();
            $("#about_fundraiser").css('border', '1px solid red');
            $("#about_fundraiser").after('<span class="error text-danger error_msg">Enter your About the Fundraiser.</span>');
            $("#UpdateContributionSubBtn").prop('disabled', false);
            $("#UpdateContributionSubBtn").html('Set up now');
            return false;
        }
        else if($.trim($('#about_fundraiser').val()).length > 2000){
            $('#about_fundraiser').focus().select();
            $("#about_fundraiser").css('border', '1px solid red');
            $("#about_fundraiser").after('<span class="error text-danger error_msg">Please Enter Max 2000 character About the Fundraiser.</span>');
            $("#UpdateContributionSubBtn").prop('disabled', false);
            $("#UpdateContributionSubBtn").html('Set up now');
            return false;
        }
        if ($('#target_amount').val() == '' || $.trim($('#target_amount').val()).length == 0) {
            if ($.trim($('#target_amount').val()).length == 0)
                $('#target_amount').val('')
            $('#target_amount').focus().select();
            $("#target_amount").css('border', '1px solid red');
            $("#UpdateContributionSubBtn").prop('disabled', false);
            $("#UpdateContributionSubBtn").html('Update');
            return false;
        }
        if (!$("#flexCheckDefault").is(":checked")) {
            $('#checkBoxError').css('display', 'block');
            $("#UpdateContributionSubBtn").prop('disabled', false);
            $("#UpdateContributionSubBtn").html('Update');
            return false;
        }

        var frm = $('#editContributionForm');
        var formData = new FormData(frm[0]);
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('contribution_id', contribution_id);
        console.log(formData);

        $.ajax({
            url: "{{URL('/account-dashboard/contributions-edit')}}" + "/" + contribution_id,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false
        }).done(function (response, status, xhr) {
            if (response.success === true) {
                $("#UpdateContributionSubBtn").prop('disabled', false);
                $("#UpdateContributionSubBtn").html('Update');
                Swal.fire({
                    title: 'Done',
                    text: "Contribution Updated successfully",
                    icon: 'success',
                    showCancelButton: true,
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-info mx-2 bg-blue text-white'
                    },
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{route('accountDashboard.contributionsView')}}";
                    }
                });
                setTimeout(function(){
                     window.location.href = "{{route('accountDashboard.contributionsView')}}";
                },3000);
            }
            if (response.success === false) {
                $("#UpdateContributionSubBtn").prop('disabled', false);
                $("#UpdateContributionSubBtn").html('Update');
                swal.fire("Oops!", response.message, "error");
            }
        }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
            $("#UpdateContributionSubBtn").prop('disabled', false);
            $("#UpdateContributionSubBtn").html('Update');
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
    });
    //});
</script>
@endpush