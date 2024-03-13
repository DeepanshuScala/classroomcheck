<section class="footer-section">
    <div class="container">
        <footer class="row row-cols-5 py-5 my-5">
            <div class="col-12 col-sm-12 col-md-4 pb-3">
                <a href="{{route('classroom.index')}}" class="">
                    <img src="{{asset('images/footer-logo.png')}}" class="img-fluid mr-3" alt="Classroom-footer-logo">
                </a>
            </div>
            <div class="col-12 col-sm-12 col-md-2 pb-3">
                <h5 class="border-start ps-4">About Us</h5>
                <ul class="nav flex-column footer-links ms-4 mt-3">
                    <li class="nav-item mb-2"><a href="{{route('about.us')}}" class="nav-link p-0 text-dark">Who We Are</a></li>
                    <li class="nav-item mb-2"><a href="{{ URL('/blogs') }}" class="nav-link p-0 text-dark">Blog</a></li>
                </ul>
            </div>
            <div class="col-12 col-sm-12 col-md-3 pb-3">
                <h5 class="border-start ps-4">Support</h5>
                <ul class="nav flex-column footer-links ms-4 mt-3">
                    <li class="nav-item mb-2"><a href="{{route('help.faq')}}" class="nav-link p-0 text-dark">Help and FAQ</a></li>
                    <li class="nav-item mb-2"><a href="{{route('document.and.policies')}}" class="nav-link p-0 text-dark">Documents and Policies</a></li>
                    <li class="nav-item mb-2"><a href="{{ URL('/contact-us') }}" class="nav-link p-0 text-dark">Contact Us</a></li>

                </ul>
            </div>
            <div class="col-12 col-sm-12 col-md-3">
                <h5 class="border-start ps-4">Keep in Touch</h5>
                <ul class="nav flex-column mt-3">
                    <li class="nav-item mb-2">
                        <p>Subscribe to get free resources, updates and special offers.</p>
                    </li>
                    <li class="nav-item mb-2 ">
                        <a href="{{ URL('/subscribe') }}" class="nav-link p-0 text-dark">
                            <button type="button" class="btn-hover btn btn-primary sign-up bg-blue btn-lg px-4 my-2 me-md-2 text-uppercase">
                                Subscribe Now
                            </button>
                        </a>
                    </li>

                </ul>
            </div>

        </footer>
    </div>
    <div class="bg-dark text-center">
        <p class=" text-white py-3 mb-0">&copy; 2023 - Classroom Copy. All rights reserved.</p>
    </div>
</section>