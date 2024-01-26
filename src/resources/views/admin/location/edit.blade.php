@extends('admin.layout.default')
@section('content')
@php
if (request()->is('admin/pickup_location*')) {
    $section = 1;
    $locationtitle = trans('labels.pickup_location');
    $locationurl = 'pickup_location';
    $location_url = URL::to('admin/pickup_location/');
} elseif (request()->is('admin/drop_location*')) {
    $section = 2;
    $locationtitle = trans('labels.drop_location');
    $locationurl = 'drop_location';
    $location_url = URL::to('admin/drop_location/');
}
@endphp
       @include('admin.breadcrumb.breadcrumb')
  
        <div class="row">
            <div class="col-12">
                <div class="card border-0 box-shadow">
                    <div class="card-body">
                        <form action="{{URL::to('/admin/'. $locationurl.'/update-' .$editlocation->id.'-'.$section)}}" method="POST">
                            @csrf
                            <div class="row">
                                @if ($section == 1)
                                <div class="form-group col-md-6">
                                    <label class="form-label">{{trans('labels.pickup_location')}}<span class="text-danger"> * </span></label>
                                    <input type="text" class="form-control" name="pickup_location" value="{{$editlocation->pickup_location}}" placeholder="{{trans('labels.pickup_location')}}" required>
                                    @error('pickup_location')
                                    <span class="text-danger">{{ $message }}</span> 
                                 @enderror
                                </div>
                                @endif
                                @if ($section == 2)
                                <div class="form-group col-md-6">
                                    <label class="form-label">{{trans('labels.drop_location')}}<span class="text-danger"> * </span></label>
                                    <input type="text" class="form-control" name="drop_location" value="{{$editlocation->drop_location}}" placeholder="{{trans('labels.drop_location')}}" required>
                                    @error('drop_location')
                                    <span class="text-danger">{{ $message }}</span> 
                                 @enderror
                                </div>
                                @endif
                                
                            </div>
                            <div class="form-group text-end">
                                <a href="{{ URL::to('admin/'. $locationurl) }}"
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