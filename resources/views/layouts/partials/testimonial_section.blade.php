<?php
$get_testimonials = DB::Table('testimonials')->orderby('id','DESC')->take(4)->get();
if(count($get_testimonials) > 0){
?>
<section class="testimonial-section py-4 pb-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          <h3 class="text-uppercase pt-5 pb-3"><span class="heading border px-5 py-2">Testimonial</span></h3>
          <div id="testimonial-slider" class="owl-carousel" data-slider-id="1">
            <?php
            foreach($get_testimonials as $testimonial){
            ?>
            <div class="testimonial">
              <i class="fal fa-quote-left fa-4x pr-5 text-white float-start"></i>
              <p class="description px-2 pt-4 px-md-5">
                {{$testimonial->content}}
              </p>
              <h4 class="title">{{$testimonial->name}}</h4>
            </div>
            <?php
            }
            ?>
          </div>
          <div class="owl-thumbs" data-slider-id="1">
            <?php
            foreach($get_testimonials as $testimonial){
            ?>
            <button class="owl-thumb-item active">
              <div class="userimg">
                <img src="{{url('/storage/uploads/testimonials/'.$testimonial->image)}}" alt="{{$testimonial->name}}">
              </div>
            </button>
            <?php
            }
            ?>
          </div>
        </div>
      </div>
    </div>
</section>
<?php
}
?>