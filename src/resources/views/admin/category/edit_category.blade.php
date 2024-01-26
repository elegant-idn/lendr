@extends('admin.layout.default')
@section('content')
        @include('admin.breadcrumb.breadcrumb')
        <div class="row">
            <div class="col-12">
                <div class="card border-0 box-shadow">
                    <div class="card-body">
                        <form action="{{URL::to('/admin/categories/update-'.$editcategory->slug)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <label class="form-label">{{trans('labels.name')}}<span class="text-danger"> * </span></label>
                                    <input type="text" class="form-control" name="category_name" value="{{$editcategory->name}}" placeholder="{{trans('labels.name')}}" required>
                                    @error('category_name')
                                    <span class="text-danger">{{ $message }}</span> 
                                 @enderror
                                </div>
                                 <div class="form-group">
                                    <label class="form-label">{{trans('labels.image')}} (250 x 250) </label>
                                    <input type="file" class="form-control" name="category_image">
                                     @error('category_image')
                                    <span class="text-danger">{{ $message }}</span> <br>
                                 @enderror
                                    <img src="{{helper::image_path($editcategory->image)}}" class="img-fluid rounded hw-70 mt-1" alt="">
                                </div>
                            </div>
                            <div class="form-group text-end">
                                <a href="{{URL::to('admin/categories')}}" class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>
                                <button @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif class="btn btn-secondary ">{{ trans('labels.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection