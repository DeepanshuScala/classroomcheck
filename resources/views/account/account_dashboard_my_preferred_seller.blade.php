@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!--Preferred Seller Section  Starts Here-->
<section class="preferred-seller-section py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-sm-12 col-lg-8">
                <h1 class="text-uppercase"> My Preferred Seller</h1>
            </div>
            <div class="col-12 col-sm-12 col-lg-4 pt-5">
                <div class="text-end pb-5">
                    <a href="{{route('account.dashboard')}}" class="blue acc-dashboard">
                        <img src="{{asset('images/icon-1.png')}}" class="img-fluid me-2 my-1" alt=" "> 
                        Account Dashboard
                    </a>
                </div>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Store</th>
                    <th scope="col">Notification</th>
                    <th scope="col">Delete</th>

                </tr>
            </thead>
            <tbody>
                <?php
                if (count($data['preferredSellers']) > 0) {
                    foreach ($data['preferredSellers'] as $seller) {
                        $store_logo = (new \App\Http\Helper\Web)->storeDetail(@$seller->sellerDetails->id,'store_logo');
                        ?>
                        <tr>
                            <td><img src="{{ $store_logo }}" class="img-fluid" alt="flag"></td>
                            <td><a href="{{url('/seller-profile/'.base64_encode($seller->sellerDetails->id.' classroom'))}}">{{ $seller->sellerDetails->store->store_name }}</a></td>
                            <td>
                                <div class="switch_box" data-notify="{{$seller->notify}}" data-id="{{$seller->id}}">
                                    <input type="checkbox" class="switch_1" {{$seller->notify==1?'checked':''}}>
                                </div>
                            </td>
                            <td><a class="unfollowSeller cursor-pointer" data-followed-to="{{ $seller->followed_to }}"><i class='fal fa-times-circle fa-lg text-dark'></i></a></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="4" class="text-center">You do not have any preferred sellers at present.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
</section>

<!--Preferred Seller Section  Ends Here-->
@endsection
@push('script')
<script>
    //unfollow seller
    $(document).on('click', '.unfollowSeller', function (e) {
        e.preventDefault();
        var followed_to = $(this).data("followed-to");
        var $this = $(this);
        Swal.fire({
            title: 'Are you sure',
            text: "You want to unfollow seller?",
            icon: 'warning',
            showCancelButton: true,
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-info mx-2 bg-blue text-white'
            },
            confirmButtonText: 'Yes, Unfollow'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{URL('/buyer/follow-unfollow')}}",
                    type: 'POST',
                    data: {followed_to: followed_to, _token: '{{ csrf_token() }}'},
                    beforeSend: function (xhr) {
                        $this.prop('disabled', true);
                    }
                }).always(function () {
                    $this.prop('disabled', false);
                }).done(function (response, status, xhr) {
                    $this.prop('disabled', false);
                    window.location.reload();
                }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                    $this.prop('disabled', false);
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

    $(document).on('click','.switch_box',function(e){
        e.preventDefault();
        var notify = $(this).attr("data-notify");
        var id = $(this).data("id");
        var t = $(this);
        $.ajax({
            url: "{{URL('/buyer/notifyupdate')}}",
            type: 'POST',
            data: {notify: notify,id:id, _token: '{{ csrf_token() }}'},
            beforeSend: function (xhr) {
                // Swal.fire({
                //     title: "Updating...",
                //     text: "Please wait",
                //     showConfirmButton: false,
                //     allowOutsideClick: false
                // });
            }
        }).done(function (response, status, xhr) {
            Swal.fire({
                title :"Status updated",
                timer: 1000,
            });
            t.attr('data-notify',response.data);
            if(response.data == 1){
                t.find('input.switch_1').prop('checked',true);
            }else if(response.data == 0){
                t.find('input.switch_1').prop('checked',false);
            }
        }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
            $this.prop('disabled', false);
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
        /*
                Swal.fire({
                  title:'Make Product Active/Inactive',
                  html: '<p>Make Product Active/Inactive ' + inpuhtml + '<p/>' +
                        '<p>Notify Buyers<input type="checkbox" id="alertbuyer"/></p>',
                  confirmButtonText: 'Submit',
                  showCancelButton: true,
                  preConfirm: () => {
                    var activeinactive = 0;
                    var alertbuyer = 0;
                    if(Swal.getPopup().querySelector('#activeinactive').checked){
                        activeinactive = 1;
                    }

                    if(Swal.getPopup().querySelector('#alertbuyer').checked){
                        alertbuyer = 1;
                    }
                    
                    return {activeinactive: activeinactive, alertbuyer: alertbuyer}
                  }
                }).then((result) => {
                    
                    
                });
            */
    });
</script>
@endpush
