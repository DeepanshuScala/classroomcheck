@foreach($questions as $question)
<div class="rating-list mb-5">
    <div class="d-flex profile-img align-items-center">
        <div class="profile-img me-3">
            <img src="{{$question->user_image}}" alt="profile" class="img-fluid">
        </div>
        <div class="text-pro">
            <h6><b>Question</b> | {{$question->date}} from {{$question->username}}</h6>
        </div>
    </div>
    <div class="content-p mt-3">
        <div class="description">
            <p class="des-question{{$question->id}} add-read-more show-less-content">{{$question->question}}</p>
        </div>
    </div>
    @if (Auth::check())
    @if(auth()->user()->id == $question->sender_id)
    @if($question->answered === false)
    <div class="content-p mt-3 mb-4 button-box-{{$question->id}}">
        <div class="d-flex replay-box align-items-center justify-content-center justify-content-md-end">
            <div onclick="questionBox('{{$question->id}}','{{$question->question}}')" class="view-replay answer answer-{{$question->id}}" data-id="{{$question->id}}">
                <a href="javascript:void(0)"><i class="fas fa-reply me-1 "></i> Update Question</a>
            </div>
        </div>
        <!-- <div class="row g-3 border col-12 question-box-update question-box questions-box-{{$question->id}} p-3 bg-light mt-3 mb-4 d-none">
            <form name="fff">
                <div class="mb-3">            
                    <textarea class="form-control answer-text{{$question->id}}" id="answer-text" rows="3">{{$question->question}}</textarea>        
                </div>
                <div class="col-auto d-flex justify-content-end">
                    <div class="col-auto d-flex justify-content-end">                
                        <button onclick="hideQuestionBox('{{$question->id}}')" type="button" data-question="{{$question->id}}" class="btn btn-light cancel border border-dark border-1">Cancel</button>                
                        <button type="button" data-question="{{$question->id}}" data-action="edit" class="btn btn-primary ms-3 post-answer">Update Answer</button>            
                    </div>
                </div>
            </form>
        </div> -->
    </div>
    @endif
    @endif
    @endif
    @foreach($question->answers as $answer)
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
                <!-- <h6>Answer | November 18, 2022 from Abhistore (Classroom Copy Seller).</h6> -->
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