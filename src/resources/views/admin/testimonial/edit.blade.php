@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('/admin/testimonials/update-' . $edittestimonial->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.name') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ $edittestimonial->name }}" placeholder="{{ trans('labels.name') }}" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.position') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control" name="position"
                                    value="{{ $edittestimonial->position }}" placeholder="{{ trans('labels.position') }}"
                                    required>
                                @error('position')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.ratting') }}<span class="text-danger"> *
                                    </span></label>
                                <select name="rating" class="form-select">
                                    <option value="1" {{ $edittestimonial->star == 1 ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ $edittestimonial->star == 2 ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ $edittestimonial->star == 3 ? 'selected' : '' }}>3</option>
                                    <option value="4" {{ $edittestimonial->star == 4 ? 'selected' : '' }}>4</option>
                                    <option value="5" {{ $edittestimonial->star == 5 ? 'selected' : '' }}>5</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.image') }} (250 x 250)<span class="text-danger">
                                        * </span></label>
                                <input type="file" class="form-control" name="image"
                                    placeholder="{{ trans('labels.image') }}">

                                @error('image')
                                    <span class="text-danger">{{ $message }} <br></span>
                                @enderror
                                <img src="{{ helper::image_path($edittestimonial->image) }}"
                                    class="img-fluid rounded hw-50 mt-1" alt="">
                            </div>
                            <div class="form-group">
                                <label class="form-label">{{ trans('labels.description') }}<span class="text-danger"> *
                                    </span></label>
                                <textarea class="form-control" name="description" placeholder="{{ trans('labels.description') }}" rows="5"
                                    required>{{ $edittestimonial->description }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group text-end">
                            <a href="{{ URL::to('admin/testimonials') }}"
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
