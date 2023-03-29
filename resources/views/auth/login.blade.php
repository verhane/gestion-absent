@extends('layouts.admin')
@section('page-content')
    <section class="row flexbox-container align-items-center justify-content-center">
        <div class="col-md-8 coly-10 box-shadow-2 p-0">
            <div class="card border-grey border-lighten-3 m-0">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-6 d-none d-lg-block" style="border-right: 1px #dcdada solid">
                        <img width="100%" src="{{config('dcs.template.app_logo')}}" style="max-height: 300px" alt="">
                    </div>
                    <div class="col">
                        <div class="card-header border-0">
                            <h4 class="card-subtitle line-on-side text-muted text-center pt-2">
                                <span>{{__('auth.login')}}</span>
                            </h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="flash-message">
                                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                        @if(Session::has('alert-' . $msg))
                                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                                                <a href="#" class="close"
                                                   data-dismiss="alert"
                                                   aria-label="close">&times;</a>
                                            </p>
                                        @endif
                                    @endforeach
                                </div>

                                <form class="form-horizontal form-simple"
                                      action="{{url('admin/login')}}" novalidate method="post">
                                    @csrf
                                    <fieldset class="form-group position-relative has-icon-left mb-0">
                                        <input type="email"
                                               name="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               id="user-name"
                                               placeholder="{{__('auth.email')}}" required>
                                        <div class="form-control-position">
                                            <i class="la la-user"></i>
                                        </div>
                                    </fieldset>
                                    @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                    <fieldset class="form-group position-relative has-icon-left my-2">
                                        <input type="password"
                                               name="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               id="user-password"
                                               placeholder="{{__('auth.password')}}" required>
                                        <div class="form-control-position">
                                            <i class="la la-key"></i>
                                        </div>
                                    </fieldset>
                                    @error('password')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                    <div class="form-group row">
                                        <div class="col-sm-6 col-12 text-center text-sm-left">
                                            <fieldset>
                                                <input type="checkbox" id="remember-me" class="chk-remember">
                                                <label for="remember-me">{{__('auth.remember_me')}}</label>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <input value="1" type="hidden" name="type">
                                    <button type="submit" class="btn btn-info btn-block"><i
                                            class="ft-unlock"></i> {{__('auth.login')}}
                                    </button>
                                </form>
                            </div>
                            @if(config('dcs.admin.register'))
                                <p class="text-center">{{__('auth.dont_have_account')}}
                                    <a href="{{url('register')}}" class="card-link">{{__('auth.register')}}</a>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
