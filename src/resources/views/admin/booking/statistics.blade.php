<div class="row my-3">
    <div class="col-lg-3 col-md-4 col-sm-6 my-1">
        <div
            class="card box-shadow h-100 {{ request()->get('type') == '' ? 'border border-primary' : 'border-0' }}">
            @if (request()->is('admin/reports'))
                <a href="{{ URL::to(request()->url() . '?type=&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                @elseif(request()->is('admin/bookings'))
                    <a href="{{ URL::to('admin/bookings?type=') }}">
                    @elseif(request()->is('admin/customers/bookings*'))
                        <a href="{{ URL::to('admin/customers/bookings-' . @$userinfo->id . '?type=') }}">
            @endif
            <div class="card-body">
                <div class="dashboard-card">
                    <span class="card-icon">
                    <i class="fa fa-book-user"></i>
                    </span>
                    <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                        <p class="text-muted fw-medium mb-1">{{ trans('labels.total_bookings') }}</p>
                        <h4>{{ $totalbooking }}</h4>
                    </span>
                </div>
            </div>
            </a>
        </div>

    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 my-1">
        <div
            class="card box-shadow h-100 {{ request()->get('type') == 'processing' ? 'border border-primary' : 'border-0' }}">
            @if (request()->is('admin/reports'))
                <a href="{{ URL::to(request()->url() . '?type=processing&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                @elseif(request()->is('admin/bookings'))
                    <a href="{{ URL::to('admin/reports?type=processing') }}">
                    @elseif(request()->is('admin/customers/bookings*'))
                        <a href="{{ URL::to('admin/customers/bookings-' . @$userinfo->id . '?type=processing') }}">
            @endif
            <div class="card-body">
                <div class="dashboard-card">
                    <span class="card-icon">
                        <i class="fa fa-hourglass"></i>
                    </span>
                    <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                        <p class="text-muted fw-medium mb-1">{{ trans('labels.processing') }}</p>
                        <h4>{{ $totalprocessing }}</h4>
                    </span>
                </div>
            </div>
            </a>
        </div>

    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 my-1">
        <div
            class="card box-shadow h-100 {{ request()->get('type') == 'completed' ? 'border border-primary' : 'border-0' }}">
            @if (request()->is('admin/reports'))
                <a href="{{ URL::to(request()->url() . '?type=completed&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                @elseif(request()->is('admin/bookings'))
                    <a href="{{ URL::to('admin/reports?type=completed') }}">
                    @elseif(request()->is('admin/customers/bookings*'))
                        <a href="{{ URL::to('admin/customers/bookings-' . @$userinfo->id . '?type=completed') }}">
            @endif
            <div class="card-body">
                <div class="dashboard-card">
                    <span class="card-icon">
                        <i class="fa fa-check"></i>
                    </span>
                    <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                        <p class="text-muted fw-medium mb-1">{{ trans('labels.completed') }}</p>
                        <h4>{{ $totalcompleted }}</h4>
                    </span>
                </div>
            </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 my-1">
        <div
            class="card box-shadow h-100 {{ request()->get('type') == 'canceled' ? 'border border-primary' : 'border-0' }}">
            @if (request()->is('admin/reports'))
                <a href="{{ URL::to(request()->url() . '?type=canceled&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                @elseif(request()->is('admin/bookings'))
                    <a href="{{ URL::to('admin/reports?type=canceled') }}">
                    @elseif(request()->is('admin/customers/bookings*'))
                        <a href="{{ URL::to('admin/customers/bookings-' . @$userinfo->id . '?type=canceled') }}">
            @endif
            <div class="card-body">
                <div class="dashboard-card">
                    <span class="card-icon">
                    <i class="fa fa-close"></i>
                    </span>
                    <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                        <p class="text-muted fw-medium mb-1">{{ trans('labels.canceled') }}</p>
                        <h4>{{ $totalcanceled }}</h4>
                    </span>
                </div>
            </div>
            </a>
        </div>
    </div>
</div>
