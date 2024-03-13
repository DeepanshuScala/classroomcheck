@extends('admin.layouts.master')
@section('title', $pageHeading)
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Add Testimonial</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a class="text-blue" href="{{ URL('admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Add Testimonial</li>
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
            <h3 class="card-title">Add Testimonial</h3>
            <a class="btn btn-warning text-white btn-xs float-right" href="{{url()->previous()}}">
                <i class="fa fa-arrow-left"></i>&nbsp;Back
            </a>
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
            <form action="" method="post" name="addTestimonialForm" id="addTestimonialForm" data-action="{{ URL('admin/content/add-testimonial') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required="" placeholder="Name">
                </div>
                <div class="form-group">
                    <label>Content</label>
                    <textarea class="form-control" name="content" id="content" required="" placeholder="Add Content" maxlength="350">{{ old('content') }}</textarea>
                    <span class="text-red">Max 350 Characters</span>
                </div>
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" class="form-control" name="image" id="image" accept="image/jpg,image/jpeg,image/JPG,image/JPEG,image/png,image/PNG" onchange="readURL(this);">
                    <img src="#" class="image-preview" height="50px" width="50px" style="display:none;">
                </div>

                <input type="submit" class="btn btn-blue text-white" id="submitBtn" value="Add">
            </form>
        </div>
        <!-- /.card-body -->
    </div>

</section>
<!-- /.content -->
@stop

@section('scripts')
<script type="text/javascript">
$(document).ready(function () {
    
    var formId = '#addTestimonialForm';

    $(formId).on('submit', function (e) {
        e.preventDefault();
        $("#submitBtn").prop('disabled', true);
        $("#submitBtn").val('Processing');
        $("#name").css('border-color', '#ced4da');
        $("#content").css('border-color', '#ced4da');
        $("#image").css('border-color', '#ced4da');
        var image = $('#image').prop('files')[0];
        if ($('#name').val() == '' || $.trim($('#name').val()).length == 0) {
            if ($.trim($('#name').val()).length == 0)
                $('#name').val('')
            $('#name').focus().select();
            $("#name").css('border-color', 'red');
            $("#submitBtn").prop('disabled', false);
            $("#submitBtn").val('Add');
            return false;
        }
        
        if ($('#content').val() == '' || $.trim($('#content').val()).length == 0) {
            if ($.trim($('#content').val()).length == 0)
                $('#content').val('')
            $('#content').focus().select();
            $("#content").css('border-color', 'red');
            $("#submitBtn").prop('disabled', false);
            $("#submitBtn").val('Add');
            return false;
        }
        
        if( $.trim($('#content').val()).length < 200){
            Swal.fire({
                icon: 'warning',
                title: 'Oops',
                text: 'Please add atleast 200 Character'
            })
            $('#content').focus().select();
            $("#content").css('border-color', 'red');
            $("#submitBtn").prop('disabled', false);
            $("#submitBtn").val('Add');
            return false
        }

        if (image == undefined) {
            $('#image').focus().select();
            $("#image").css('border-color', 'red');
            $("#submitBtn").prop('disabled', false);
            $("#submitBtn").val('Add');
            return false;
        }
        
        var frm = $('#addTestimonialForm');
        var formData = new FormData(frm[0]);
        formData.append('_token', "{{ csrf_token() }}");
        
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
});
function readURL(input) {
    if (input.files && input.files[0]) {
        console.log(input.id);
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