@extends('admin.layouts.master')
@section('title', $pageHeading)
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Update Blog</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a class="text-blue" href="{{ URL('admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Update Blog</li>
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
            <h3 class="card-title">Update Blog</h3>
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
            <form action="" method="post" name="updateBlogForm" id="updateBlogForm" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" id="title" value="{{ (old('title') == null) ? $result->title : old('title') }}" class="form-control word-limit" required="" placeholder="Title" data-word="10">
                </div>
                <div class="form-group">
                    <label>Short Description</label>
                    <input type="text" name="short_description" id="short_description" value="{{ (old('short_description') == null) ? $result->short_description : old('short_description') }}" class="form-control word-limit" required="" placeholder="Short Description" data-word="30">
                </div>
                <div class="form-group">
                    <label>Long Description</label>
                    <textarea class="form-control" name="long_description" id="tinymce" required="" placeholder="Long Description">{{ (old('long_description') == null) ? $result->long_description : old('long_description') }}</textarea>
                </div>
                <div class="form-group">
                    <label>Image 1</label>
                    <input type="file" class="form-control" name="image1" id="image1" accept="image/jpg,image/jpeg,image/JPG,image/JPEG,image/png,image/PNG" onchange="readURL(this);">
                    <?php
                    $style1 = '';
                    if(empty($result->image1))
                        $style1 ="display:none;";
                    ?>
                    <img src="{{url('storage/uploads/blogs/' .$result->image1)}}" class="image1-preview mt-3" height="50px" width="50px" style={{$style1}}>
                </div>
                <div class="form-group">
                    <label>Image 2</label>
                    <input type="file" class="form-control" name="image2" id="image2" accept="image/jpg,image/jpeg,image/JPEG,image/JPG,image/png,image/PNG" onchange="readURL(this);">
                    <?php
                    $style2 = '';
                    if(empty($result->image2))
                        $style2 ="display:none;";
                    ?>
                    <img src="{{url('storage/uploads/blogs/' .$result->image2)}}" class="image2-preview mt-3" height="50px" width="50px" style={{$style2}}>
                </div>
                <div class="form-group">
                    <label>Image 3</label>
                    <input type="file" class="form-control" name="image3" id="image3" accept="image/jpg,image/jpeg,image/JPG,image/JPEG,image/png,image/PNG" onchange="readURL(this);">
                    <?php
                    $style3 = '';
                    if(empty($result->image3))
                        $style3 ="display:none;";
                    ?>
                    <img src="{{url('storage/uploads/blogs/' .$result->image3)}}" class="image3-preview mt-3" height="50px" width="50px" style={{$style3}}>
                </div>

                <button type="submit" class="btn btn-blue text-white mt-3">Update</button>
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
    CKEDITOR.replace('tinymce');
    var formId = '#updateBlogForm';

    $(formId).on('submit', function (e) {
        e.preventDefault();
        $("#submitBtn").prop('disabled', true);
        $("#submitBtn").html('Processing');
        $("#title").css('border-color', '#ced4da');
        $("#short_description").css('border-color', '#ced4da');
        $("#tinymce").css('border-color', '#ced4da');
        if ($('#title').val() == '' || $.trim($('#title').val()).length == 0) {
            if ($.trim($('#title').val()).length == 0)
                $('#title').val('')
            $('#title').focus().select();
            $("#title").css('border-color', 'red');
            $("#submitBtn").prop('disabled', false);
            $("#submitBtn").html('Add');
            return false;
        }
        if ($('#short_description').val() == '' || $.trim($('#short_description').val()).length == 0) {
            if ($.trim($('#short_description').val()).length == 0)
                $('#short_description').val('')
            $('#short_description').focus().select();
            $("#short_description").css('border-color', 'red');
            $("#submitBtn").prop('disabled', false);
            $("#submitBtn").html('Add');
            return false;
        }
        if ($('#tinymce').val() == '' || $.trim($('#tinymce').val()).length == 0) {
            if ($.trim($('#tinymce').val()).length == 0)
                $('#tinymce').val('')
            $('#tinymce').focus().select();
            $("#tinymce").css('border-color', 'red');
            $("#submitBtn").prop('disabled', false);
            $("#submitBtn").html('Add');
            return false;
        }
        var description = CKEDITOR.instances.tinymce.getData();
        var frm = $('#updateBlogForm');
        var formData = new FormData(frm[0]);
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('body', description);
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
            complete: function (xhr) {

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                var response = XMLHttpRequest;

            }
        });
    });

    $(".word-limit").on("input", function() {
        var wordLimit = $(this).data('word');
        var text = $(this).val();
        var words = text.trim().split(/\s+/); // Split text into words
        var wordCount = words.length;
        // Limit the number of words
        if (wordCount > wordLimit) {
          // Split the words and take only the first `wordLimit` words
          var limitedText = words.slice(0, wordLimit).join(" ");
          $(this).val(limitedText); // Update the textarea content
        }
    });
});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            file = e.target.result;
            $('img.'+input.id+'-preview')
                .attr('src', e.target.result);
        };
        $('img.'+input.id+'-preview').show();
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@stop