@extends('admin.layouts.master')
@section('title', $pageHeading)
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">About Us</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a class="text-blue" href="{{ URL('admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">About Us</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">

    <div class="card card-blue">
        <div class="card-header">
            <h3 class="card-title">About Us</h3>
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
            <form data-action="{{ URL('admin/content/about-us') }}" method="post" name="updateContentForm" id="updateContentForm" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="body">Our Story(Who We Are)</label>
                    <textarea class="form-control" name="about_us" id="about_us" required="" placeholder="Our Story(Who We Are)">{{ ($result != null) ? $result->about_us : '' }}</textarea>
                </div>
                <div class="form-group">
                    <label>Our Story Image</label>
                    <input type="file" class="form-control" name="about_us_image" id="about_us_image" accept="image/jpg,image/jpeg,image/JPG,image/JPEG,image/png,image/PNG">
                </div>
                <?php if ($result != null && $result->about_us_image != '' && $result->about_us_image != null) { ?>
                    <div class="my-3">
                        <a href="{{ url('storage/uploads/about_us/' . $result->about_us_image) }}" target="_blank">
                            <img src="{{ url('storage/uploads/about_us/' . $result->about_us_image) }}" height="70px" width="70px">
                        </a>
                    </div>
                <?php } ?>
                <div class="form-group">
                    <label for="body">Our Vision</label>
                    <textarea class="form-control" name="our_vision" id="our_vision" required="" placeholder="Our Vision">{{ ($result != null) ? $result->our_vision : '' }}</textarea>
                </div>
                <div class="form-group">
                    <label for="body">Our Mission</label>
                    <textarea class="form-control" name="our_mission" id="our_mission" required="" placeholder="Our Mission">{{ ($result != null) ? $result->our_mission : '' }}</textarea>
                </div>
                <div class="form-group">
                    <label for="body">Founding Story</label>
                    <textarea class="form-control" name="founding_story_description" id="founding_story_description" required="" placeholder="Founding Story">{{ ($result != null) ? $result->founding_story_description : '' }}</textarea>
                </div>
                <div class="form-group">
                    <label>Founding Story Image</label>
                    <input type="file" class="form-control" name="founding_story_image" id="founding_story_image" accept="image/jpg,image/jpeg,image/JPG,image/JPEG,image/png,image/PNG">
                </div>
                <?php if ($result != null && $result->founding_story_image != '' && $result->founding_story_image != null) { ?>
                    <div class="my-3">
                        <a href="{{ url('storage/uploads/about_us/' . $result->founding_story_image) }}" target="_blank">
                            <img src="{{ url('storage/uploads/about_us/' . $result->founding_story_image) }}" height="70px" width="70px">
                        </a>
                    </div>
                <?php } ?>
                <button type="submit" class="btn btn-blue text-white" id="submitBtn">Update</button>

            </form>
        </div>
        <!-- /.card-body -->
    </div>

</section>
<!-- /.content -->
@stop

@section('scripts')
<script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    /*tinymce.init({
     selector: 'textarea#tinymce',
     height: 600,
     plugins: 'code'
     });*/
    CKEDITOR.replace('about_us');
    CKEDITOR.replace('our_vision');
    CKEDITOR.replace('our_mission');
    CKEDITOR.replace('founding_story_description');
    var formId = '#updateContentForm';

    $(formId).on('submit', function (e) {
        e.preventDefault();
        $("#submitBtn").prop('disabled', true);
        $("#submitBtn").html('Processing');
        $("#about_us").css('border-color', '#ced4da');
        $("#our_vision").css('border-color', '#ced4da');
        $("#our_mission").css('border-color', '#ced4da');
        $("#founding_story_description").css('border-color', '#ced4da');
        if ($('#about_us').val() == '' || $.trim($('#about_us').val()).length == 0) {
            if ($.trim($('#about_us').val()).length == 0)
                $('#about_us').val('')
            $('#about_us').focus().select();
            $("#about_us").css('border-color', 'red');
            $("#submitBtn").prop('disabled', false);
            $("#submitBtn").html('Update');
            return false;
        }
        if ($('#our_vision').val() == '' || $.trim($('#our_vision').val()).length == 0) {
            if ($.trim($('#our_vision').val()).length == 0)
                $('#our_vision').val('')
            $('#our_vision').focus().select();
            $("#our_vision").css('border-color', 'red');
            $("#submitBtn").prop('disabled', false);
            $("#submitBtn").html('Update');
            return false;
        }
        if ($('#our_mission').val() == '' || $.trim($('#our_mission').val()).length == 0) {
            if ($.trim($('#our_mission').val()).length == 0)
                $('#our_mission').val('')
            $('#our_mission').focus().select();
            $("#our_mission").css('border-color', 'red');
            $("#submitBtn").prop('disabled', false);
            $("#submitBtn").html('Update');
            return false;
        }
        if ($('#founding_story_description').val() == '' || $.trim($('#founding_story_description').val()).length == 0) {
            if ($.trim($('#founding_story_description').val()).length == 0)
                $('#founding_story_description').val('')
            $('#founding_story_description').focus().select();
            $("#founding_story_description").css('border-color', 'red');
            $("#submitBtn").prop('disabled', false);
            $("#submitBtn").html('Update');
            return false;
        }
        var description = CKEDITOR.instances.about_us.getData();
        var our_vision = CKEDITOR.instances.our_vision.getData();
        var our_mission = CKEDITOR.instances.our_mission.getData();
        var founding_story_description = CKEDITOR.instances.founding_story_description.getData();
        var frm = $('#updateContentForm');
        var formData = new FormData(frm[0]);
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('about_us', description);
        formData.append('our_vision', our_vision);
        formData.append('our_mission', our_mission);
        formData.append('founding_story_description', founding_story_description);

        $.ajax({
            type: 'POST',
            url: $(formId).attr('data-action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response, textStatus, xhr) {
                if (response.redirectTo == '' || response.redirectTo == undefined) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.msg
                    })
                } else {
                    window.location = response.redirectTo;
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                var response = XMLHttpRequest;

            }
        });
    });
});
</script>
@stop