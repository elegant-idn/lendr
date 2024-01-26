@extends('admin.layout.default')
@section('content')
<div class="row page-titles mx-0 mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item active"><a href="javascript:void(0)"> {{ trans('labels.addons_manager') }} </a></li>
        </ol>
        <a href="{{ URL::to('/admin/createsystem-addons') }}" class="btn btn-primary"> {{ trans('labels.install_update_addons') }} </a>
    </div>
</div>
<div class="container-fluid">
    <div class="card mb-3 border-0 shadow">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-1 fw-bold">Buy More Premium Addons</h5>
                    <p class="text-muted fw-medium">Connect your favorite tools.</p>
                </div>
                <a href="https://rb.gy/698xu" target="_blank" class="btn btn-primary">Buy More Premium Addons</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-body">
                    <h5 class="card-title mb-1 fw-bold">Installed Addons</h5>
                    <div class="row row-cols-1 row-cols-md-3 g-4 py-3 addons-manager">
                        @forelse(App\Models\SystemAddons::where('unique_identifier', '!=' ,'subscription')->get() as $key => $addon)
                        <div class="col col-md-6 col-lg-6 col-xl-3">
                            <div class="card h-100 rounded-3 overflow-hidden">
                                <img src="{!! URL('storage/app/public/addons/' . $addon->image) !!}" alt="">
                                <div class="card-body">
                                    <span class="badge bg-primary mb-2 fw-400 fs-8">{{ $addon->version }}</span>
                                    <h5 class="card-title fw-600 fs-5 line-limit-2">{{ ucfirst($addon->name) }}</h5>
                                </div>
                                <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
                                    <p class="text-muted fs-7 fw-500">{{ date('d M Y', strtotime($addon->created_at)); }}</p>
                                    @if ($addon->activated)
                                        <a href="#" class="btn btn-success fs-7"
                                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $addon->id }}','0','{{ URL::to('admin/systemaddons/update') }}')" @endif>Activated</a>
                                    @else
                                        <a href="#" class="btn btn-danger fs-7"
                                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $addon->id }}','1','{{ URL::to('admin/systemaddons/update') }}')" @endif>Deactivated</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col col-md-12 text-center text-muted">
                            <h4>No data</h4>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/custom/systemaddons.js') }}"></script>
@endsection