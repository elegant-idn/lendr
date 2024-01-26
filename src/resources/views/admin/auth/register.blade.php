    @extends('admin.layout.auth_default')
    @section('content')
    <div class="wrapper">
        <section>
            <div class="row justify-content-center align-items-center g-0 w-100 h-100vh">
                <div class="col-lg-6 col-sm-8 col-auto px-5">
                    <div class="card box-shadow overflow-hidden border-0">
                        <div class="bg-primary-light">
                            <div class="row">
                                <div class="col-7 d-flex align-items-center">
                                    <div class="text-primary p-4">
                                        <h4 class="mb-1">{{ trans('labels.register') }}</h4>
                                        <p class="fs-7">{{ trans('labels.get_free_account') }}</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{ helper::image_path('login-img.png') }}" class="img-fluid" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <form class="my-3" method="POST" action="{{ URL::to('admin/register_vendor') }}">
                                @csrf
                                <div class="row">
                                    <div class="form-group">
                                        <label for="name" class="form-label">{{ trans('labels.name') }}<span class="text-danger"> * </span></label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="name" placeholder="{{ trans('labels.name') }}" required>
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="form-label">{{ trans('labels.email') }}<span class="text-danger"> * </span></label>
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" id="email" placeholder="{{ trans('labels.email') }}" required>
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="mobile" class="form-label">{{ trans('labels.mobile') }}<span class="text-danger"> * </span></label>
                                        <input type="number" class="form-control" name="mobile" value="{{ old('mobile') }}" id="mobile" placeholder="{{ trans('labels.mobile') }}" required>
                                        @error('mobile')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="password" class="form-label">{{ trans('labels.password') }}<span class="text-danger"> * </span></label>
                                        <input type="password" class="form-control" name="password" value="{{ old('password') }}" id="password" placeholder="{{ trans('labels.password') }}" required>
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="country" class="form-label">{{ trans('labels.country') }}<span class="text-danger"> * </span></label>
                                        <select name="country" class="form-select" id="country" required>
                                            <option value="">{{trans('labels.select')}}</option>
                                            @foreach ($countries as $country)
                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="form-group col-6">
                                        <label for="city" class="form-label">{{ trans('labels.city') }}<span class="text-danger"> * </span></label>
                                        <select name="city" class="form-select" id="city" required>
                                            <option value="">{{trans('labels.select')}}</option>
                                        </select>

                                    </div>
                                   
                                    <div class="form-group">
                                        <label for="basic-url" class="form-label">{{ trans('labels.personlized_link') }}<span class="text-danger"> * </span></label>@if (env('Environment') == 'sendbox')<span class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>@endif
                                        <div class="input-group">
                                            <span class="input-group-text">{{ URL::to('/')}}/</span>
                                            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug')}}" required>
                                        </div>
                                        @error('slug')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                
                                    <div class="form-group d-none">
                                        <input class="form-check-input" type="checkbox" value="" name="check_terms" id="check_terms" checked required>
                                        <label class="form-check-label" for="check_terms">
                                            {{trans('labels.i_accept_the')}} <span class="fw-600"><a href="{{URL::to('/termscondition')}}" target="_blank">{{trans('labels.terms_condition')}}</a> </span>
                                        </label>
                                    </div>
                                </div>

                                <button class="btn btn-primary w-100 mb-3" @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.register') }}</button>
                                <p class="fs-7 text-center mb-3">{{ trans('labels.already_have_an_account') }}
                                    <a href="{{ URL::to('/admin') }}" class="text-primary fw-semibold">{{ trans('labels.login') }}</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @endsection
    @section('scripts')
    <script>
        var cityurl = "{{URL::to('admin/getcity')}}";
        var select = "{{trans('labels.select')}}";
        var cityid = '0';
    </script>
    <script src="{{ url(env('ASSETPATHURL') . '/admin-assets/js/user.js') }}"></script>
    @endsection