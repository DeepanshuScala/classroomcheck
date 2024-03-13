<?php
use App\Models\{
    Country
};
?>
@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
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
<img id="preview-image-before-upload" src="https://sm.mashable.com/t/mashable_in/photo/default/avatar-copy_myfw.1248.jpg"
alt="preview image" style="max-height: 250px;">
</div>
<div class="col-md-12">
<button type="submit" class="btn btn-primary" id="submit">Submit</button>
</div>
</div>     
</form>
</div>
<?php
$get_c = Country::get();
//foreach ($get_c as $key => $value) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries/IN/states',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER => array(
        'X-CSCAPI-KEY: ZHF2QzVYVFlNWVFDamhlS21xUW9KQzhGWU5HZ2hEQUROMlhDVk5LZA=='
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $r = json_decode($response,true);
    foreach ($r as $key => $value) {
        // code...
        echo "<pre>";
        print_r($value);
        echo "</pre>";
    }
//}

?>
@endsection

@push('script')
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
@endpush