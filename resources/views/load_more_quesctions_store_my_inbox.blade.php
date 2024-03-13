@if($type == "received")
@foreach($receiver_answer as $question)
  <?php
  $answer = $question->answer;
  $user_image = (new \App\Http\Helper\Web)->userDetail(@$question->sender_id,'image');
  $first_name = (new \App\Http\Helper\Web)->userDetail(@$question->sender_id,'first_name');
  $surname = (new \App\Http\Helper\Web)->userDetail(@$question->sender_id,'surname');
  $product_name =(new \App\Http\Helper\Web)->getProductDetail(@$question->product_id,'product_title');
  ?>
    <div class="rating-list mb-5 here11">
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
      @if($question->answered == false)
      <div class="content-p mt-3 button-box-{{$question->id}}" >
        <div class="d-flex replay-box align-items-center justify-content-center justify-content-md-end">
            <div onclick="answerBox(this,'{{$question->id}}')" data-ans="" class="view-replay answer answer-{{$question->id}}" data-id="{{$question->id}}">
                <a href="javascript:void(0)"><i class="fas fa-reply me-1 "></i> Post Answer</a>
            </div>
            
        </div>
      </div>
      @elseif(isset($check) && !empty($check))
      <?php
      $store_name1 = (new \App\Http\Helper\Web)->storeDetail(@$answer->sender_id,'store_name');
      $store_logo1 = (new \App\Http\Helper\Web)->storeDetail(@$answer->sender_id,'store_logo');
      ?>
      <div class="rating-list ">
          <div class="d-flex profile-img align-items-center">
            <div class="profile-img me-3">
                 <img src="{{@$store_logo1}}" alt="profile" class="img-fluid">
            </div>
            <div class="text-pro ">
                <h6><b>{{ @$store_name1 }}</b> | {{date('F d, Y',strtotime($answer->created_at))}} (Classroom Copy Seller)</h6>
            </div>
          </div>
          <div class="content-p mt-3">
            <div class="description">
                <p class="add-read-more show-less-content">{{$answer->question}}</p>
            </div>
          </div>
          <div class="content-p mt-3 button-box-{{$answer->id}}">
            <div class="d-flex replay-box align-items-center justify-content-center justify-content-md-end">
              <div onclick="answerBox(this,'{{$answer->id}}')" data-ans="{{$answer->question}}" class="view-replay edit-answer edit-answer-{{$answer->id}}">
                  <a href="javascript:void(0)"><i class="fas fa-pencil me-1 "></i> Edit</a>
              </div> 
            </div>
          </div>
      </div>
      @endif
    </div>
  @endforeach
  @if($total_receiver_answer > 10)
    @if($view_more == true) 
      <div class="my-2 mt-4 text-center load-more-received" id="{{$view_more}}">
          <input type="button" data-append="load-more-received" data-type="received" class="btn btn-primary btn-hover px-4 py-2" id="load-more-received" value="View More">
      </div>
    @endif
  @endif
@else
    @foreach($sent_questions as $que)
    <?php
    $question1 = $que->question1;
    $user_image = (new \App\Http\Helper\Web)->userDetail(@$question1->sender_id,'image');
    $first_name = (new \App\Http\Helper\Web)->userDetail(@$question1->sender_id,'first_name');
    $surname = (new \App\Http\Helper\Web)->userDetail(@$question1->sender_id,'surname');
    $product_name1 =(new \App\Http\Helper\Web)->getProductDetail(@$question1->product_id,'product_title');
    ?>
    <div class="rating-list mb-5 here {{$view_more}}">
      <div class="profile-title d-md-flex justify-content-between">
          <div class="date-pro">
              <p>{{$product_name1}}</p>
          </div>
      </div>
      <div class="d-flex profile-img align-items-md-top align-items-start">
          <div class="profile-img me-3">
              <img src="{{$user_image}}" alt="profile" class="img-fluid">
          </div>

          <div class="text-pro com-text">
              <h6><b>Question</b> | {{date('F d, Y',strtotime($question1->created_at))}} from {{$first_name}} {{$surname}}</h6>

              <div class="description d-none d-md-block ">
                  <p class="add-read-more show-less-content">{{$question1->question}}</p>
              </div>
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
          <div class="text-pro com-text">
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
                  <a href="javascript:void(0)"><i class="fas fa-reply me-1 "></i> Edit</a>
              </div>
              
          </div>
        </div>
      </div>
      
    </div>
    @endforeach
    @if($total_sent_question > 10)
      @if($view_more == true) 
        <div class="my-2 mt-4 text-center load-more-sent" id="{{$view_more}}">
          <input type="button" data-append="load-more-sent" data-type="sent" class="btn btn-primary btn-hover px-4 py-2" id="load-more-sent" value="View More">
        </div>
      @endif
    @endif
@endif