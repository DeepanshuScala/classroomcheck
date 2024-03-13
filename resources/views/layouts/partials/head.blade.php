<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="@yield('description')" />
    <meta property="og:url" content="{{Request::url()}}" />
    <meta property="og:image" content="{{isset($ogimage)?$ogimage:''}}" />

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{Request::url()}}">
    <meta name="twitter:title" content="@yield('title')">
    <meta name="twitter:image" content="{{isset($ogimage)?$ogimage:''}}">
    <meta name="twitter:description" content="@yield('description')" />
    <!--<link rel="stylesheet" href="{{--asset('css/all.css')--}}">--> 
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!--<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css"-->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <link rel="icon" href="{{asset('images/favicon.jpg')}}" type="image/jpg"> 
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css?ver=3.1')}}">
    <link rel="stylesheet" href="{{asset('css/media.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="{{--asset('plugins/select2/css/select2.min.css')--}}">
    <link rel="stylesheet" href="{{--asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')--}}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>    
    <!-- <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}"> -->
    <link rel="stylesheet" href="{{asset('css/pb.calendar.css?ver=1.1')}}"> <!--<link rel="stylesheet" href="{{asset('css/calender-full.css')}}">-->
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/simplePagination.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
    <link rel="stylesheet" href="{{asset('css/easyzoom.css')}}">
    <style>
    
    .zoom {
  width: auto !important;
  height: 400px;
  display: inline-block !important;
}
            /* Customized Bootstrap Pagination */
        .pagination {
            margin: 0 0; 
        }
        .pagination.pagination-circle > li:first-child > a {
            border-radius: 25px 0 0 25px !important; 
        }
        .pagination.pagination-circle > li:last-child > a {
            border-radius: 0 25px 25px 0 !important; 
        }
        .pagination .active > a,
        .pagination .active > a:hover {
            background: #eee;
            border-color: #dddddd;
            color: #333; 
        }

        .pagination {
            display: inline-block;
            padding-left: 0;
            margin: 20px 0;
            border-radius: 4px;
        }
        .pagination > li {
            display: inline; }
            .pagination > li > a,
            .pagination > li > span {
              position: relative;
              float: left;
              padding: 6px 12px;
              line-height: 1.42857;
              text-decoration: none;
              color: #337ab7;
              background-color: #fff;
              border: 1px solid #ddd;
              margin-left: -1px; }
            .pagination > li:first-child > a,
            .pagination > li:first-child > span {
              margin-left: 0;
              border-bottom-left-radius: 4px;
              border-top-left-radius: 4px; }
            .pagination > li:last-child > a,
            .pagination > li:last-child > span {
              border-bottom-right-radius: 4px;
              border-top-right-radius: 4px; }
          .pagination > li > a:hover,
          .pagination > li > a:focus,
          .pagination > li > span:hover,
          .pagination > li > span:focus {
            z-index: 3;
            color: #23527c;
            background-color: white;
            border-color: #ddd; }
          .pagination > .active > a,
          .pagination > .active > a:hover,
          .pagination > .active > a:focus,
          .pagination > .active > span,
          .pagination > .active > span:hover,
          .pagination > .active > span:focus {
            z-index: 2;
            color: #fff;
            background-color: #337ab7;
            border-color: #337ab7;
            cursor: default; }
          .pagination > .disabled > span,
          .pagination > .disabled > span:hover,
          .pagination > .disabled > span:focus,
          .pagination > .disabled > a,
          .pagination > .disabled > a:hover,
          .pagination > .disabled > a:focus {
            color: #6c8dae;
            background-color: #fff;
            border-color: #ddd;
            cursor: not-allowed; }

        .pagination-lg > li > a,
        .pagination-lg > li > span {
          padding: 10px 16px;
          font-size: 18px;
          line-height: 1.33333; }

        .pagination-lg > li:first-child > a,
        .pagination-lg > li:first-child > span {
          border-bottom-left-radius: 6px;
          border-top-left-radius: 6px; }

        .pagination-lg > li:last-child > a,
        .pagination-lg > li:last-child > span {
          border-bottom-right-radius: 6px;
          border-top-right-radius: 6px; }

        .pagination-sm > li > a,
        .pagination-sm > li > span {
          padding: 5px 10px;
          font-size: 12px;
          line-height: 1.5; }

        .pagination-sm > li:first-child > a,
        .pagination-sm > li:first-child > span {
          border-bottom-left-radius: 3px;
          border-top-left-radius: 3px; }

        .pagination-sm > li:last-child > a,
        .pagination-sm > li:last-child > span {
          border-bottom-right-radius: 3px;
          border-top-right-radius: 3px; }
</style>
    @stack('specific_page_css')
</head>