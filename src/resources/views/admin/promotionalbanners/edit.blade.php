@extends('admin.layout.default')

@section('content')
@include('admin.breadcrumb.breadcrumb')


<div class="row mt-3">

    <div class="col-12">

        <div class="card border-0 box-shadow">

            <div class="card-body">

                <form action="{{ URL::to('/admin/promotionalbanners/update-'.$banner->id) }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-label">{{ trans('labels.vendors') }}<span class="text-danger"> *
                                </span></label>
                            <select class="form-select" name="vendor" id="" required>
                                <option value="">{{trans('labels.select')}}</option>
                                @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id}}" {{$vendor->id == $banner->vendor_id ? 'selected' : ''}}>{{ $vendor->name}}</option>
                                @endforeach
                            </select>
                            @error('vendor')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label class="form-label">{{ trans('labels.image') }}<span class="text-danger"> *
                                </span>(1920 x 450)</label>
                            <input type="file" name="image" class="form-control">
                            <img src="{{helper::image_path($banner->image)}}" class="hw-50 mt-1" alt="">
                            @error('image')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group text-end">

                        <a href="{{ URL::to('admin/promotionalbanners') }}" class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>

                        <button @if (env('Environment')=='sendbox' ) type="button" onclick="myFunction()" @else type="submit" @endif class="btn btn-secondary ">{{ trans('labels.save') }}</button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection