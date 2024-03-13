
@if($type == "received")

    @foreach($receiver_answer as $que)
    <!-- Received Tab-->
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
@else
    
    @foreach($sent_questions as $question)
    <!-- Sent Tab-->
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
@endif