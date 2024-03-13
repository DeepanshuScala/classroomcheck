<li class="nav-item dropdown">
    <a class="nav-link text-white dropdown-toggle avatar" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <?php
    
            $m_img = asset('images/book-img.png');
            if(Auth::check()){
                $role = auth()->user()->role_id;
                if($role == 1){

                    $m_img = (!empty(auth()->user()->image)) ? Storage::disk('s3')->url('profile_picture/'.auth()->user()->image) : asset('images/book-img.png');
                }
                elseif($role == 2){
                    
                    $st_logo = DB::table('crc_store')->select('store_logo')->where('user_id',auth()->user()->id)->get();
                    if(!$st_logo->isEmpty()){
                        foreach ($st_logo as $key => $value) {
                           $m_img = Storage::disk('s3')->url('store/'.$value->store_logo);
                        }
                    }
                }
            }
        ?>
        <img id="headerProfileImageUpdate" src="{{$m_img}}" class="img-fluid rounded-circle  me-1" alt="profile-pic">
        <i class='fal fa-chevron-down'></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-light mt-0 pb-sm-5 pb-3 pt-0 ">
        <li class="py-2 mb-0 mb-sm-3">
            <a class="dropdown-item blue" href="javascript:void(0)">
                <i class="fal fa-user px-2"></i> Account
            </a>
        </li>
        <!--li>
            <a class="dropdown-item" href="{{auth()->user()->role_id==1?route('classroom.index'):route('accountDashboard.for.storeUser')}}">
                <i class="fal fa-chevron-right px-2"></i> Account Dashboard
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="{{auth()->user()->role_id==2?route('classroom.index'):route('storeDashboard.for.accountUser')}}"">
                <i class="fal fa-chevron-right px-2"></i> Store Dashboard
            </a>
        </li-->
        <li>
            <a class="dropdown-item" href="{{ URL('dashboard/account') }}">
                <i class="fal fa-chevron-right px-2"></i> Account Dashboard
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ URL('dashboard/seller') }}"">
                <i class="fal fa-chevron-right px-2"></i> Store Dashboard
            </a>
        </li>
        <li class="nav-item login">
            <a href="{{route('auth.logout')}}" class="nav-link bg-blue text-white px-3 btn btn-lg text-uppercase py-2 mx-4 mt-3 fw-bold login-btn">
                Log out
            </a>
        </li>
    </ul>
</li>