<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ env('APP_NAME') }} | @yield('title')</title>
        <link rel="icon" href="{{asset('images/favicon.jpg')}}" type="image/jpg"> 
        @include('admin.includes.head')
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            @include('admin.includes.header')
            @include('admin.includes.sidebar')

            <div class="content-wrapper">
                @yield('content')
            </div>

            @include('admin.includes.footer')
            @yield('scripts')
        </div>
    </body>
</html>