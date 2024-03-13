@extends('admin.layouts.master')
@section('title', $pageHeading)
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Update Content</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a class="text-blue" href="{{ URL('admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Update Content</li>
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
            <h3 class="card-title">Update Content</h3>
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
            <form data-action="{{ URL('admin/content/update-content').'/'.$result->id }}" method="post" name="updateContentForm" id="updateContentForm">
                @csrf
                <div class="form-group">
                    <label>Web Page</label>
                    <select name="web_page" id="web_page" class="form-control">
                        <option value="{{ $result->web_page }}" selected="" disabled="">{{ $result->web_page }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="body">Description</label>
                    <textarea class="form-control" name="description" id="tinymce" required="">{{ $result->description }}</textarea>
                </div> 

                <button type="submit" class="btn btn-blue text-white">Update</button>

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
    CKEDITOR.replace('tinymce');
    var formId = '#updateContentForm';

    $(formId).on('submit', function (e) {
        e.preventDefault();
        var description = CKEDITOR.instances.tinymce.getData();
        var data = $(formId).serializeArray();
        data.push({name: 'body', value: description});

        $.ajax({
            type: 'POST',
            url: $(formId).attr('data-action'),
            data: data,
            success: function (response, textStatus, xhr) {
                window.location = response.redirectTo;
            },
            complete: function (xhr) {

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                var response = XMLHttpRequest;

            }
        });
    });
});
</script>
@stop