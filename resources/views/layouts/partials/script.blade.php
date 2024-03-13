<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">-->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> -->


<!-- Separate Popper and Bootstrap JS -->
<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

<!-- <script type="text/javascript" src="{{asset('js/owl.carousel.min.js')}}"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<!-- Scripts -->
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="{{asset('js/dropzone.js')}}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
<script src="{{asset('js/pb.calendar.js')}}"></script>
<!--<script src="{{asset('js/calender-full.js')}}"></script>-->

<!-- Select2 -->
<script src="{{--asset('plugins/select2/js/select2.full.min.js')--}}"></script>
<!-- SweetAlert2 -->
<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>

<script type="text/javascript" src="{{asset('js/intlTelInput-jquery.min.js')}}"></script>
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script> -->
<script type="text/javascript" src="{{asset('js/easyzoom.js')}}"></script>
<script type="text/javascript" src="{{asset('js/easyzoom-mobile.js')}}"></script>

<!-- <script>
    $('.productZoom').easyZoom({
        width: 500,
        position: 'right',
		background: '#222',
    });
</script> -->

<script>

CKEDITOR.replace('editor');
</script>
<script>
// var $easyzoom = $('.productZoom').easyZoom();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    $('select').addClass('noValue');
    $('select').on('change', function(){
    var $this = $(this);

    if (!$this.val()) {
        $this.addClass('noValue');
    } else {
        $this.removeClass('noValue');
    }
});
</script>
@if (Session::get('success'))
<script>
    Swal.fire({
        title: 'Done!',
        text: '{{Session::get("success")}}',
        icon: 'success',
        showConfirmButton: true,
        //closeOnClickOutside: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        timer: 3000
    });
</script>
@endif
@if (Session::get('error'))
<script>
    Swal.fire({
        title: 'Oops...',
        text: '{{Session::get("error")}}',
        icon: 'error',
        showConfirmButton: true,
        //closeOnClickOutside: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
//        timer: 3000
    });
</script>
@endif
@if(isset($_COOKIE['error']))
<script>
    Swal.fire({
        title: 'Oops...',
        text: '{{$_COOKIE["error"]}}',
        icon: 'error',
        showConfirmButton: true,
        //closeOnClickOutside: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
//        timer: 3000
    });
</script>
<?php  
setcookie('error', '', time() - (86400 * 30), "/");
?>
@endif
<script>
    function limitToNumbers(inputField) {
        // Remove all non-numeric characters
        inputField.value = inputField.value.replace(/[^0-9]/g, '');
        
        // Limit the length to 12 characters
        if (inputField.value.length > 12) {
            inputField.value = inputField.value.slice(0, 12);
        }
    }
    $(document).ready(function () {

        $(".productaddcls").on("click",function(e){
            e.preventDefault();
            Swal.fire({
                title: 'Please Select Product Type',
                showDenyButton:true,
                allowOutsideClick: true,
                allowEscapeKey: true,
                confirmButtonText: "Single Product",
                denyButtonText:"Bundle Product",
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{route('storeDashboard.addProduct')}}";
                } else if (result.isDenied) {
                    window.location.href = "{{route('storeDashboard.addBundleProduct')}}";
                }
            });
        });

        $("#filterSearchSubmitBtn").click(function (e) {
            var pathname = window.location.pathname;
            var product_filter_search_url = "{{env('PRPDUCT_FILTER_SEARCH_URL')}}"
            if (pathname != product_filter_search_url) {
                //window.location.href = "{{route('product.search.view')}}";
                var url = "{{ route('product.search.view') }}";
                $('#productFilterSearchForm').attr('action', url);
                $('#productFilterSearchForm').submit();
            }
        });

        $("#globalSearchBtn").click(function (e) {
            $('#search_keyword').css('border-color', '#E4E4E4');
            var pathname = window.location.pathname;
            var product_filter_search_url = "{{env('PRPDUCT_FILTER_SEARCH_URL')}}"
            if (pathname != product_filter_search_url) {
                //window.location.href = "{{route('product.search.view')}}";
                if ($.trim($('#search_keyword').val()) == '' && $.trim($('#search_keyword').val()).length == 0) {
                    $('#search_keyword').val('');
                    $('#search_keyword').css('border-color', 'red');
                } else {
                    var url = "{{ route('product.search.view') }}";
                    $('#productSearchForm1').attr('action', url);
                    $('#productSearchForm1').submit();
                }
            }
            else{
                console.log('here');
                $("form#productFilterSearchForm input[name='search_keyword']").val($("form#productSearchForm1 input[name='search_keyword']").val());
                 $('#productFilterSearchForm').submit();
            }
        });
        
   
    });
</script>
<?php  
$d = DB::table('jobs')->count();    
if(!empty($d)){
?>
<script type="text/javascript">
    /*
    $(document).ready(function () {
        $.ajax({
            url: "{{route('execute.jobs')}}",
            type: 'POST',

            data: {_token: '{{ csrf_token() }}'},
        });
        $(document).on('click', '.day-number', function () {
         var data = [
         {eventName: 'Bowling Team1', calendar: 'Other', color: 'green'},
         {eventName: 'Teach Kids to Code2', calendar: 'Other', color: 'green'},
         {eventName: 'Startup Weekend3', calendar: 'Other', color: 'green'}
         ];
         addDataToCalendar(data);
         
         });

    });*/
</script>


<?php
}
?>