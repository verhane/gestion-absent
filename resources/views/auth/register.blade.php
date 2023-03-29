@extends('layouts.admin')
@section('page-content')
    <section class="row align-items-center justify-content-center flexbox-container">
        <div class="col-md-8 col-10 box-shadow-2 p-0">
            <div class="card border-grey border-lighten-3 m-0">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-6 d-none d-lg-block" style="border-right: 1px #dcdada solid">
                        <img width="100%" src="{{config('dcs.template.app_logo')}}" style="max-height: 300px" alt="">
                    </div>
                    <div class="col">
                        <div class="card-header border-0">

                            <h2 class="card-subtitle line-on-side text-muted text-center pt-2">
                                <span>{{__('auth.register')}}</span>
                            </h2>
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

                                <form class="form-horizontal form-simple" action="{{ route('newUser') }}" method="post">
                                    @csrf
                                    <input value="1" type="hidden" name="type">

                                    <fieldset class="form-group position-relative has-icon-left mb-1">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               name="name"
                                               id="name" placeholder="{{__('auth.name')}}">
                                        <div class="form-control-position">
                                            <i class="la la-user"></i>
                                        </div>
                                        @error('name')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </fieldset>
                                    <fieldset class="form-group position-relative has-icon-left mb-1">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               name="email"
                                               id="user-email" placeholder="{{__('auth.email')}}" required>
                                        <div class="form-control-position">
                                            <i class="la la-envelope"></i>
                                        </div>
                                        @error('email')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </fieldset>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password"
                                               id="user-password" placeholder="{{__('auth.password')}}" required>
                                        <div class="form-control-position">
                                            <i class="la la-key"></i>
                                        </div>
                                        @error('password')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </fieldset>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input type="password" class="form-control "
                                               name="password_confirmation"
                                               id="password_confirmation"
                                               placeholder="{{__('auth.password_confirmation')}}"
                                               required>
                                        <div class="form-control-position">
                                            <i class="la la-key"></i>
                                        </div>

                                    </fieldset>
                                    @if(isset($typeUsers))
                                        <div id="typeUser" @if($typeUsers->count() ==1) style="display: none" @endif>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <select name="type_user"
                                                        class="form-control @error('type_user') is-invalid @enderror">
                                                    <option value="">{{__('sélectionner')}}</option>
                                                    @foreach($typeUsers as $typeUser)
                                                        <option value="{{ $typeUser->id }}"
                                                                @if($typeUsers->count() ==1) selected="selected" @endif>{{ $typeUser->libelle }}</option>
                                                    @endforeach()
                                                </select>
                                                @error('type_user')
                                                <p class="invalid-feedback">{{$message}}</p>
                                                @enderror
                                            </fieldset>
                                        </div>
                                    @endif
                                    <button type="submit" class="btn btn-info btn-block">
                                        <i class="ft-unlock"></i> {{__('auth.register')}}
                                    </button>
                                </form>
                            </div>
                            <p class="text-center">{{__('auth.already_have_account')}}
                                <a href="{{url('login')}}" class="card-link">{{__('auth.login')}}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
