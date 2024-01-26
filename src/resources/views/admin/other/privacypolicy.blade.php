@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body">
                    <div id="privacy-policy-three" class="privacy-policy">
                        <form action="{{ URL::to('admin/privacypolicy/update') }}" method="post">
                            @csrf
                            <textarea class="form-control" id="privacy-policy" name="privacypolicy" rows="10">{{ @$getprivacypolicy }}</textarea>
                            @error('privacypolicy')
                                <span class="text-danger">{{ $message }}</span><br>
                            @enderror
                            <div class="form-group text-end my-2">
                                <button type="submit" class="btn btn-secondary ">{{ trans('labels.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection