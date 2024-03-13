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
                    <div class="row mb-3">
                        <label for="name" class="col-sm-3 col-form-label">Name:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control bg-light" id="name" name="name" placeholder="Name" required="" value="{{ old('name') }}">
                        </div>
                    </div>

                    <div class=" row mb-3">
                        <label for="email" class="col-sm-3 col-form-label">Email Address :</label>
                        <div class="col-sm-9">
                            <input type="email " class="form-control bg-light" id="email" name="email" placeholder="Email" required="" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="grade_id" class="col-sm-3 col-form-label">Grade:</label>
                        <div class="col-sm-9 ">
                            <?php $gradeArr = (new \App\Http\Helper\ClassroomCopyHelper)->getProductLevel(); ?>
                            <select id="grade_id" class="form-select bg-light" name="grade_id" required="">
                                <option selected value="" disabled="">Select Grade</option>
                                <?php foreach ($gradeArr as $grade) { ?>
                                    <option value="{{ $grade->id }}" <?php if (old('grade_id') == $grade->id) { ?> selected="" <?php } ?>>{{ $grade->grade }}</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="subject_id" class="col-sm-3 col-form-label">Subject:</label>
                        <div class="col-sm-9 ">
                            <?php $subjectArr = (new App\Http\Helper\Web)->getAllSubjectTree(); ?>
                            <select id="subject_id" name="subject_id" class="form-select bg-light" required="">
                                <option selected value="" disabled="">Select Subject</option>
                                @foreach($subjectArr as $rows)
                                <option value="{{ $rows['id'] }}" <?php if (old('subject_id') == $rows['id']) { ?> selected="" <?php } if ($rows['parent_id'] == 0) { ?> class="fw-bold" <?php } ?>>{{$rows['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3 ">
                        <label for="resource_id" class="col-sm-3 col-form-label">Resource Type:</label>
                        <div class="col-sm-9 ">
                            <?php $resourceTypeArr = (new \App\Http\Helper\ClassroomCopyHelper)->getResourceTypes(); ?>
                            <select id="resource_id" name="resource_id" class="form-select bg-light" required="">
                                <option selected value="" disabled="">Select Resource</option>
                                <?php foreach ($resourceTypeArr as $resource) { ?>
                                    <option value="{{ $resource->id }}" <?php if (old('resource_id') == $resource->id) { ?> selected="" <?php } ?>>{{ $resource->name }}</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="description" class="col-sm-3 col-form-label">Description:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control bg-light" id="description" rows="3" placeholder="Description" name="description">{{ old('description') }}</textarea>
                            <div class="text-end blue character py-2">500 Character Max.</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="other_description" class="col-sm-3 col-form-label ">Other:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control bg-light" id="other_description" name="other_description" rows="3" placeholder="Other">{{ old('other_description') }}</textarea>
                            <div class="text-end blue character py-2">500 Character Max.</div>
                        </div>
                    </div>

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

            if ($('#name').val() == '' || $.trim($('#name').val()).length == 0) {
                if ($.trim($('#name').val()).length == 0)
                    $('#name').val('')
                $("#name").css('border-color', 'red');
                err = 1;
            }
            if ($('#email').val() == '' || $.trim($('#email').val()).length == 0) {
                if ($.trim($('#email').val()).length == 0)
                    $('#email').val('')
                $("#email").css('border-color', 'red');
                err = 1;
            }
            if ($('#grade_id').val() == '' || $.trim($('#grade_id').val()).length == 0) {
                if ($.trim($('#grade_id').val()).length == 0)
                    $('#grade_id').val('')
                $("#grade_id").css('border-color', 'red');
                err = 1;
            }
            if ($('#subject_id').val() == '' || $.trim($('#subject_id').val()).length == 0) {
                if ($.trim($('#subject_id').val()).length == 0)
                    $('#subject_id').val('')
                $("#subject_id").css('border-color', 'red');
                err = 1;
            }
            if ($('#resource_id').val() == '' || $.trim($('#resource_id').val()).length == 0) {
                if ($.trim($('#resource_id').val()).length == 0)
                    $('#resource_id').val('')
                $("#resource_id").css('border-color', 'red');
                err = 1;
            }
            if ($('#description').val() == '' || $.trim($('#description').val()).length == 0) {
                if ($.trim($('#description').val()).length == 0)
                    $('#description').val('')
                $("#description").css('border-color', 'red');
                err = 1;
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
                            title: 'Congratulations',
                            text: "Suggest resource sent successfully",
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