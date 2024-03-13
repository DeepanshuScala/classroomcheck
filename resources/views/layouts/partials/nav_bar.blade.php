<nav class="py-1 top-bar border-bottom ">

    <div class="container navbar navbar-expand-lg py-0 d-flex flex-wrap">
        <a href="{{route('classroom.index')}}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none "><img src="{{asset('images/logo.png')}}" class="img-fluid mr-3 logo" alt="Classroom-logo"></a>
        <button class="navbar-toggler mytoggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample09" aria-controls="navbarsExample09" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon mytoggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse fade" id="navbarsExample09">
            <ul class="nav top-links ms-auto">
                @if(Auth::check())
                <li class="nav-item"><a href="{{route('accountDashboard.myWishlist')}}" class="nav-link link-light border-start px-3"><i class="fal fa-heart px-2"></i> Wishlist</a></li>
                @else
                <li class="nav-item"><a href="javascript:void(0)" class="nav-link link-light border-start px-3 memberLogin"><i class="fal fa-heart px-2"></i> Wishlist</a></li>
                @endif

                @if(Auth::check())
                @php

                @endphp
                <li class="nav-item">
                    <a href="{{route('accountDashboard.myCart')}}" class="nav-link border-start link-light px-3 main-cart"><i class="fal fa-shopping-cart px-2  position-relative me-1"> <span id="cart" class="cart-item position-absolute cart-position translate-middle bg-danger rounded-circle"></span></i>My Cart</a>
                </li>
                @else
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link border-start link-light px-3 main-cart-logout  memberLogin"><i class="fal fa-shopping-cart px-2  position-relative me-1"></i>My Cart</a>
                </li>
                @endif

                @if(!Auth::check())
                <li class="nav-item"><a href="{{route('account.dashboard.join.now')}}" class="nav-link link-light border-start px-3"><i class="fal fa-user px-2"></i>Join Us - Free</a></li>
                @endif


                @if(Auth::check())
                @include('layouts.partials.my_account')
                @endif
            </ul>
            @if(!Auth::check())
            <ul class="nav login">
                <li class="nav-item"><a href="javascript:void(0)" class="nav-link link blue px-3 btn btn-light text-uppercase py-1 my-1 fw-bold login-btn memberLogin" id="memberLogin">Login</a></li>
            </ul>
            @endif
        </div>
    </div>
</nav>