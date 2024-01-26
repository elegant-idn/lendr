@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('/admin/products/save') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.category') }}<span class="text-danger"> *
                                    </span></label>
                                <select class="form-select" name="category_name" required>
                                    <option value="">{{ trans('labels.select') }} </option>
                                    @foreach ($category as $category_name)
                                        <option value="{{ $category_name->id }}"
                                            {{ old('category_name') == $category_name->id ? 'selected' : '' }}>
                                            {{ $category_name->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.title') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}"
                                    placeholder="{{ trans('labels.title') }}" required>
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-lg-0">
                                <div class="form-group">

                                    <label class="form-label">{{ trans('labels.minimum_booking_limit') }}<span class="text-danger"> *</span></label>
                                    <div class="input-group">
                                        <input type="text"
                                            class="form-control {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"
                                            name="minimum_booking_limit" placeholder="{{ trans('labels.minimum_booking_limit') }}"
                                            aria-describedby="button-addon2" value=""
                                            required>
                                        <select name="interval_type" class="border border-muted" id="">
                                            <option value="1">{{ trans('labels.hour') }}</option>
                                        </select>
                                    </div>
                                    @error('minimum_booking_limit')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.tax') }}(%)<span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control numbers_decimal" name="tax"
                                    value="{{ old('tax') }}" placeholder="{{ trans('labels.tax') }}" required>
                                @error('tax')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.per_hour_price') }}</label>
                                <input type="text" class="form-control numbers_decimal" name="per_hour_price"
                                    value="{{ old('per_hour_price') }}" placeholder="{{ trans('labels.per_hour_price') }}">
                                @error('per_hour_price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.per_day_price') }}</label>
                                <input type="text" class="form-control numbers_decimal" name="per_day_price"
                                    value="{{ old('per_day_price') }}" placeholder="{{ trans('labels.per_day_price') }}">
                                @error('per_day_price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row justify-content-between">
                                        <label class="col-auto col-form-label"
                                            for="">{{ trans('labels.features') }} <span
                                                class="" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Ex. <i class='fa-solid fa-truck-fast'></i> Visit https://fontawesome.com/ for more info">
                                                <i class="fa-solid fa-circle-info"></i> </span></label>
                                       
                                    </div>
                                        <div class="row">
                                            {{-- <div class="col-md-3 form-group">
                                                <div class="input-group">
                                                    <input type="text"
                                                        class="form-control feature_required"
                                                        onkeyup="show_feature_icon(this)"
                                                        name="feature_icon[]"
                                                        placeholder="{{ trans('labels.icon') }}">
                                                    <p class="input-group-text"></p>
                                                </div>
                                            </div> --}}
                                            <div class="col-md-3 form-group">
                                                <input type="file"
                                                    class="form-control feature_required"
                                                    name="feature_image[]"
                                                    placeholder="{{ trans('labels.image') }}" required>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <input type="text"
                                                    class="form-control feature_required"
                                                    name="feature_title[]"
                                                    placeholder="{{ trans('labels.title') }}" required>
                                            </div>
                                            <div class="col-md-5 form-group">
                                                <input type="text"
                                                    class="form-control"
                                                    name="feature_description[]"
                                                    placeholder="{{ trans('labels.subtitle') }}"
                                                    >
                                            </div>
                                            <div class="col-md-1 form-group">
                                                <button class="btn btn-primary" type="button"
                                                    onclick="add_features('{{ trans('labels.image') }}','{{ trans('labels.title') }}','{{ trans('labels.subtitle') }}')">
                                                    <i class="fa-sharp fa-solid fa-plus"></i> </button>
                                            </div>
                                        </div>

                                    <span class="extra_footer_features"></span>
                                </div>
                            </div>
                            <div class="col-sm-12 form-group">
                                <label class="form-label">{{ trans('labels.image') }} (450 x 300) <span
                                        class="text-danger">
                                        * </span></label>
                                <input type="file" class="form-control" name="service_image[]" multiple="" required>
                                @error('service_image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.description') }}<span class="text-danger"> *
                                    </span></label>
                                <textarea name="description" class="form-control" rows="5" placeholder="{{ trans('labels.description') }}"
                                    required>{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.additional_info') }}<span class="text-danger"> *
                                    </span></label>
                                <textarea name="additional_info" class="form-control" rows="5" placeholder="{{ trans('labels.additional_info') }}"
                                    required>{{ old('additional_info') }}</textarea>
                                @error('additional_info')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group text-end">
                            <a href="{{ URL::to('admin/products') }}"
                                class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>
                            <button
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                class="btn btn-secondary ">{{ trans('labels.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{{ url(env('ASSETPATHURL') . '/admin-assets/js/product.js') }}"></script>
@endsection