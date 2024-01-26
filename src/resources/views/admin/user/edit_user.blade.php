@extends('admin.layout.default')

@section('content')
    @include('admin.breadcrumb.breadcrumb')

    <div class="row">

        <div class="col-12">

            <div class="card border-0 box-shadow">

                <div class="card-body">

                    <form action="{{ URL::to('/admin/users/edit_vendorprofile') }}" method="post"
                        enctype="multipart/form-data">

                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">

                                <input type="hidden" value="{{ $user->id }}" name="id">

                                <label class="form-label">{{ trans('labels.name') }}<span class="text-danger"> *
                                    </span></label>

                                <input type="text" class="form-control" name="name" value="{{ $user->name }}"
                                    placeholder="name" required>

                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="form-group col-md-6">

                                <label class="form-label">{{ trans('labels.email') }}<span class="text-danger"> *
                                    </span></label>

                                <input type="email" class="form-control" name="email" value="{{ $user->email }}"
                                    placeholder="email" required>

                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">

                                    <label class="form-label">{{ trans('labels.mobile') }}<span class="text-danger"> *
                                        </span></label>

                                    <input type="number" class="form-control" name="mobile" value="{{ $user->mobile }}"
                                        placeholder="mobile" required>

                                    @error('mobile')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                               
                            </div>
                            <div class="col-md-6 form-group">

                                <label class="form-label">{{ trans('labels.image') }} (250 x 250) </label>

                                <input type="file" class="form-control" name="profile">

                                <img class="rounded-circle mt-2" src="{{ helper::image_path($user->image) }}"
                                    alt="" width="70" height="70">

                                @error('profile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="form-group col-md-6">
                                <label for="country" class="form-label">{{ trans('labels.country') }}<span
                                        class="text-danger"> * </span></label>
                                <select name="country" class="form-select" id="country" required>
                                    <option value="">{{ trans('labels.select') }}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ $country->id == $user->country_id ? 'selected' : '' }}>{{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group col-md-6">
                                <label for="city" class="form-label">{{ trans('labels.city') }}<span
                                        class="text-danger"> * </span></label>
                                <select name="city" class="form-select" id="city" required>
                                    <option value="">{{ trans('labels.select') }}</option>
                                </select>

                            </div>

                            <div class="col-sm-6">
                                <div class="form-group" id="plan">
                                    <div class="d-flex">
                                        <input class="form-check-input mx-1" type="checkbox" name="plan_checkbox"
                                            id="plan_checkbox">
                                            @php
                                            $plan = helper::plandetail(@$user->plan_id);
                                        @endphp
                                            <div>
                                                <label for="plan_checkbox"
                                                class="form-label">{{ trans('labels.assign_plan') }}</label>&nbsp;
                                            <label class="form-label">({{ trans('labels.current_plan') }}&nbsp;:&nbsp;
                                            </label>  <span class="fw-500"> {{ !empty($plan) ? $plan->name : '-' }}) </span>
                                            </div>
                                            
                                        
                                        
                                    </div>
                                    <select name="plan" id="selectplan" class="form-select" disabled>
                                        <option value="">{{ trans('labels.select') }}</option>
                                        @foreach ($getplanlist as $plan)
                                            <option value="{{ $plan->id }}">
                                                {{ $plan->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group">
                                    <input class="form-check-input mx-1" type="checkbox" name="allow_store_subscription"
                                        id="allow_store_subscription"
                                        @if ($user->allow_without_subscription == '1') checked @endif><label class="form-check-label"
                                        for="allow_store_subscription">{{ trans('labels.allow_store_without_subscription') }}</label>

                                </div>
                                <div class="form-group">
                                    <input class="form-check-input mx-1" type="checkbox" name="show_landing_page"
                                        id="show_landing_page" @if ($user->available_on_landing == '1') checked @endif><label
                                        class="form-check-label"
                                        for="show_landing_page">{{ trans('labels.display_store_on_landing') }}</label>

                                </div>
                            </div>
                            <div class="form-group text-end">

                                <a href="{{ URL::to('admin/users') }}"
                                    class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>

                                <button
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                    class="btn btn-secondary ">{{ trans('labels.save') }}</button>

                            </div>

                        </div>



                    </form>

                </div>

            </div>

        </div>

    </div>
@endsection
@section('scripts')
    <script>
        var cityurl = "{{ URL::to('admin/getcity') }}";
        var select = "{{ trans('labels.select') }}";
        var cityid = "{{ $user->city_id }}";
    </script>
    <script src="{{ url('storage/app/public/admin-assets/js/user.js') }}"></script>
@endsection
