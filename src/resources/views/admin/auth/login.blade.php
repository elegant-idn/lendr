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
                        <form class="my-3" method="POST" action="{{URL::to('/admin/checklogin')}}">
                            @csrf

                            <div class="form-group">
                                <label for="email" class="form-label">{{trans('labels.email')}}<span class="text-danger"> * </span></label>
                                <input type="email" class="form-control" name="email" placeholder="{{trans('labels.email')}}" id="email" required>
                                @error('email')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label">{{trans('labels.password')}}<span class="text-danger"> * </span></label>
                                <input type="password" class="form-control" name="password" placeholder="{{trans('labels.password')}}" id="password" required>
                                @error('password')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                            </div>
                            <div class="text-end">
                                <a href="{{URL::to('/admin/forgot_password?redirect=admin')}}" class="text-muted fs-8 fw-500">
                                    <i class="fa-solid fa-lock-keyhole mx-2 fs-7"></i>{{trans('labels.forgot_password')}}
                                </a>
                            </div>
                            <button class="btn btn-primary w-100 my-2" type="submit">{{trans('labels.login')}}</button>
                            @if (App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first() != null &&
                                    App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first()->activated == 1)
                            <div class="login-form-bottom-icon d-flex align-items-center justify-content-center text-end mb-3">
                                <a  @if (env('Environment') == 'sendbox') onclick="myFunction()" @else href="{{ URL::to('admin/login/facebook-vendor') }}" @endif>
                                    <button type="button" class="btn btn-primary px-3 icon-btn-facebook mx-1"><i class="fa-brands fa-facebook-f"></i></button>

                                </a>
                                <a  @if (env('Environment') == 'sendbox') onclick="myFunction()" @else href="{{ URL::to('admin/login/google-vendor') }}" @endif>
                                    <button type="button" class="btn btn-primary icon-btn-google"> <i class="fa-brands fa-google"></i></i></button>

                                </a>
                            </div>
                            @endif
                        </form>
                        @if (env('Environment') == 'sendbox')
                        <div class="form-group mt-3 table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Admin<br>admin@gmail.com</td>
                                        <td>123456</td>
                                        <td><button class="btn btn-info btn-sm" onclick="AdminFill('admin@gmail.com' , '123456')">Copy</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Vendor<br>vendor@yopmail.com</td>
                                        <td>123456</td>
                                        <td><button class="btn btn-info btn-sm" onclick="AdminFill('vendor@yopmail.com' , '123456')">Copy</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @endif

                    </div>
                </div>
                {{-- <p class="fs-7 text-center mt-3">{{ trans('labels.dont_have_account') }}
                    <a href="{{URL::to('admin/register')}}" class="text-primary fw-semibold">{{trans('labels.register')}}</a>
                </p> --}}
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
    function AdminFill(email, password) {
        $('#email').val(email);
        $('#password').val(password);
    }
</script>
@endsection