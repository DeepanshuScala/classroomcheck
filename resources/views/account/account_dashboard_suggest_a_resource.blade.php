@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!--Suggest A Resource resource Section Starts Here-->
<section class="gift_card_section suggest_resource pb-5">
    <div class="container">

        <div class="row flex-lg-row-reverse align-items-start g-4">
            <div class="col-12 col-sm-12 col-lg-6 pt-5">
                <div class="text-end pb-5">
                    <a href="{{ URL('dashboard/account') }}" class="blue acc-dashboard">
                        <img src="{{asset('images/icon-1.png')}}" class="img-fluid me-2 my-1" alt="">Account Dashboard
                    </a>
                </div>
                <img src="{{asset('images/suggest-a-resource.jpg')}}" class="d-block mx-lg-auto img-fluid mb-3" alt="suggest-a-resource">

            </div>

            <div class="col-lg-6 col-sm-12 my-0 py-4">
                <h1 class="text-uppercase pt-5">
                    Suggest a Resource
                </h1>

                <p class="pb-3 ">Tell us what you would like to see more of.</p>

                <form class="pb-5" action="" method="post" name="suggestResourceForm" id="suggestResourceForm">
                    <div class="row mb-4">
                        <label for="name" class="col-sm-3 col-form-label">Name:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control bg-light" id="name" name="name" placeholder="Name" value="{{ old('name') }}">
                        </div>
                    </div>

                    <div class=" row mb-4">
                        <label for="email" class="col-sm-3 col-form-label">Email:</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control bg-light" id="email" name="email" placeholder="Email"  value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="grade_id" class="col-sm-3 col-form-label">Grade:</label>
                        <div class="col-sm-9 ">
                            <?php $gradeArr = (new \App\Http\Helper\ClassroomCopyHelper)->getProductLevel(); ?>
                            <select id="grade_id" class="form-select bg-light noValue" name="grade_id">
                                <option selected value="" disabled="">Select Grade</option>
                                <?php foreach ($gradeArr as $grade) { ?>
                                    <option value="{{ $grade->id }}" <?php if (old('grade_id') == $grade->id) { ?> selected="" <?php } ?>>{{ $grade->grade }}</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="subject_id" class="col-sm-3 col-form-label">Subject:</label>
                        <div class="col-sm-9 ">
                            <?php $subjectArr = DB::Table('crc_subject_details')->where('parent_id', '=', 0)->where('is_deleted', 0)->where('status', 1)->orderBy('parent_id')->get(); ?>
                            <select id="subject_id" name="subject_id" class="form-select bg-light noValue">
                                <option selected value="" disabled="">Select Subject</option>
                                @foreach($subjectArr as $rows)
                                <option value="{{ $rows->id }}" <?php if (old('subject_id') == $rows->id) { ?> selected="" <?php } if ($rows->parent_id == 0) { ?> class="fw-bold" <?php } ?>>{{$rows->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4 ">
                        <label for="resource_id" class="col-sm-3 col-form-label">Type:</label>
                        <div class="col-sm-9 ">
                            <?php $resourceTypeArr = (new \App\Http\Helper\ClassroomCopyHelper)->getResourceTypes(); ?>
                            <select id="resource_id" name="resource_id" class="form-select bg-light noValue">
                                <option selected value="" disabled="">Select Resource</option>
                                <?php foreach ($resourceTypeArr as $resource) { ?>
                                    <option value="{{ $resource->id }}" <?php if (old('resource_id') == $resource->id) { ?> selected="" <?php } ?>>{{ $resource->name }}</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label for="description" class="col-sm-3 col-form-label">Details:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control bg-light" id="description" rows="3" placeholder="Description" name="description">{{ old('description') }}</textarea>
                            <div class="text-end blue character py-2">500 Character Max.</div>
                        </div>
                    </div>

                    <!-- <div class="row mb-4">
                        <label for="other_description" class="col-sm-3 col-form-label ">Other:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control bg-light" id="other_description" name="other_description" rows="3" placeholder="Other">{{ old('other_description') }}</textarea>
                            <div class="text-end blue character py-2">500 Character Max.</div>
                        </div>
                    </div> -->

                    <input type="submit" class="btn bg-blue text-white float-end submit-btn text-uppercase" id="suggestResourceBtn" name="suggestResourceBtn" value="Submit">
                </form>
            </div>
        </div>
    </div>
</section>
<!--Suggest A Resource Ends Section Ends Here-->
@endsection
@push('script')
<script type="text/javascript">
    $(document).ready(function () {
        //gift card payment form
        $("form[name='suggestResourceForm']").submit(function (event) {
            event.preventDefault();
            var err = 0;
            $("#suggestResourceBtn").prop('disabled', true);
            $("#suggestResourceBtn").val('Processing...');

            $("#name").css('border-color', '#E4E4E4');
            $("#email").css('border-color', '#E4E4E4');
            $("#grade_id").css('border-color', '#E4E4E4');
            $("#subject_id").css('border-color', '#E4E4E4');
            $("#resource_id").css('border-color', '#E4E4E4');
            $("#description").css('border-color', '#E4E4E4');
            $("#other_description").css('border-color', '#E4E4E4');
            $("form[name='suggestResourceForm'] .error_msg").remove();

            if ($('#name').val() == '' || $.trim($('#name').val()).length == 0) {
                if ($.trim($('#name').val()).length == 0)
                    $('#name').val('')
                $('#name').focus().select();
                $("#name").css('border-color', 'red');
                $("#name").after('<span class="error text-danger error_msg">Please enter name.</span>');
                $("#suggestResourceBtn").prop('disabled', false);
                $("#suggestResourceBtn").val('Submit');
                return false;
            }
            if ($('#email').val() == '' || $.trim($('#email').val()).length == 0) {
                if ($.trim($('#email').val()).length == 0)
                    $('#email').val('')
                $('#email').focus().select();
                $("#email").css('border-color', 'red');
                $("#email").after('<span class="error text-danger error_msg">Please enter email.</span>');
                $("#suggestResourceBtn").prop('disabled', false);
                $("#suggestResourceBtn").val('Submit');
                return false;
            }
            if ($('#grade_id').val() == '' || $.trim($('#grade_id').val()).length == 0) {
                if ($.trim($('#grade_id').val()).length == 0)
                    $('#grade_id').val('')
                $('#grade_id').focus().select();
                $("#grade_id").css('border-color', 'red');
                $("#grade_id").after('<span class="error text-danger error_msg">Please Select a Grade.</span>');
                $("#suggestResourceBtn").prop('disabled', false);
                $("#suggestResourceBtn").val('Submit');
                return false;
            }
            if ($('#subject_id').val() == '' || $.trim($('#subject_id').val()).length == 0) {
                if ($.trim($('#subject_id').val()).length == 0)
                    $('#subject_id').val('')
                $('#subject_id').focus().select();
                $("#subject_id").css('border-color', 'red');
                $("#subject_id").after('<span class="error text-danger error_msg">Please Select a Subject.</span>');
                $("#suggestResourceBtn").prop('disabled', false);
                $("#suggestResourceBtn").val('Submit');
                return false;
            }
            if ($('#resource_id').val() == '' || $.trim($('#resource_id').val()).length == 0) {
                if ($.trim($('#resource_id').val()).length == 0)
                    $('#resource_id').val('')
                $('#resource_id').focus().select();
                $("#resource_id").css('border-color', 'red');
                $("#resource_id").after('<span class="error text-danger error_msg">Please Select a Resource.</span>');
                $("#suggestResourceBtn").prop('disabled', false);
                $("#suggestResourceBtn").val('Submit');
                return false;
            }
            if ($('#description').val() == '' || $.trim($('#description').val()).length == 0) {
                if ($.trim($('#description').val()).length == 0)
                    $('#description').val('')
                $('#description').focus().select();
                $("#description").css('border-color', 'red');
                $("#description").after('<span class="error text-danger error_msg">Please enter description</span>');
                $("#suggestResourceBtn").prop('disabled', false);
                $("#suggestResourceBtn").val('Submit');
                return false;
            } else {
                if ($.trim($('#description').val()).length > 500) {
                    $("#description").css('border-color', 'red');
                    $('#description').focus().select();
                    $("#description").after('<span class="error text-danger error_msg">Please enter description less than 500 words</span>');
                    $("#suggestResourceBtn").prop('disabled', false);
                    $("#suggestResourceBtn").val('Submit');
                    return false;
                }
            }
            if ($('#other_description').val() != '' && $.trim($('#other_description').val()).length > 500) {
                $('#other_description').focus().select();
                $("#other_description").css('border-color', 'red');
                $("#other_description").after('<span class="error text-danger error_msg">Please enter other description less than 500 words</span>');
                $("#suggestResourceBtn").prop('disabled', false);
                $("#suggestResourceBtn").val('Submit');
                return false;
            }


            if (err == 1) {
                $("#suggestResourceBtn").prop('disabled', false);
                $("#suggestResourceBtn").val('Submit');
                return false;
            } else {
                var frm = $('#suggestResourceForm');
                var formData = new FormData(frm[0]);
                formData.append('_token', "{{ csrf_token() }}");

                $.ajax({
                    url: "{{route('accountDashboard.suggestAresource')}}",
                    type: 'POST',
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false
                }).done(function (response, status, xhr) {
                    if (response.success === true) {
                        $("#suggestResourceBtn").prop('disabled', false);
                        $("#suggestResourceBtn").val('Submit');
                        Swal.fire({
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            title: 'Done',
                            text: "Resource suggested successfully",
                            icon: 'success',
                            showCancelButton: false,
                            buttonsStyling: false,
                            customClass: {
                                confirmButton: 'btn btn-success',
                                //cancelButton: 'btn btn-info mx-2 bg-blue text-white'
                            },
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                        setTimeout(function(){
                            window.location.reload();
                        },3000);
                    }
                    if (response.success === false) {
                        $("#suggestResourceBtn").prop('disabled', false);
                        $("#suggestResourceBtn").val('Submit');
                        swal.fire("Oops!", response.message, "error");
                    }
                }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                    $("#suggestResourceBtn").prop('disabled', false);
                    $("#suggestResourceBtn").val('Submit');
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