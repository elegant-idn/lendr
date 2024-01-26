@extends('admin.layout.default')
@section('content')
        @include('admin.breadcrumb.breadcrumb')
        <div class="row">
            <div class="col-12">
                <div class="card border-0 box-shadow">
                    <div class="card-body">
                        <form action="{{URL::to('/admin/categories/save')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <label class="form-label">{{trans('labels.name')}}<span class="text-danger"> * </span></label>
                                    <input type="text" class="form-control" name="category_name" value="{{old('category_name')}}" placeholder="{{trans('labels.name')}}" required>
                                    @error('category_name')
                                    <span class="text-danger">{{ $message }}</span> 
                                 @enderror
                                </div>
                                 <div class="form-group">
                                    <label class="form-label">{{trans('labels.image')}} (250 x 250) <span class="text-danger"> * </span></label>
                                    <input type="file" class="form-control" name="category_image" required>
                                    @error('category_image')
                                    <span class="text-danger">{{ $message }}</span> 
                                 @enderror
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