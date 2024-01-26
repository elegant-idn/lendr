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

                                        <h4>{{ trans('labels.forgotpassword') }}</h4>

                                    </div>

                                </div>

                                <div class="col-5 align-self-end">

                                    <img src="{{helper::image_path('login-img.png')}}"

                                        class="img-fluid" alt="">

                                </div>

                            </div>

                        </div>

                        <div class="card-body pt-0">

                            <form class="my-3" method="POST" action="{{ URL::to('/admin/send_password') }}">

                                @csrf

                                <div class="form-group">

                                    <label for="email" class="form-label">{{ trans('labels.email') }} <span class="text-danger"> * </span></label>

                                    <input type="email" class="form-control" name="email" value="" id="email"

                                        placeholder="{{ trans('labels.email') }}" required>

                                    @error('email')

                                        <span class="text-danger">{{ $message }}</span>

                                    @enderror

                                </div>

                                <button class="btn btn-primary w-100 my-3"  @if(env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.submit') }}</button>

                                <p class="fs-7 text-center">{{ trans('labels.remember_password') }}

                                    @if(app('request')->input('redirect') == "admin")

                                    <a href="{{ URL::to('/admin') }}"

                                        class="text-primary fw-semibold">{{ trans('labels.login') }}</a>

                                    @endif

                                    @if(app('request')->input('redirect') == "user")

                                    <a href="{{ URL::to($vendordata->slug.'/login') }}"

                                        class="text-primary fw-semibold">{{ trans('labels.login') }}</a>

                                    @endif

                                </p>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection

