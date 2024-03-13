<section class="hero-section">        
	<div class="container py-5">            
		<div class="row flex-lg-row-reverse align-items-center pt-5 g-4">                
			<div class="col-12 col-sm-12 col-lg-6 pt-2  mb-3">                    
				<img src="{{asset('images/hero-img.jpg')}}" class="d-block mx-lg-auto img-fluid" alt="hero-img">                
			</div>                
			<div class="col-lg-6 col-sm-12 my-0">                    
				<h1 class="display-5 fw-bold lh-1 mb-3 d-flex flex-column">Your world of <br>
					<span class="blue display-5 fw-bold">Educational Resources</span>
				</h1>                    
				<p class="lead">"Classroom Copy is an online marketplace for original resources created by teachers for teachers"                   
				</p>
				@if(!Auth::check())                    
				<p class="blue fw-bold">Inspiration is only a click away!</p>                    
				<div class="d-grid gap-2 d-md-flex justify-content-md-start">                        
					<a href="{{route('account.dashboard.join.now')}}" class="btn btn-primary bg-blue btn-lg px-4 my-4 me-md-2 btn-hover text-uppercase">Join free now</a>                    
				</div>
				@endif                
			</div>            
		</div>    
</section>