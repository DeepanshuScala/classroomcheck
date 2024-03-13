@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!--Store Dashboard - My Inbox Section Starts Here-->
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
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Write A Message</button>
                              </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                {{--
                                @foreach($receiver_answer as $question)
                                <?php
                                $user_image = (new \App\Http\Helper\Web)->userDetail(@$question->sender_id,'image');
                                $first_name = (new \App\Http\Helper\Web)->userDetail(@$question->sender_id,'first_name');
                                $surname = (new \App\Http\Helper\Web)->userDetail(@$question->sender_id,'surname');
                                $product_name1 =(new \App\Http\Helper\Web)->getProductDetail(@$question->product_id,'product_title');
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
                                            <h6><b>Question</b> | {{date('F d, Y',strtotime($question->created_at))}} from {{$first_name}} {{$surname}}</h6>
                                        </div>
                                    </div>
                                    <div class="content-p mt-3">
                                        <div class="description">
                                            <p class="add-read-more show-less-content">{{$question->question}}</p>
                                        </div>
                                    </div>
                                    @if($question->answered == false)
                                    <div class="content-p mt-4 button-box-{{$question->id}}" >
                                      <div class="d-flex replay-box align-items-center justify-content-center justify-content-md-end">
                                          <div onclick="answerBox(this,'{{$question->id}}')" data-ans="" class="view-replay answer answer-{{$question->id}}" data-id="{{$question->id}}">
                                              <a href="javascript:void(0)"><i class="fas fa-reply me-1 "></i> Post Answer</a>
                                          </div>
                                          
                                      </div>
                                    </div>
                                    @endif
                                  </div>
                                @endforeach
                                @if($total_receiver_answer > 10)
                                <div class="my-2 mt-4 text-center load-more-received">
                                    <input type="button" data-append="load-more-received" data-type="received" class="btn btn-primary btn-hover px-4 py-2" id="load-more-received" value="View More">
                                </div>
                                @endif
                                --}}
                              </div>
                              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                {{--
                                @foreach($sent_questions as $que)
                                <?php
                                $question1 = $que->question1;
                                $user_image = (new \App\Http\Helper\Web)->userDetail(@$question1->sender_id,'image');
                                $first_name = (new \App\Http\Helper\Web)->userDetail(@$question1->sender_id,'first_name');
                                $surname = (new \App\Http\Helper\Web)->userDetail(@$question1->sender_id,'surname');
                                $product_name =(new \App\Http\Helper\Web)->getProductDetail(@$question1->product_id,'product_title');
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

                                      <div class="text-pro ">
                                          <h6><b>Question</b> | {{date('F d, Y',strtotime($question1->created_at))}} from {{$first_name}} {{$surname}}</h6>  
                                      </div>
                                  </div>
                                   <div class="content-p mt-3">
                                        <div class="description d-none d-md-block">
                                            <p class="add-read-more show-less-content">{{$question1->question}}</p>
                                        </div>
                                    </div>
                                  
                                  <?php
                                      $store_name1 = (new \App\Http\Helper\Web)->storeDetail(@$que->sender_id,'store_name');
                                      $store_logo1 = (new \App\Http\Helper\Web)->storeDetail(@$que->sender_id,'store_logo'); 
                                  ?>
                                  <div class="rating-list ">
                                  <div class="d-flex profile-img align-items-center">
                                      <div class="profile-img me-3">
                                           <img src="{{@$store_logo1}}" alt="profile" class="img-fluid">
                                      </div>
                                      <div class="text-pro ">
                                          <h6><b>{{ @$store_name1 }}</b> | {{date('F d, Y',strtotime($que->created_at))}} (Classroom Copy Seller)</h6>
                                      </div>
                                  </div>
                                  <div class="content-p mt-3">
                                      <div class="description">
                                          <p class="add-read-more show-less-content">{{$que->question}}</p>
                                      </div>
                                  </div>
                                  <div class="content-p mt-3 button-box-{{$que->id}}">
                                      <div class="d-flex replay-box align-items-center justify-content-center justify-content-md-end">
                                          <div onclick="answerBox(this,'{{$que->id}}')" data-ans="{{$que->question}}" class="view-replay edit-answer edit-answer-{{$que->id}}">
                                              <a href="javascript:void(0)"><i class="fas fa-pencil me-1 "></i> Edit</a>
                                          </div>
                                          
                                      </div>
                                    </div>
                                  </div>
                                  
                                </div>
                                @endforeach
                                @if($total_sent_question > 10)
                                <div class="my-2 mt-4 text-center load-more-sent">
                                    <input type="button" data-append="load-more-sent" data-type="sent" class="btn btn-primary btn-hover px-4 py-2" id="load-more-sent" value="View More">
                                </div>
                                @endif
                                --}}
                                    <!-- <img src="{{asset('images/no-msg.png')}}" class="img-fluid" alt="No-messages"> -->
                              </div>
                              <div class="tab-pane fade text-start" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                  <div class="static-data">
                                     <!--  <p>This area is for Store Owners only. If you wish to contact a seller in relation to a product that you have purchased or are considering purchasing, please use the Q&A section of the individual resource page or via the Sellers Store directly.</p> -->
                                      <h3>Current Number of Followers: {{$followers}}</h3> 

                                        <p>Share information relating to new resources, current or upcoming sales. tips and tricks, or teaching ideas with your current followers.</p>
                                        
                                        <p><b>Note:</b></p> 
                                       <ul>
                                          <li> Content must comply with all Classroom Copy Documents and Policies.</li>
                                          <li> Communication should always be respectful and apply with all relevant laws and regulations.</li>
                                          <li>Spam is regarded as a breach of privacy and will be addressed accordingly.</li>
                                        </ul>
                                  </div>
                                  <form id="send-followers-email">
                                    <div class="comments-box">
                                      <div class="comments-header p-4">
                                        <div class="position-relative">
                                          <div class="author-thumd me-3">
                                               <img src="{{Storage::disk('s3')->url('store/'.$store->store_logo);}}" alt="">
                                        </div>
                                       
                                        <div class="subject">

                                          <p><b>From: </b>{{$store->store_name}}</p>
                                            <div class="form-group">
                                              <label>Subject:</label>
                                              <input type="text" name="subject" class="form-control"/>
                                            </div>
                                          </div>
                                        </div>
                                      </div>



                                      <div id="editor"></div>

                                    </div>
                                    <div class="comments-btn text-end">

                                      <input type="submit" class="btn-outlined-commnets" name="submit" value="Preview & Send">
                                    </div>
                                  </form>
                                  
                              </div>
                            </div>
                        
                        <!-- END tabs-content -->
                    </div>
                    <!-- END tabs -->
                </div>

                <div class="col-12 col-sm-12 col-md-4 col-lg-3 pt-5 ">
                    <div class="text-end pb-5 acc-dashboard-myinbox-right">
                        <a href="{{url()->previous()}}" class="blue acc-dashboard "><img src="{{asset('images/icon-1.png')}}" class="img-fluid me-2 my-1" alt=" ">Store Dashboard</a>
                    </div>
                    <!-- <div class="float-end prev-msg"><button type="submit " class="btn btn-hover  ">Previous Messages</button></div> -->
                </div>
            </div>
        </div>
    </section>
    <!--Store Dashboard - My Inbox Section Ends Here-->
    <style type="text/css">
      .modal p{
        margin-bottom: 0;
      }
      .write-tb table {
        border: 1px solid #dcdcdc;

      }
    </style>
    <!-- Final review for sending email model -->
    <div class="modal fade show" id="sendemail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="text-center" id="error_message">
                        <h3 class="modal-title text-black mb-3" id="staticBackdropLabel">Preview & Send</h3>
                    </div>
                    <div class="write-tb">
                      <table class="table" cellspacing="0">
                        <tr>
                          <th class="align-top" width="80">Suject:</th>
                          <td  class="ps-2 text-start"><span class="subject ps-0"></span></td>
                        </tr>
                        <tr >
                          <th class="align-top" width="80">Body:</th>
                          <td class="ps-2 text-start"><span class="content ps-0"></span></td>
                        </tr>
                      </table>
                      <button type="button" class="mt-2 btn btn-primary bg-blue btn-hover btn-round py-1 me-3 send-email">Send Now</button>
                      <button type="button" class="mt-2 btn btn-primary bg-blue py-1 btn-hover btn-round" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
    <script type="text/javascript">
      $(document).ready(function(){
        $("form#send-followers-email").on('submit',function(e){
            e.preventDefault();
            var subject = $("form#send-followers-email input[name='subject']").val();
            var description = CKEDITOR.instances['editor'].getData();

            
            $("form#send-followers-email .error_msg").remove();
            
            if (subject == "") {
                $("input[name='subject']").focus().select();
                $("input[name='subject']").after('<span class="error text-danger error_msg">Please enter a subject</span>');
                return false;
            }

            if (description == "") {
                $("#cke_editor").focus().select();
                $("#cke_editor").after('<span class="error text-danger error_msg">Please Add Content</span>');
                return false;
            }
            
            $("#sendemail span.subject").html(subject);
            $("#sendemail span.content").html(description);
            $("#sendemail").modal('show');
        });

        $("#sendemail .send-email").on('click',function(){
            var subject = $("form#send-followers-email input[name='subject']").val();
            var description = CKEDITOR.instances['editor'].getData();
            $.ajax({
              url: "{{route('send.email.to.buyers')}}",
              type: 'POST',
              data: {'_token': "{{ csrf_token() }}",subject:subject,description:description},
              dataType: 'json',
            }).done(function (response, status, xhr) {
                $("#sendemail").modal('hide');
                if(response.success == true){
                  swal.fire("Done", response.message, "success");
                  setTimeout(function(){
                    location.reload();
                  },3000);
                }
                if(response.success == false){
                  swal.fire("Error", "Something wrong! Please refresh page.", "error");
                }
            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                
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
      });
      function answerBox(e,id,answer="") {
        answer =e.dataset.ans
        $('.question-box').remove();
        $('.questions-box-'+id).remove();
        edit = "Post Answer";
        action = "add";
        if(answer !=""){
          edit = "Update Answer";
          action = "edit";
        }
        let html = '';
        html += '<div class="row g-3 border col-12 question-box questions-box-'+id+' p-3 bg-light mt-3 mb-4" >';
        html += '    <form name="fff">';
        html += '        <div class="mb-3">';
        html += '            <textarea class="form-control" id="answer-text" rows="3">'+answer+'</textarea>';
        html += '        </div>';
        html += '        <div class="col-auto d-flex justify-content-end">';
        html += '            <div class="col-auto d-flex justify-content-end">';
        html += '                <button onclick="hideQuestionBox('+id+')" type="button" data-question="'+id+'"  class="btn btn-light cancel border border-dark border-1">Cancel</button>';
        html += '                <button type="button" data-question="'+id+'" data-action="'+action+'" class="btn btn-primary ms-3 post-answer">'+edit+'</button>';
        html += '            </div>';
        html += '        </div>';
        html += '    </form>';
        html += '</div>';
        $('.button-box-'+id).append(html);
      }
      function hideQuestionBox(id){
        $('.questions-box-'+id).remove();
    }
    $('body').on('click', '.post-answer', function() {
      let question_id = $(this).data('question');
      let action = $(this).data('action');

      if ($('#answer-text').val() == '' || $.trim($('#answer-text').val()).length == 0) {
          if ($.trim($('#answer-text').val()).length == 0)
              $('#question-text').val('')
          $('#answer-text').focus().select();
          $("#answer-text").css('border-color', 'red');
          return false;
      }
      $(this).prop('disabled',true);
      let answer = $('#answer-text').val();

      $.ajax({
          url: "{{route('add-question')}}",
          type: 'POST',
          data: {'_token': "{{ csrf_token() }}",answer:answer,question_id:question_id,type:'seller',action:action},
          dataType: 'json',
      }).done(function (response, status, xhr) {
          $(this).prop('disabled',false);
          if (response.success === false) {
              swal.fire("Oops!", response.message, "error");
          }
          if (response.success === true) {
                $('.button-box-'+question_id).remove();
              //$('.nav-tabs button[id="profile-tab"]').tab('show');
              let  user_id = "{{auth()->user()->id}}";
              $.ajax({
                url: "{{route('store-my-inbox-load-more')}}",
                type: 'POST',
                data: {'_token': "{{ csrf_token() }}",take:10,skip:0,type:'sent',user_id:user_id,view_more:true},
                dataType: 'json',
                

            }).done(function (response, status, xhr) {
                if (response.success === false) {
                  swal.fire("Oops!", response.message, "error");
                }
                // $('.question-box').addClass('d-none');
                if (response.success === true) {
                    skip_sent = skip_sent + take_sent;
                    
                    if(response.data.length !== 0){
                        $('#profile').empty();
                        $('#profile').append(response.html)
                        let view_more_btn = '';
                        view_more_btn += '<div class="my-2 mt-4 text-center load-more-sent">';
                        view_more_btn += '    <input type="button" data-append="load-more-sent" data-type="sent" class=" load-more-sent btn btn-primary btn-hover px-4 py-2" id="load-more-sent" value="View More">';
                        view_more_btn += '</div>';
                        //$('#profile').append(view_more_btn)
                    }
                }
            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
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
          }
      }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
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
    </script>
    @endpush
@endsection
@push('script')
<script type="text/javascript">
  //for load more data 
    
    let take_sent = 10;
    let skip_sent = 10;
    //LOAD MORE DATA
    $('body').on('click', '#load-more-sent', function() {
      
        let  user_id = "{{auth()->user()->id}}";
        $.ajax({
            url: "{{route('store-my-inbox-load-more')}}",
            type: 'POST',
            data: {'_token': "{{ csrf_token() }}",take:take_sent,skip:skip_sent,type:'sent',user_id:user_id,view_more:false},
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

    //LOAD MORE DATA
    let take = 10;
    let skip = 10;
    $('body').on('click', '#load-more-received', function() {

        let  user_id = "{{auth()->user()->id}}";
      
        $.ajax({
            url: "{{route('store-my-inbox-load-more')}}",
            type: 'POST',
            data: {'_token': "{{ csrf_token() }}",take:take,skip:skip,type:'received',user_id:user_id},
            dataType: 'json',
            beforeSend: function() {
                $("#load-more-received").val('Loading......');
               $("#load-more-received").prop('disabled', true);
            },

        }).done(function (response, status, xhr) {
            $("#load-more-received").val('View More');
            
            if (response.success === false) {
              swal.fire("Oops!", response.message, "error");
            }
            // $('.question-box').addClass('d-none');
            if (response.success === true) {
                skip = skip +take;
                if(response.data.length === 0){
                    $("#load-more-received").prop('disabled', true);
                }else{
                    console.log(response.html)
                    $('.load-more-received').before(response.html)
                }
                $("#load-more-received").prop('disabled', false);
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
       function AddReadMoreInboxStore() {
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
       AddReadMoreInboxStore();
});
</script>
@endpush