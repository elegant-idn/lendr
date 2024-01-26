@extends('admin.layout.default')

@section('content')

    @include('admin.breadcrumb.breadcrumb')

    <div class="row">

        <div class="col-12">

            <div class="card border-0 box-shadow">

                <div class="card-body">

                    <form action="{{ URL::to('/admin/register_vendor') }}" method="POST">

                        @csrf
                        <div class="row">
                            <div class="form-group col-6">

                                <label for="name" class="form-label">{{ trans('labels.name') }}<span class="text-danger"> *
    
                                    </span></label>
    
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"
    
                                   placeholder="{{ trans('labels.name') }}" required>
    
                                @error('name')
    
                                    <span class="text-danger">{{ $message }}</span>
    
                                @enderror
    
                            </div>
    
                            <div class="form-group col-6">
    
                                <label for="email" class="form-label">{{ trans('labels.email') }}<span class="text-danger"> *
    
                                    </span></label>
    
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
    
                                     placeholder="{{ trans('labels.email') }}" required>
    
                                @error('email')
    
                                    <span class="text-danger">{{ $message }}</span>
    
                                @enderror
    
                            </div>
    
                            <div class="form-group col-6">
    
                                <label for="mobile" class="form-label">{{ trans('labels.mobile') }}<span class="text-danger">
    
                                        * </span></label>
    
                                <input type="number" class="form-control" name="mobile" value="{{ old('mobile') }}"  placeholder="{{ trans('labels.mobile') }}" required>
    
                                @error('mobile')
    
                                    <span class="text-danger">{{ $message }}</span>
    
                                @enderror
    
                            </div>
    
                            <div class="form-group col-6">
    
                                <label for="password" class="form-label">{{ trans('labels.password') }}<span
    
                                        class="text-danger"> * </span></label>
    
                                <input type="password" class="form-control" name="password" value="{{ old('password') }}"
    
                                   placeholder="{{ trans('labels.password') }}" required>
    
                                @error('password')
    
                                    <span class="text-danger">{{ $message }}</span>
    
                                @enderror
    
                            </div>
                            <div class="form-group col-6">
                                <label for="country" class="form-label">{{ trans('labels.country') }}<span
                                        class="text-danger"> * </span></label>
                                <select name="country" class="form-select" id="country" required>
                                    <option value="">{{trans('labels.select')}}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                            <div class="form-group col-6">
                                <label for="city" class="form-label">{{ trans('labels.city') }}<span
                                        class="text-danger"> * </span></label>
                                <select name="city" class="form-select" id="city" required>
                                    <option value="">{{trans('labels.select')}}</option>
                                </select>
                              
                            </div>
                        </div>
                      
                        <div class="form-group text-end">

                            <a href="{{URL::to('admin/users')}}" class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>

                            <button @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif class="btn btn-secondary ">{{ trans('labels.save') }}</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

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

