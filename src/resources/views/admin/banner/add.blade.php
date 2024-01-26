@php

    if (request()->is('admin/bannersection-1*')) {

        $section = 1;

        $title = trans('labels.section-1');

        $url = 'bannersection-1';

        $table_url = URL::to('admin/bannersection-1/');

    } elseif (request()->is('admin/bannersection-2*')) {

        $section = 2;

        $title = trans('labels.section-2');

        $url = 'bannersection-2';

        $table_url = URL::to('admin/bannersection-2/');

    } else {

        $section = 3;

        $title = trans('labels.section-3');

        $url = 'bannersection-3';

        $table_url = URL::to('admin/bannersection-3/');

    }

@endphp

@extends('admin.layout.default')

@section('content')

    @include('admin.breadcrumb.breadcrumb')

    <div class="row">

        <div class="col-12">

            <div class="card border-0 box-shadow">

                <div class="card-body">

                    <form action="{{ URL::to('admin/bannersection-1/save-' . $section) }} " method="POST"

                        enctype="multipart/form-data">

                        @csrf

                        <div class="row">

                            <div class="col-sm-6 form-group">

                                <label class="form-label">{{ trans('labels.type') }}<span

                                    class="text-danger"> * </span></label>

                                <select class="form-select type" name="type" required>

                                    <option value="">{{ trans('labels.select') }} </option>

                                    <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>

                                        {{ trans('labels.category') }}</option>

                                    <option value="2" {{ old('type') == '2' ? 'selected' : '' }}>

                                        {{ trans('labels.product') }}</option>

                                </select>

                                @error('type')

                                    <span class="text-danger">{{ $message }}</span>

                                @enderror

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm-6 form-group 1 selecttype">

                                <label class="form-label">{{ trans('labels.category') }}<span

                                        class="text-danger"> *</span></label>

                                <select class="form-select" name="category" id="category" required>

                                    <option value="" selected>{{ trans('labels.select') }} </option>

                                    @foreach ($category as $item)

                                        <option value="{{ $item->id }}"

                                            {{ old('category') == $item->id ? 'selected' : '' }}>

                                            {{ $item->name }} </option>

                                    @endforeach

                                </select>

                                @error('category')

                                    <span class="text-danger">{{ $message }}</span>

                                @enderror

                            </div>

                            <div class="col-sm-6 form-group 2 selecttype">

                                <label class="form-label">{{ trans('labels.product') }}<span class="text-danger"> *

                                    </span></label>

                                <select class="form-select" name="service" id="service" required>

                                    <option value="" selected>{{ trans('labels.select') }} </option>

                                    @foreach ($product as $item)

                                        <option value="{{ $item->id }}"

                                            {{ old('service') == $item->id ? 'selected' : '' }}> {{ $item->title }}

                                        </option>

                                    @endforeach

                                </select>

                                @error('service')

                                    <span class="text-danger">{{ $message }}</span>

                                @enderror

                            </div>

                        </div>

                        <div class="row">
                            @if ($section == 1)
                            <div class="col-sm-6 form-group">

                                <label class="form-label">{{ trans('labels.title') }} <span class="text-danger"> * </span></label>

                                <input type="text" class="form-control" name="title" placeholder="{{ trans('labels.title') }}" required>

                                @error('title')

                                    <span class="text-danger">{{ $message }}</span>

                                @enderror

                            </div>
                            <div class="col-sm-6 form-group">

                                <label class="form-label">{{ trans('labels.subtitle') }} <span class="text-danger"> * </span></label>

                                <input type="text" class="form-control" name="subtitle" placeholder="{{ trans('labels.subtitle') }}" required>

                                @error('subtitle')

                                    <span class="text-danger">{{ $message }}</span>

                                @enderror

                            </div>
                            <div class="col-sm-6 form-group">

                                <label class="form-label">{{ trans('labels.link_text') }} <span class="text-danger"> * </span></label>

                                <input type="text" class="form-control" name="link_text" placeholder="{{ trans('labels.link_text') }}" required>

                                @error('link_text')

                                    <span class="text-danger">{{ $message }}</span>

                                @enderror

                            </div>
                            @endif
                           
                            <div class="col-sm-6 form-group">

                                <label class="form-label">{{ trans('labels.image') }} (250 x 250) <span class="text-danger"> * </span></label>

                                <input type="file" class="form-control" name="image" required>

                                @error('image')

                                    <span class="text-danger">{{ $message }}</span>

                                @enderror

                            </div>

                        </div>

                        <div class="form-group text-end">

                            <a href="{{ URL::to('admin/'. $url) }}"

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

@endsection

@section('scripts')

    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/banner.js') }}"></script>

@endsection

