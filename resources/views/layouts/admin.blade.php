<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('dcs.template.app_name') }} | @yield('page-title')</title>
    <link rel="apple-touch-icon" href="{{URL::asset('app-assets/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{URL::asset(config('dcs.template.app_logo'))}}">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700"
        rel="stylesheet">

    {{--    Styles --}}
    @include('template::layouts.assets._styles')

</head>
<!-- END: Head-->
@php
    $user_menu = null;
        if (Auth::check()) {
            $user_menu = $menus->firstWhere('sys_types_user_id', Auth::user()->sys_types_user_id);
        }
@endphp
<body class="vertical-layout @if($user_menu) vertical-menu 2-columns @endif fixed-navbar"
      data-open="click"
      data-menu="vertical-menu"
      data-col="2-columns"
>

<!-- BEGIN: Header-->
@include('menu::layouts.navbar._with-menu')
<!-- END: Header-->

@include("menu::layouts.sidebar._sidebar")

<!-- END: Main Menu-->
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-header row justify-content-center align-items-center shadow-sm">
        <div class="breadcrumbs-top col-12">
            <div class="breadcrumb-wrapper bg-dark d-flex justify-content-center">
                @yield('subnav')
            </div>
        </div>
    </div>
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            @yield('page-content')
        </div>
    </div>
</div>
<!-- END: Content-->

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

{{-- Models --}}
@include('template::layouts._modal')
{{--END: Model--}}

<!-- BEGIN: Footer-->
@include('template::layouts.footer._footer')
<!-- END: Footer-->

{{--Scripts--}}
@include('template::layouts.assets._scripts')
</body>
<!-- END: Body-->

</html>
