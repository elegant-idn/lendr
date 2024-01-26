<div
    class="d-flex justify-content-between align-items-center {{ str_contains(request()->url(), 'add') || str_contains(request()->url(), 'edit') ? 'mb-3' : '' }} ">
    @if (str_contains(request()->url(), 'add'))
        <h5 class="text-uppercase">{{ trans('labels.add_new') }}</h5>
    @endif
    @if (str_contains(request()->url(), 'edit'))
        <h5 class="text-uppercase">{{ trans('labels.edit') }}</h5>
    @endif
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            {{-- <li class="breadcrumb-item"><a href="{{ URL::to('/admin/dashboard') }}">{{ trans('labels.dashboard') }}</a>
            </li> --}}
            @if (request()->is('admin/users'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.vendors') }}</h5>
                </li>
            @elseif (request()->is('admin/users/add') || str_contains(request()->url(), 'admin/users/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/users') }}">
                        {{ trans('labels.vendors') }}
                    </a>
                </li>
            @endif
            @if (request()->is('admin/plan'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.pricing_plan') }}</h5>
                </li>
            @elseif(request()->is('admin/plan/add') || str_contains(request()->url(), 'admin/plan/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/plan') }}">{{ trans('labels.pricing_plan') }} </a>
                </li>
            @endif
            @if (request()->is('admin/payment'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.payment') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/transaction'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.transactions') }}<h5>
                </li>
            @endif
            @if (request()->is('admin/settings'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.setting') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/categories'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.categories') }}</h5>
                </li>
            @elseif(request()->is('admin/categories/add') || str_contains(request()->url(), 'admin/categories/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/categories') }}">{{ trans('labels.categories') }}</a>
                </li>
            @endif
            @if (request()->is('admin/how_works'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.how_works') }}</h5>
                </li>
            @elseif(request()->is('admin/how_works/add') || str_contains(request()->url(), 'admin/how_works/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/how_works') }}">{{ trans('labels.how_works') }}</a>
                </li>
            @endif
            @if (request()->is('admin/choose_us'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.choose_us') }}</h5>
                </li>
            @elseif(request()->is('admin/choose_us/add') || str_contains(request()->url(), 'admin/choose_us/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/choose_us') }}">{{ trans('labels.choose_us') }}</a>
                </li>
            @endif
            @if (request()->is('admin/products'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.products') }}</h5>
                </li>
            @elseif(request()->is('admin/products/add') || str_contains(request()->url(), 'admin/products/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/products') }}">{{ trans('labels.products') }}</a>
                </li>
            @endif
            @if (request()->is('admin/gallery'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.gallery') }}</h5>
                </li>
            @elseif(request()->is('admin/gallery/add') || str_contains(request()->url(), 'admin/gallery/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/gallery') }}">{{ trans('labels.gallery') }}</a>
                </li>
            @endif
            @if (request()->is('admin/workinghours*'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.workinghours') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/faqs'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.faqs') }}</h5>
                </li>
            @elseif(request()->is('admin/faqs/add') || str_contains(request()->url(), 'admin/faqs/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/faqs') }}">{{ trans('labels.faqs') }}</a>
                </li>
            @endif
            @if (request()->is('admin/features'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.features') }}</h5>
                </li>
            @elseif(request()->is('admin/features/add') || str_contains(request()->url(), 'admin/features/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/features') }}">{{ trans('labels.features') }}</a>
                </li>
            @endif
            @if (request()->is('admin/promotionalbanners'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.promotional_banners') }}</h5>
                </li>
            @elseif(request()->is('admin/promotionalbanners/add') || str_contains(request()->url(), 'admin/promotionalbanners/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/promotionalbanners') }}">{{ trans('labels.promotional_banners') }}</a>
                </li>
            @endif
            @if (request()->is('admin/testimonials'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.testimonials') }}</h5>
                </li>
            @elseif(request()->is('admin/testimonials/add') || str_contains(request()->url(), 'admin/testimonials/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/testimonials') }}">{{ trans('labels.testimonials') }}</a>
                </li>
            @endif
            @if (request()->is('admin/cities'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.cities') }}</h5>
                </li>
            @elseif(request()->is('admin/cities/add') || str_contains(request()->url(), 'admin/cities/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/cities') }}">{{ trans('labels.cities') }}</a>
                </li>
            @endif
            @if (request()->is('admin/countries'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.countries') }}</h5>
                </li>
            @elseif(request()->is('admin/countries/add') || str_contains(request()->url(), 'admin/countries/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/countries') }}">{{ trans('labels.countries') }}</a>
                </li>
            @endif
            @if (request()->is('admin/promocode'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.coupons') }}</h5>
                </li>
            @elseif(request()->is('admin/promocode/add') || str_contains(request()->url(), 'admin/promocode/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/promocode') }}">{{ trans('labels.coupons') }}</a>
                </li>
            @endif
            @php
                $url = '';
            @endphp
            @if (request()->is('admin/bannersection-1') ||
                    request()->is('admin/bannersection-2') ||
                    request()->is('admin/bannersection-3'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ @$title }}</h5>
                </li>
            @elseif(
                (str_contains(request()->url(), 'add') || str_contains(request()->url(), 'edit')) &&
                    str_contains(request()->url(), 'bannersection'))
                <li class="breadcrumb-item"><a href="{{ $table_url }}">{{ @$title }}</a></li>
            @endif
            @if (request()->is('admin/pickup_location') ||
                    request()->is('admin/drop_location'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ @$locationtitle }}</h5>
                </li>
            @elseif(
                (str_contains(request()->url(), 'add') || str_contains(request()->url(), 'edit')) &&
                    str_contains(request()->url(), 'drop') || str_contains(request()->url(), 'pickup') )
                <li class="breadcrumb-item"><a href="{{ $location_url }}">{{ @$locationtitle }}</a></li>
            @endif
            @if (request()->is('admin/blogs'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.blogs') }}</h5>
                </li>
            @elseif(request()->is('admin/blogs/add') || str_contains(request()->url(), 'admin/blogs/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/blogs') }}">{{ trans('labels.blogs') }}</a>
                </li>
            @endif
            @if (request()->is('admin/bookings'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/bookings') }}">
                        <h5 class="text-uppercase">{{ trans('labels.bookings') }}</h5>
                    </a>
                </li>
            @endif
            @if (request()->is('admin/contacts'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.inquiries') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/reports*'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.reports') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/privacypolicy'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.privacy_policy') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/termscondition'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.terms_condition') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/aboutus'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.about_us') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/custom_domain'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.custom_domain') }}</h5>
                </li>
            @elseif(request()->is('admin/custom_domain/add') || str_contains(request()->url(), 'admin/custom_domain/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/custom_domain') }}">{{ trans('labels.custom_domain') }}</a>
                </li>
            @endif
            @if (request()->is('admin/apps'))
                <li class="breadcrumb-item">
                    <h5 class="text-uppercase">{{ trans('labels.addons_manager') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/apps/add'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/apps') }}">{{ trans('labels.addons_manager') }}</a>
                </li>
            @endif
            @if (str_contains(request()->url(), 'add'))
                <li class="breadcrumb-item active {{ session()->get('direction') == 2 ? 'breadcrumb-rtl' : '' }}">
                    {{ trans('labels.add') }}</li>
            @endif
            @if (str_contains(request()->url(), 'edit'))
                <li class="breadcrumb-item active {{ session()->get('direction') == 2 ? 'breadcrumb-rtl' : '' }}">
                    {{ trans('labels.edit') }}</li>
            @endif
            @if (str_contains(request()->url(), 'selectplan'))
                <li class="breadcrumb-item active">{{ trans('labels.buy_now') }}</li>
            @endif

            @if (str_contains(request()->url(), 'invoice'))
                <h5 class="text-uppercase">
                    <li class="breadcrumb-item active">{{ trans('labels.invoice') }}</li>
                </h5>
            @endif
        </ol>
    </nav>

    @if (request()->is('admin/apps'))
        <a href="{{ URL::to('admin/apps/add') }}" class="btn btn-secondary px-2 d-flex">
            <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.install_update_addons') }}</a>
    @endif
    @if (Auth::user()->type == 2)
        @if (request()->is('admin/custom_domain'))
            <a href="{{ URL::to('admin/custom_domain/add') }}"
                class="btn btn-secondary">{{ trans('labels.request_custom_domain') }}</a>
        @endif
    @endif
    @if (request()->is('admin/transaction'))
        <form action="{{ URL::to('/admin/transaction') }} " class="col-7" method="get">
            <div class="row">
                <div class="col-12">
                    <div class="input-group ps-0 justify-content-end">
                        @if (Auth::user()->type == 1)
                            <select class="form-select transaction-select" name="vendor">
                                <option value=""
                                    data-value="{{ URL::to('/admin/transaction?vendor=' . '&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}"
                                    selected>{{ trans('labels.select') }}</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}"
                                        data-value="{{ URL::to('/admin/transaction?vendor=' . $vendor->id . '&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}"
                                        {{ request()->get('vendor') == $vendor->id ? 'selected' : '' }}>
                                        {{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        @endif
                        <div class="input-group-append px-1">
                            <input type="date" class="form-control rounded" name="startdate"
                                value="{{ request()->get('startdate') }}">
                        </div>
                        <div class="input-group-append px-1">
                            <input type="date" class="form-control rounded" name="enddate"
                                value="{{ request()->get('enddate') }}">
                        </div>
                        <div class="input-group-append px-1">
                            <button class="btn btn-primary rounded"
                                type="submit">{{ trans('labels.fetch') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif
    @if (request()->is('admin/reports'))
        <form action="{{ URL::to('/admin/reports') }}">
            <div class="input-group col-md-12 ps-0">
                <div class="input-group-append col-auto px-1">
                    <input type="date" class="form-control rounded" name="startdate"
                        value="{{ request()->get('startdate') }}" required="">
                </div>

                <div class="input-group-append col-auto px-1">
                    <input type="date" class="form-control rounded" name="enddate"
                        value="{{ request()->get('enddate') }}" required="">
                </div>
                <div class="input-group-append">
                    <button class="btn btn-primary rounded" type="submit">{{ trans('labels.fetch') }}</button>
                </div>
            </div>
        </form>
    @endif
    @if (str_contains(request()->url(), 'add') ||
            str_contains(request()->url(), 'edit') ||
            request()->is('admin/payment') ||
            request()->is('admin/transaction') ||
            request()->is('admin/settings') ||
            request()->is('admin/workinghours*') ||
            request()->is('admin/bookings*') ||
            request()->is('admin/contacts') ||
            request()->is('admin/reports*') ||
            request()->is('admin/privacypolicy') ||
            request()->is('admin/termscondition') ||
            request()->is('admin/aboutus') ||
            request()->is('admin/custom_domain') ||
            str_contains(request()->url(), 'invoice') ||
            request()->is('admin/apps') ||
            request()->is('admin/customers*') ||
            request()->is('admin/custom_domain') ||
            (request()->is('admin/plan*') && Auth::user()->type == 2) ||
            request()->is('admin/how_works') ||
            request()->is('admin/choose_us'))
        <a href="{{ URL::to(request()->url() . '/add') }}" class="btn btn-secondary px-2 d-none">
            <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}</a>
    @else
        <a href="{{ URL::to(request()->url() . '/add') }}" class="btn btn-secondary px-2 d-flex">
            <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}</a>
    @endif

</div>
