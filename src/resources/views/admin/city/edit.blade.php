@extends('admin.layout.default')

@section('content')
@include('admin.breadcrumb.breadcrumb')
<!-- 
<div class="d-flex justify-content-between align-items-center">

    <h5 class="text-uppercase">{{trans('labels.edit')}}</h5>

    <nav aria-label="breadcrumb">

        <ol class="breadcrumb m-0">

            <li class="breadcrumb-item"><a href="{{URL::to('admin/cities')}}">{{trans('labels.cities')}}</a></li>

            <li class="breadcrumb-item active" aria-current="page">{{trans('labels.edit')}}</li>

        </ol>

    </nav>

</div> -->

<div class="row mt-3">

    <div class="col-12">

        <div class="card border-0 box-shadow">

            <div class="card-body">

                <form action="{{URL::to('admin/cities/update-'.$editcity->id)}}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="row">

                        <div class="form-group col-md-6">

                            <label class="form-label">{{trans('labels.country')}}<span class="text-danger"> * </span></label>
                            <select name="country" class="form-select">
                                <option value="">{{trans('labels.select')}}</option>
                                @foreach($allcountry as $country)
                                <option value="{{$country->id}}" {{$country->id == $editcity->country_id ? 'selected' : ''}}>{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">

                            <label class="form-label">{{trans('labels.city')}}<span class="text-danger"> * </span></label>

                            <input type="text" class="form-control" name="name" value="{{$editcity->city}}" placeholder="{{trans('labels.city')}}" required>

                            @error('name')

                            <span class="text-danger">{{ $message }}</span>

                            @enderror

                        </div>


                        <div class="form-group text-end">

                            <a href="{{ URL::to('admin/cities') }}" class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>

                            <button class="btn btn-secondary" @if(env('Environment')=='sendbox' ) type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>



@endsection