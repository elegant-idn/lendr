@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')
    @include('admin.booking.statistics')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body">
                    @include('admin.booking.tablecommonview')
                </div>
            </div>
        </div>
    </div>
    
@endsection
@section('scripts')
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/booking.js') }}"></script>
@endsection
