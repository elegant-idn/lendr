@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body">
                    <div id="privacy-policy-three" class="privacy-policy">
                        <form action="{{ URL::to('admin/aboutus/update') }}" method="post">
                            @csrf
                            <textarea class="form-control" id="aboutus" name="aboutus" rows="10">{{ @$getaboutus }}</textarea>
                            @error('aboutus')
                                <span class="text-danger">{{ $message }}</span><br>
                            @enderror
                            <div class="form-group text-end my-2">
                                <button
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                    class="btn btn-secondary ">{{ trans('labels.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
