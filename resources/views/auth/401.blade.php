@php
    if (Auth::check()) {
        $userMenu = $menus->where('sys_types_user_id', Auth::user()->sys_types_user_id);
        $link = '';
        if ( isset(Auth::user()->sys_types_user->dashboard)) {
            $link = Auth::user()->sys_types_user->dashboard;
        }
        else {
            $link = config('template.home_route') ? '/dashboard' : '/';
        }
    }
@endphp
@extends('layouts.guest')
@section('page-content')
    <section class="unauthorized">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <i class="la la-warning font-large-2
                        text-danger"></i>
                            <p>{{__("core::template.not_authorized")}}</p>
                            <div class="">
                                <a class="btn btn-primary" href="{{url()->previous()}}">
                                    <i class="la {{app()->isLocale('ar') ? 'la-arrow-right' : 'la-arrow-left'}}">
                                    </i>&nbsp; {{__('core::template.back')}}
                                </a>
                                <a class="btn btn-primary" href="{{url($link)}}">
                                    <i class="la la-home"></i>
                                    &nbsp; {{__('core::template.back_home')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
