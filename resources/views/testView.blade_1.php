<!DOCTYPE html>
<html>
<head>
<title>Laravel 8 Ajax Image Upload With Preview - Tutsmake.com</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<div class="container mt-4">
<h2 class="text-center">Image Upload with Preview using jQuery Ajax in Laravel 8 - Tutsmake.com</h2>
<form method="POST" enctype="multipart/form-data" id="image-upload" action="javascript:void(0)" >
    @csrf
<div class="row">
<div class="col-md-12">
<div class="form-group">
<input type="file" name="image" placeholder="Choose image" id="image">
</div>
</div>
<div class="col-md-12 mb-2">
<img id="preview-image-before-upload" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
alt="preview image" style="max-height: 250px;">
</div>
<div class="col-md-12">
<button type="submit" class="btn btn-primary" id="submit">Submit</button>
</div>
</div>     
</form>
</div>
<script type="text/javascript">
$(document).ready(function (e) {
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#image').change(function(){
        let reader = new FileReader();
        reader.onload = (e) => { 
            $('#preview-image-before-upload').attr('src', e.target.result); 
        }
        reader.readAsDataURL(this.files[0]); 
    });
    $('#image-upload').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type:'POST',
            url: "{{ route('profileImage.update.test')}}",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: (data) => {
                console.log(data);
//            this.reset();
//            alert('Image has been uploaded using jQuery ajax successfully');
            },
            error: function(data){
                console.log(data);
            }
        });
    });
});
</script>
</div>  
</body>
</html>