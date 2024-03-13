@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
    <!--Account Dashboard - My Inbox Section Starts Here-->
    <section class="acc-dashboard-myinbox  pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-8 col-lg-9  py-4">
                    <h1 class="text-uppercase pt-4 pb-5"> My Inbox</h1>
                    
                    <div class="my-inbox-tabs my-4">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                              <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Received</button>
                              </li>
                              <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Sent</button>
                              </li>
                              <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Write a Message</button>
                              </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                @foreach($receiver_answer as $que)
                                
                                <?php 
                                $user_image = (new \App\Http\Helper\Web)->userDetail(@$que->sender_id,'image');
                                $first_name = (new \App\Http\Helper\Web)->userDetail(@$que->sender_id,'first_name');
                                $surname = (new \App\Http\Helper\Web)->userDetail(@$que->sender_id,'surname'); 
                                $product_name1 =(new \App\Http\Helper\Web)->getProductDetail(@$que->product_id,'product_title'); 
                                ?>
                                <div class="rating-list mb-5">
                                  <div class="profile-title d-md-flex justify-content-between">
                                      <div class="date-pro">
                                          <p>{{$product_name1}}</p>
                                      </div>
                                  </div>
                                    <div class="d-flex profile-img align-items-center">
                                        <div class="profile-img me-3">
                                            <img src="{{$user_image}}" alt="profile" class="img-fluid">
                                        </div>
                                        <div class="text-pro">
                                            <h6><b>Question</b> | {{date('F d, Y',strtotime($que->created_at))}} from {{$first_name}} {{$surname}}</h6>
                                        </div>
                                    </div>
                                    <div class="content-p mt-3">
                                        <div class="description">
                                            <p class="add-read-more show-less-content">{{$que->question}}</p>
                                        </div>
                                    </div>
                                    @foreach($que->answers as $answer)
                                    <?php
                                        $store_name1 = (new \App\Http\Helper\Web)->storeDetail(@$answer->sender_id,'store_name');
                                        $store_logo1 = (new \App\Http\Helper\Web)->storeDetail(@$answer->sender_id,'store_logo');
                                    ?>
                                    <div class="rating-list">
                                      <!-- <div class="profile-title d-md-flex justify-content-between">
                                          <div class="date-pro">
                                              <p>{{$product_name1}}</p>
                                          </div>
                                      </div> -->
                                        <div class="d-flex profile-img align-items-center">
                                            <div class="profile-img me-3">
                                                <img src="{{$store_logo1}}" alt="profile" class="img-fluid">
                                            </div>
                                            <div class="text-pro">
                                                <h6><b>Answer</b> | {{date('F d, Y',strtotime($answer->created_at))}} from {{$store_name1}} (Classroom Copy Seller)</h6>
                                            </div>
                                        </div>
                                        <div class="content-p mt-3">
                                            <div class="description">
                                                <p class="add-read-more show-less-content">{{$answer->question}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                                @if($total_receiver_answer > 10)
                                <div class="my-2 mt-4 text-center load-more-received">
                                    <input type="button" data-append="load-more-received" data-type="received" class="btn btn-primary btn-hover px-4 py-2" id="load-more-received" value="View More">
                                </div>
                                @endif
                                
                              </div>
                              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                @foreach($sent_questions as $question)
                                <?php
                                $user_image = (new \App\Http\Helper\Web)->userDetail(@$question->sender_id,'image');
                                $first_name = (new \App\Http\Helper\Web)->userDetail(@$question->sender_id,'first_name');
                                $surname = (new \App\Http\Helper\Web)->userDetail(@$question->sender_id,'surname');
                                $product_name =(new \App\Http\Helper\Web)->getProductDetail(@$question->product_id,'product_title');
                                ?>
                                <div class="rating-list mb-5">
                                  <div class="profile-title d-md-flex justify-content-between">
                                      <div class="date-pro">
                                          <p>{{$product_name}}</p>
                                      </div>
                                  </div>
                                    <div class="d-flex profile-img align-items-center">
                                        <div class="profile-img me-3">
                                            <img src="{{$user_image}}" alt="profile" class="img-fluid">
                                        </div>
                                        <div class="text-pro">
                                            <h6><b>Question</b> | {{date('F d, Y',strtotime($question->created_at))}} from {{$first_name}} {{$surname}}</h6>
                                        </div>
                                    </div>
                                    <div class="content-p mt-3">
                                        <div class="description">
                                            <p class="add-read-more show-less-content">{{$question->question}}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @if($total_sent_questions > 10)
                                <div class="my-2 mt-4 text-center load-more-sent">
                                    <input type="button" data-append="load-more-sent" data-type="sent" class=" load-more-sent btn btn-primary btn-hover px-4 py-2" id="load-more-sent" value="View More">
                                </div>
                                @endif
                              </div>
                              <div class="tab-pane fade text-start" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                  <div class="static-data">
                                      <p>If you wish to contact a seller in relation to a product that you have purchased or are considering purchasing, please use the Q&A section of the individual resource page. If you have any query regarding classroom copy please use <a href="{{url('/contact-us')}}">contact us</a></p>
                                      
                                  </div>
                                  <!-- <form>
                                   <div class="comments-btn text-end">
                                      <button type="button" class="btn-outlined-commnets">Preview & Send</button>
                                    </div>
                                  <div class="comments-box">
                                     <div class="comments-header p-4">
                                         <div class="position-relative">
                                             <div class="author-thumd me-3">
                                                   <img src="https://watchdog.cmsbox.in/images/book-img.png" alt="">
                                             </div>
                                             <div class="subject">
                                                 <p><b>Form:</b> Book</p>
                                                 <div class="form-group">
                                                     <label>Subject:</label>
                                                     <input type="text" class="form-control"/>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                         
                                           
                                                        
                                      <div id="editor"></div>
                                     
                                  </div>
                                  </form> -->
                                  
                              </div>
                            </div>
                        
                        <!-- END tabs-content -->
                    </div>
                    <!-- END tabs -->
                </div>

                <div class="col-12 col-sm-12 col-md-4 col-lg-3 pt-5 ">
                    <div class="text-end pb-5 acc-dashboard-myinbox-right">
                        <a href="{{route('account.dashboard')}}" class="blue acc-dashboard "><img src="{{asset('images/icon-1.png')}}" class="img-fluid me-2 my-1 " alt=" ">Account Dashboard</a>
                    </div>
                    <!-- <div class="float-end prev-msg"><button type="submit " class="btn btn-hover  ">Previous Messages</button></div> -->
                </div>
            </div>
        </div>
    </section>
    <!--Account Dashboard - My Inbox Section Ends Here-->
@endsection
@push('script')
<script type="text/javascript">
  //for load more data 
    let take = 10;
    let take_sent = 10;
    let skip = 10;
    let skip_sent = 10;
    $('body').on('click', '#load-more-sent', function() {
      

        $.ajax({
            url: "{{route('account-my-inbox-load-more')}}",
            type: 'POST',
            data: {'_token': "{{ csrf_token() }}",take:take_sent,skip:skip_sent,type:'sent'},
            dataType: 'json',
            beforeSend: function() {
                $('#load-more-sent').val('Loading......');
               $('#load-more-sent').prop('disabled', true);
            },

        }).done(function (response, status, xhr) {
            $('#load-more-sent').val('View More');
            $('#load-more-sent').prop('disabled', false);
            if (response.success === false) {
              swal.fire("Oops!", response.message, "error");
            }
            // $('.question-box').addClass('d-none');
            if (response.success === true) {
                skip_sent = skip_sent +take_sent;
                
                if(response.data.length === 0){
                    $('#load-more-sent').prop('disabled', true);
                }else{
                    $('.load-more-sent').before(response.html)
                }
            }
        }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
            $('#load-more-sent').prop('disabled', false);
            //$('#replay').modal('hide');
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
    });

    $('body').on('click', '#load-more-received', function() {
      
        $.ajax({
            url: "{{route('account-my-inbox-load-more')}}",
            type: 'POST',
            data: {'_token': "{{ csrf_token() }}",take:take,skip:skip,type:'received'},
            dataType: 'json',
            beforeSend: function() {
                $("#load-more-received").val('Loading......');
               $("#load-more-received").prop('disabled', true);
            },

        }).done(function (response, status, xhr) {
            $("#load-more-received").val('View More');
            $("#load-more-received").prop('disabled', false);
            if (response.success === false) {
              swal.fire("Oops!", response.message, "error");
            }
            // $('.question-box').addClass('d-none');
            if (response.success === true) {
                skip = skip +take;
                if(response.data.length === 0){
                    $("#load-more-received").prop('disabled', true);
                }else{
                    $('.load-more-received').before(response.html)
                }
            }
        }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
            $("#load-more-received").prop('disabled', false);
            //$('#replay').modal('hide');
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
    });

jQuery(function ($) {
       function AddReadMoreInbox() {
          var carLmt = 200;
          var readMoreTxt = " ...Read more";
          var readLessTxt = " Read less";
          $(".add-read-more").each(function () {
             if ($(this).find(".first-section").length)
                return;
             var allstr = $(this).text();
             if (allstr.length > carLmt) {
                var firstSet = allstr.substring(0, carLmt);
                var secdHalf = allstr.substring(carLmt, allstr.length);
                var strtoadd = firstSet + "<span class='second-section'>" + secdHalf + "</span><span class='read-more'  title='Click to Show More'>" + readMoreTxt + "</span><span class='read-less' title='Click to Show Less'>" + readLessTxt + "</span>";
                $(this).html(strtoadd);
             }
          });
          $(document).on("click", ".read-more,.read-less", function () {
             $(this).closest(".add-read-more").toggleClass("show-less-content show-more-content");
          });
       }
       AddReadMoreInbox();
});
</script>
@endpush