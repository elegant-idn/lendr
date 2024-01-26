@extends('admin.layout.default')
@section('content')
    <div class="d-flex mb-3">
        <h5 class="text-uppercase">{{ trans('labels.dashboard') }}</h5>
    </div>
    <div class="row">
        <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
            <div class="card border-0 box-shadow h-100">
                <div class="card-body">
                    <div class="dashboard-card">
                        <span class="card-icon">
                            @if (Auth::user()->type == 1)
                                <i class="fa-regular fa-user fs-5"></i>
                            @endif
                            @if (Auth::user()->type == 2)
                                <i class="fa-brands fa-servicestack fs-5"></i>
                            @endif
                        </span>
                        <span class="{{session()->get('direction') == 2 ? 'text-start':'text-end' }}">
                            <p class="text-muted fw-medium mb-1">{{ trans('labels.customers') }}</p>
                            <h4 >{{ empty($totalusers) ? 0 : $totalusers }}</h4>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
            <div class="card border-0 box-shadow h-100">
                <div class="card-body">
                    <div class="dashboard-card">
                        <span class="card-icon">
                            <i class="fa-regular fa-boxes-stacked fs-5"></i>
                        </span>
                        <span class="{{session()->get('direction') == 2 ? 'text-start':'text-end' }}">
                            <p class="text-muted fw-medium mb-1">{{ trans('labels.products') }}</p>
                            <h4>{{ empty($totalproducts) ? 0 : $totalproducts }}</h4>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
            <div class="card border-0 box-shadow h-100">
                <div class="card-body">
                    <div class="dashboard-card">
                        <span class="card-icon">
                                <i class="fa-solid fa-ballot-check fs-5"></i>
                        </span>
                        <span class="{{session()->get('direction') == 2 ? 'text-start':'text-end' }}">
                            <p class="text-muted fw-medium mb-1">
                                {{ trans('labels.transactions') }}
                            </p>
                            <h4>{{ empty($totaladminbookings) ? 0 : $totaladminbookings }}</h4>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
            <div class="card border-0 box-shadow h-100">
                <div class="card-body">
                    <div class="dashboard-card">
                        <span class="card-icon">
                            <i class="fa-regular fa-money-bill-1-wave fs-5"></i>
                        </span>
                        <span class="{{session()->get('direction') == 2 ? 'text-start':'text-end' }}">
                            <p class="text-muted fw-medium mb-1">{{ trans('labels.revenue') }}
                            </p>
                            <h4>{{ helper::currency_formate($totalrevenue->total, Auth::user()->id) }}</h4>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8  mb-3">
            <div class="card border-0 box-shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title">{{ trans('labels.revenue') }}</h5>
                        <select class="form-select form-select-sm w-auto" name="revenue_year" id="revenue_year">
                            @foreach ($revenue_year_list as $year)
                                <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                    {{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <canvas id="linechart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 box-shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title">
                            {{ trans('labels.approved_products') }}</h5>
                        <select class="form-select form-select-sm w-auto" name="booking_year" id="booking_year">
                            @foreach ($userchart_year as $year)
                                <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                    {{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <canvas id="piechart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <h5 class="card-title text-uppercase">
            {{ trans('labels.today_transaction') }}
        </h5>
        <div class="col-12">
            <div class="card border-0 my-3">
                <div class="card-body">
                    <div class="table-responsive">
                        @include('admin.admintransaction')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/chartjs/chart_3.9.1.min.js') }}"></script>
    <script>
        var revenue_chart = null;
        var piechart = null;
        var revenue_lables = {{ Js::from($revenue_lables) }};
        var revenue_data = {{ Js::from($revenue_data) }};
        var piechart_lables = {{ Js::from($piechart_lables) }};
        var piechart_data = {{ Js::from($piechart_data) }};
    </script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/dashboard.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/booking.js') }}"></script>
@endsection
