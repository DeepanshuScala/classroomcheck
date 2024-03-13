@extends('admin.layouts.master')
@section('title', $pageHeading)
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Add FAQ</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a class="text-blue" href="{{ URL('admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Add FAQ</li>
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
            <h3 class="card-title">Add FAQ</h3>
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
            <form action="" method="post" name="addFaqForm" id="addFaqForm" data-action="{{ URL('admin/faq/add-faq') }}">
                @csrf
                <div class="form-group">
                    <label>Question</label>
                    <input type="text" name="question" id="question" value="{{ old('question') }}" class="form-control" required="" placeholder="Question">
                </div>
                <div class="form-group">
                    <label>Answer</label>
                    <textarea class="form-control" name="answer" id="tinymce" required="" placeholder="Answer">{{ old('answer') }}</textarea>
                </div>

                <div class="form-group">
                    <label>Table</label>
                    <p>Do you want to add a table?</p>
                    <input type="checkbox" name="add_table" class="add_table" value="1" disabled="true">
                    
                    <div class="form-group">
                        <div class="table-content" style="display: none;">
                            <label>Membership Fee</label>
                            <input type="text" name="table[basic_membership]" id="basic_membership" value="Free" class="form-control" required="" placeholder="basic_membership">
                            <input type="text" name="table[premium_membership]" id="premium_membership" value="$59.95 Per year" class="form-control" required="" placeholder="premium_membership">
                            <input type="text" name="table[all_seller_membership]" id="all_seller_membership" value="Free" class="form-control" required="" placeholder="all_seller_membership">

                            <label>Payout Rate</label>
                            <input type="text" name="table[basic_payout]" id="basic_payout" value="55% On all sales" class="form-control" required="" placeholder="basic_payout">
                            <input type="text" name="table[premium_payout]" id="premium_payout" value="80% On all sales" class="form-control" required="" placeholder="premium_payout">
                            <input type="text" name="table[allseller_payout]" id="allseller_payout" value="85% On all sales" class="form-control" required="" placeholder="allseller_payout">

                            <label>Transaction Fees</label>
                            <input type="text" name="table[basic_transaction]" id="basic_transaction" value="30 Cents per resource" class="form-control" required="" placeholder="basic_transaction">
                            <input type="text" name="table[premium_transaction]" id="premium_transaction" value="15 Cents per resource" class="form-control" required="" placeholder="premium_transaction">
                            <input type="text" name="table[allseller_transaction]" id="allseller_transaction" value="15 Cents per Transaction" class="form-control" required="" placeholder="allseller_transaction">

                            <label>Max Uploads</label>
                            <input type="text" name="table[basic_max]" id="basic_max" value="Unlimited" class="form-control" required="" placeholder="basic_max">
                            <input type="text" name="table[premium_max]" id="premium_max" value="Unlimited" class="form-control" required="" placeholder="premium_max">
                            <input type="text" name="table[allseller_max]" id="allseller_max" value="Unlimited" class="form-control" required="" placeholder="allseller_max">

                            <label>File Size Upload</label>
                            <input type="text" name="table[basic_file]" id="basic_file" value="200 MB" class="form-control" required="" placeholder="basic_file">
                            <input type="text" name="table[premium_file]" id="premium_file" value="1GB" class="form-control" required="" placeholder="premium_file">
                            <input type="text" name="table[allseller_file]" id="allseller_file" value="1GB" class="form-control" required="" placeholder="allseller_file">

                            <label>Video Uploads</label>
                            <input type="text" name="table[basic_video]" id="basic_video" value="NO" class="form-control" required="" placeholder="basic_video">
                            <input type="text" name="table[premium_video]" id="premium_video" value="Yes" class="form-control" required="" placeholder="premium_video">
                            <input type="text" name="table[allseller_video]" id="allseller_video" value="Yes" class="form-control" required="" placeholder="allseller_video">
                        </div>
                    </div>
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
<script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    CKEDITOR.replace('tinymce');
    var formId = '#addFaqForm';

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

    $("body .add_table").change(function(){
        if($(this).is(':checked')){
            $(".table-content").show();
        }
        else{
            $(".table-content").hide();
        }
    })
});
</script>
@stop