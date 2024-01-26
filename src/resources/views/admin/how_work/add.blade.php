@extends('admin.layout.default')
@section('content')
       @include('admin.breadcrumb.breadcrumb')
        <div class="row">
            <div class="col-12">
                <div class="card border-0 box-shadow">
                    <div class="card-body">
                        <form action="{{URL::to('/admin/how_works/save')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">{{trans('labels.title')}}<span class="text-danger"> * </span></label>
                                    <input type="text" class="form-control" name="title" value="{{old('title')}}" placeholder="{{trans('labels.title')}}" required>
                                    @error('title')
                                    <span class="text-danger">{{ $message }}</span> 
                                 @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">{{trans('labels.subtitle')}}<span class="text-danger"> * </span></label>
                                    <input type="text" class="form-control" name="subtitle" value="{{old('subtitle')}}" placeholder="{{trans('labels.subtitle')}}" required>
                                    @error('subtitle')
                                    <span class="text-danger">{{ $message }}</span> 
                                 @enderror
                                </div>
                            
                               
                            </div>
                            <div class="form-group text-end">
                                <a href="{{ URL::to('admin/how_works') }}"
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