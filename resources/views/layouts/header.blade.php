
<header>
    <div class="loading-overlay is-active" style="display:none;">
        <span class="fas fa-spinner fa-3x fa-spin"></span>
    </div>


    <!--Nav Bar start -->
    @include('layouts.partials.nav_bar')
    <!--Nav Bar end ./-->
    <div class="container-fluid py-3 mb-3 border-bottom">
        <div class="container middle-search-section pb-2">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-7">
                    <ul class="d-flex flex-row justify-content-end menu-links mb-2 mb-lg-0 ">
                        <li class="nav-item"><a href="{{route('become.a.seller')}}" class="nav-link">Become a Seller </a></li>
                        <?php if (Auth::check()) { ?>
                            <li class="nav-item"><a href="{{route('gift.card')}}" class="nav-link">Gift Cards</a></li>
                        <?php } else { ?>
                            <li class="nav-item"><a style="cursor: pointer;"  class="nav-link memberLogin">Gift Cards</a></li>
                        <?php } ?>
                        <li class="nav-item"><a href="{{route('help.faq')}}" class="nav-link">Help</a></li>
                    </ul>
                </div>
                <div class="col-12 col-sm-12 col-md-5">
                    <?php
                    $postSearchKeyword = (isset($postData) && !empty($postData) && isset($postData['search_keyword'])) ? $postData['search_keyword'] : old('search_keyword');
                    ?>
                    <form action="javascript:void(0)" method="post" name="productSearchForm1" id="productSearchForm1">
                        @csrf
                        <div class="search">
                            <input type="text" name="search_keyword" id="search_keyword" class="form-control" value="{{ $postSearchKeyword }}" placeholder="Search" required="">
                            <button type="submit" id="globalSearchBtn" class="btn-hover"> <i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid pb-3 d-flex flex-wrap justify-content-center border-bottom">
        <div class="container  bottom-select-section">
            <?php
            $postLang = (isset($postData) && !empty($postData) && isset($postData['fs_language'])) ? $postData['fs_language'] : old('fs_language');
            $postGrade = (isset($postData) && !empty($postData) && isset($postData['fs_grade'])) ? $postData['fs_grade'] : old('fs_grade');
            $postSubject = (isset($postData) && !empty($postData) && isset($postData['fs_subject'])) ? $postData['fs_subject'] : old('fs_subject');
            $postPrice = (isset($postData) && !empty($postData) && isset($postData['fs_price'])) ? $postData['fs_price'] : old('fs_price');
            $postType = (isset($postData) && !empty($postData) && isset($postData['fs_type'])) ? $postData['fs_type'] : old('fs_type');
            $postFormat = (isset($postData) && !empty($postData) && isset($postData['fs_format'])) ? $postData['fs_format'] : old('fs_format');
            ?>
            <form class="row g-3 align-items-center" action="javascript:void(0)" method="POST" name="productFilterSearchForm" id="productFilterSearchForm">
                @csrf
                <input type="hidden" value="filter-search-true" name="filter_search">
                <input type="hidden" name="page" value="1" >
                <div class="col-12 col-sm-6 col-md-6  w-200">
                    <select class="form-select" id="fs_language" name="fs_language">
                        <option value="" selected>Language</option>
                        <?php
                        $languageArr = (new App\Http\Helper\ClassroomCopyHelper())->getLanguages();
                        ?>
                        @foreach($languageArr as $lang)
                        <option value="{{$lang->id}}" data-lang="{{ $lang->language }}" {{ $postLang == $lang->id? 'selected':'' }}>{{$lang->language}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-6 w-200">
                    <?php
                    $gradeLevelArr = (new App\Http\Helper\ClassroomCopyHelper())->getProductLevel();
                    ?>
                    <select class="form-select" id="fs_grade" name="fs_grade">
                        <option value="" selected>Grade</option>
                        @foreach($gradeLevelArr as $level)
                        <option value="{{$level->id}}" data-grade="{{$level->grade}}" {{ $postGrade == $level->id? 'selected':'' }}>{{$level->grade}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-6 w-200">
                    <?php
                    $productSubjectArr = (new App\Http\Helper\ClassroomCopyHelper())->getProductSubjectArea();
                    ?>
                    <select class="form-select" id="fs_subject" name="fs_subject">
                        <option value="" selected>Subject</option>
                        @foreach($productSubjectArr as $productSubject)
                        <option value="{{$productSubject->id}}" data-subject="{{$productSubject->name}}" {{ $postSubject == $productSubject->id? 'selected':'' }}>{{$productSubject->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-6 w-200">
                    <select class="form-select" id="fs_price" name="fs_price">
                        <option value="" selected>Price</option>
                        <option value="free" data-price="Free" {{ $postPrice == 'free' ? 'selected':'' }}>Free</option>
                        <option value="less_than_5" data-price="Under $5" {{ $postPrice == 'less_than_5' ? 'selected':'' }}>Under $5</option>
                        <option value="5_10" data-price="$5 - $10" {{ $postPrice == '5_10' ? 'selected':'' }}>$5 - $10</option>
                        <option value="greater_than_10" data-price="Over $10" {{ $postPrice == 'greater_than_10' ? 'selected':'' }}>Over $10</option>
                        <option value="on_sale" data-price="On Sale" {{ $postPrice ==  'on_sale' ? 'selected':'' }}>On Sale</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-6 w-200">
                    <select class="form-select" id="fs_type" name="fs_type">
                        <option value="" selected>Resource Type</option>
                        <?php
                        $resourceTypeArr = (new App\Http\Helper\ClassroomCopyHelper())->getResourceTypes();
                        ?>
                        @foreach($resourceTypeArr as $resource)
                        <option value="{{$resource->id}}" data-resource="{{$resource->name}}" {{ $postType == $resource->id? 'selected':'' }}>{{$resource->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-6 w-200">
                    <select class="form-select" id="fs_format" name="fs_format">
                        <option value="" selected>Format</option>
                        <?php
                        $productFileTypeArr = (new App\Http\Helper\ClassroomCopyHelper())->getProductType();
                        ?>
                        @foreach($productFileTypeArr as $productFileType)
                        <option value="{{$productFileType}}" {{ $postFormat == $productFileType? 'selected':'' }}>{{$productFileType}}</option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="sort-by">
                <input type="hidden" name="search_keyword" value="{{ (isset($_POST['search_keyword']) && !empty($_POST['search_keyword']))? $_POST['search_keyword']:''}}">
                <div class="col-auto search-btn">
                    <button type="submit" class="btn text-uppercase btn-hover" id="filterSearchSubmitBtn">Search</button>
                </div>
            </form>
        </div>
    </div>
</header>