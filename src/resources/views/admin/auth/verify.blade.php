@extends('admin.layout.auth_default')
@section('content')
<div class="wrapper">
    <section>
        <div class="row justify-content-center align-items-center g-0 w-100 h-100vh">
            <div class="col-xl-4 col-lg-6 col-sm-8 col-auto px-5">
                <div class="card box-shadow overflow-hidden border-0">
                    <div class="bg-primary-light">
                        <div class="row">
                            <div class="col-7 d-flex align-items-center">
                                <div class="text-primary p-4">
                                    <h4>{{trans('labels.welcome_back')}}</h4>
                                    <p>{{trans('labels.sign_in_continue')}}</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                {{-- <img src="{{helper::image_path('login-img.png')}}" class="img-fluid" alt=""> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <form class="my-3" method="POST" action="{{ URL::to('admin/systemverification') }}">
                            @csrf
                            <div class="form-group">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username')}}" required autocomplete="username" autofocus placeholder="Envato Username">
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> 
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email')}}" required autocomplete="email" autofocus placeholder="Email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="purchase_key" type="text" class="form-control @error('purchase_key') is-invalid @enderror" name="purchase_key" required autocomplete="current-purchase_key" placeholder="Purchase Key">
                                @error('purchase_key')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <?php
                            $text = str_replace('verification', '', url()->current());
                            ?>
                            <div class="form-group">
                                <input id="domain" type="hidden" class="form-control @error('domain') is-invalid @enderror" name="domain" required autocomplete="current-domain" value="{{$text}}" placeholder="domain" readonly="">
                            </div>
                            <button class="btn btn-primary w-100 my-3"
                                type="submit">{{ trans('labels.submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection