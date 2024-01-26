@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('/admin/products/update-' . $product->slug) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.category') }}<span class="text-danger"> *
                                    </span></label>
                                <select class="form-select" name="category_name" required>
                                    @foreach ($category as $category_name)
                                        <option value="{{ $category_name->id }}"
                                            {{ $product->category_id == $category_name->id ? 'selected' : '' }}>
                                            {{ $category_name->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.title') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control" name="title" value="{{ $product->title }}"
                                    placeholder="{{ trans('labels.name') }}" required>
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-lg-0">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.minimum_booking_limit') }}<span
                                            class="text-danger"> *</span></label>
                                    <div class="input-group">
                                        <input type="text"
                                            class="form-control {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"
                                            name="minimum_booking_limit"
                                            placeholder="{{ trans('labels.minimum_booking_limit') }}"
                                            aria-describedby="button-addon2" value="{{ $product->minimum_booking_hour }}"
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
                                <label class="form-label">{{ trans('labels.tax') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="number" class="form-control" name="tax" value="{{ $product->tax }}"
                                    placeholder="{{ trans('labels.tax') }}" required>
                                @error('tax')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.per_hour_price') }}</label>
                                <input type="text" class="form-control numbers_decimal" name="per_hour_price"
                                    value="{{ $product->per_hour_price }}"
                                    placeholder="{{ trans('labels.per_hour_price') }}">
                                @error('per_hour_price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.per_day_price') }}</label>
                                <input type="text" class="form-control numbers_decimal" name="per_day_price"
                                    value="{{ $product->per_day_price }}"
                                    placeholder="{{ trans('labels.per_day_price') }}">
                                @error('per_day_price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row justify-content-between">
                                    <label class="col-auto col-form-label" for="">{{ trans('labels.features') }}
                                        <span class="" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Ex. <i class='fa-solid fa-truck-fast'></i> Visit https://fontawesome.com/ for more info">
                                            <i class="fa-solid fa-circle-info"></i> </span></label>
                                  
                                        <span class="col-auto"><button class="btn btn-primary btn-sm" type="button"
                                                onclick="add_features('{{ trans('labels.image') }}','{{ trans('labels.title') }}','{{ trans('labels.subtitle') }}')">
                                                {{ trans('labels.add_new') }}
                                                {{ trans('labels.features') }} <i
                                                    class="fa-sharp fa-solid fa-plus"></i></button></span>
                                   
                                </div>
                                @if ($product['fetures_info']->count() > 0)
                                    @forelse ($product['fetures_info'] as $key => $features)
                                        <div class="row">
                                            <input type="hidden" name="edit_icon_key[]" value="{{ $features->id }}">
                                            <div class="col-md-3 form-group">
                                                <input type="file" class="form-control"
                                                name="edi_feature_image[{{ $features->id }}]"
                                                placeholder="{{ trans('labels.image') }}">
                                                <img src="{{helper::image_path($features->image)}}" class="img-fluid hw-50 mt-1" alt="">
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <input type="text" class="form-control"
                                                    name="edi_feature_title[{{ $features->id }}]"
                                                    placeholder="{{ trans('labels.title') }}"
                                                    value="{{ $features->title }}" required>
                                            </div>
                                            <div class="col-md-5 form-group">
                                                <input type="text" class="form-control"
                                                    name="edi_feature_description[{{ $features->id }}]"
                                                    placeholder="{{ trans('labels.subtitle') }}"
                                                    value="{{ $features->sub_title }}">
                                            </div>
                                            <div class="col-md-1 form-group">
                                                <button class="btn btn-danger" type="button"
                                                    onclick="statusupdate('{{ URL::to('admin/products/deletefeature-' . $features->id) }}')">
                                                    <i class="fa fa-trash"></i> </button>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control feature_required"
                                                        onkeyup="show_feature_icon(this)" name="feature_icon[]"
                                                        placeholder="{{ trans('labels.icon') }}" >
                                                    <p class="input-group-text"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <input type="text" class="form-control feature_required"
                                                    name="feature_title[]" placeholder="{{ trans('labels.title') }}"
                                                    required>
                                            </div>
                                            <div class="col-md-5 form-group">
                                                <input type="text" class="form-control" name="feature_description[]"
                                                    placeholder="{{ trans('labels.subtitle') }}" required>
                                            </div>
                                            <div class="col-md-1 form-group">
                                                <button class="btn btn-info" type="button"
                                                    onclick="add_features('{{ trans('labels.icon') }}','{{ trans('labels.title') }}','{{ trans('labels.description') }}')">
                                                    <i class="fa-sharp fa-solid fa-plus"></i> </button>
                                            </div>
                                        </div>
                                    @endforelse
                             @endif
                                <span class="extra_footer_features"></span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-sm-6">
                                <label class="form-label">{{ trans('labels.description') }}<span class="text-danger"> *
                                    </span></label>
                                <textarea name="description" class="form-control" rows="5" placeholder="{{ trans('labels.description') }}"
                                    required>{{ $product->description }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.additional_info') }}<span class="text-danger"> *
                                    </span></label>
                                <textarea name="additional_info" class="form-control" rows="5" placeholder="{{ trans('labels.additional_info') }}"
                                    required>{{ $product->additional_details }}</textarea>
                                @error('additional_info')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group d-flex justify-content-between">
                            <a href="javascript:void(0)" onclick="addimage('{{ $product->id }}')"
                                class="btn btn-secondary">
                                <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add_new') }}
                            </a>
                            <div>
                                <a href="{{ URL::to('admin/products') }}"
                                    class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>
                                <button
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                    class="btn btn-secondary ">{{ trans('labels.save') }}</button>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-2">
                        @foreach ($product['multi_image'] as $image)
                            <div class="col-2 card mx-2 p-2 border-0">
                                <img src="{{ helper::image_path($image->image) }}"
                                    class="img-fluid service-image rounded-3">
                                <div class="text-center mt-2">
                                    <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm"
                                        onclick="imageview('{{ $image->id }}','{{ $image->image }}')"><i
                                            class="fa-regular fa-pen-to-square"></i></a>
                                    <a href="javascript:void(0)"
                                        onclick="statusupdate('{{ URL::to('/admin/products/delete_image-' . $image->id .'/'. $image->product_id) }}')"
                                        class="btn btn-outline-danger btn-sm @if ($product['multi_image']->count() == 1) d-none @else '' @endif"><i
                                            class="fa-regular fa-trash"></i></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{-- add Modal --}}
                    <div class="modal modal-fade-transform" id="addModal" tabindex="-1"
                        aria-labelledby="addModallable" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addModallable">{{ trans('labels.image') }} (450 x 300)
                                        <span class="text-danger"> * </span>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action=" {{ URL::to('/admin/products/add_image') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" id="product_id" name="product_id">
                                        <input type="file" name="image" class="form-control" id="">
                                        @error('image')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="modal-footer">
                                        <button
                                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                            class="btn btn-secondary">{{ trans('labels.save') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- edit Modal --}}
                    <div class="modal modal-fade-transform" id="editModal" tabindex="-1"
                        aria-labelledby="editModallable" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModallable">{{ trans('labels.image') }} (450x300)
                                        <span class="text-danger"> * </span>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action=" {{ URL::to('/admin/products/update') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" id="img_id" name="id">
                                        <input type="hidden" id="img_name" name="image">
                                        <input type="file" name="product_image" class="form-control" id="" required>
                                        @error('product_image')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="modal-footer">
                                        <button
                                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                            class="btn btn-secondary">{{ trans('labels.save') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/product.js') }}"></script>
@endsection
