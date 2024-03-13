@extends('admin.layouts.master')
@section('title', $pageHeading)
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Add Sub Subject</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a class="text-blue" href="{{ URL('admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Add Sub Subject</li>
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
            <h3 class="card-title">Add Sub Subject</h3>
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
            <form action="" method="post" name="addSubSubjectForm" id="addSubSubjectForm">
                @csrf
                <div class="form-group">
                    <label>Subject Parent</label>
                    <select id="parent_id" name="parent_id" class="form-control" required="">
                        <option value="" disabled="" selected="">Select Parent</option>
                        @foreach($subjectArr as $rows)
                        <option value="{{ $rows['id'] }}" <?php if (old('parent_id') == $rows['id']) { ?> selected="" <?php } ?>>{{$rows['name']}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required="" placeholder="Subject">
                </div>

                <button type="submit" class="btn btn-blue text-white">Add</button>
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
    });
</script>
@stop