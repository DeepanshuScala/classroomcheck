<!--//... auth page breadcrumb-section //-->
<section class="breadcrumb-section bg-light-blue pt-2" id="breadcrumb-section-auth-page">
    <div class="container py-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                @if(isset($data['home']) && $data['home'])
                    <li class="breadcrumb-item active"><a href="{{route('classroom.index')}}"><i class='fal fa-home-alt'></i> {{$data['home']}}</a></li>
                @endif
                @if(isset($data['breadcrumb1']) && $data['breadcrumb1'])
                    <li class="breadcrumb-item" aria-current="page">
                        @if(isset($data['breadcrumb1_link']) && $data['breadcrumb1_link'])
                            <a href="{{$data['breadcrumb1_link']}}">{{$data['breadcrumb1']}}</a>
                        @else
                            {{$data['breadcrumb1']}}
                        @endif
                    </li>
                @endif
                @if(isset($data['breadcrumb2']) && $data['breadcrumb2'])
                    <li class="breadcrumb-item" aria-current="page">
                        @if(isset($data['breadcrumb2_link']) && $data['breadcrumb2_link'])
                            <a href="{{$data['breadcrumb2_link']}}">{{$data['breadcrumb2']}}</a>
                        @else
                            {{$data['breadcrumb2']}}
                        @endif
                    </li>
                @endif
                @if(isset($data['breadcrumb3']) && $data['breadcrumb3'])
                    <li class="breadcrumb-item" aria-current="page">
                        @if(isset($data['breadcrumb3_link']) && $data['breadcrumb3_link'])
                            <a href="{{$data['breadcrumb3_link']}}">{{$data['breadcrumb3']}}</a>
                        @else
                            {{$data['breadcrumb3']}}
                        @endif
                    </li>
                @endif
                @if(isset($data['breadcrumb4']) && $data['breadcrumb4'])
                    <li class="breadcrumb-item" aria-current="page">
                        @if(isset($data['breadcrumb4_link']) && $data['breadcrumb4_link'])
                            <a href="{{$data['breadcrumb4_link']}}">{{$data['breadcrumb4']}}</a>
                        @else
                            {{$data['breadcrumb4']}}
                        @endif
                    </li>
                @endif
                
            </ol>
        </nav>
    </div>
</section>

<!--//... product serach page breadcrumb-section //-->
<section class="breadcrumb-section bg-light-blue pt-2" id="breadcrumb-section-search-page" style="display: none;">
    <div class="container py-2">
        <p class="text-center">Search for resources using one or all the drop-down menu options. Alternatively, type your search requirements in the top search bar.</p>
    </div>
</section>
<!--// product serach page section ...//-->