<ul class="navbar-nav">
    <li class="nav-item fs-7">
        <a class="nav-link d-flex rounded {{ request()->is('admin/dashboard') ? 'active' : '' }}" aria-current="page"
            href="{{ URL::to('/admin/dashboard') }}">
            <i class="fa-solid fa-house-user"></i>
            <span>{{ trans('labels.dashboard') }}</span>
        </a>
    </li>
   
    {{-- @if (Auth::user()->type == 2)
        <li class="nav-item mt-3">
            <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.booking_management') }}</h6>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link  d-flex rounded {{ request()->is('admin/bookings*') || request()->is('admin/invoice*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('/admin/bookings') }}">
                <i class="fa-solid fa-list-check"></i>
                <span>{{ trans('labels.bookings') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link  d-flex rounded {{ request()->is('admin/reports*') ? 'active' : '' }} "
                aria-current="page" href="{{ URL::to('/admin/reports') }}">
                <i class="fa-solid fa-chart-mixed"></i>
                <span>{{ trans('labels.reports') }}</span>
            </a>
        </li>
        <li class="nav-item mt-3">
            <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.web_settings') }}</h6>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link  d-flex rounded {{ request()->is('admin/how_works*') ? 'active' : '' }}" aria-current="page"
                href="{{ URL::to('/admin/how_works') }}">
                <i class="fa-solid fa-briefcase"></i>
                <span>{{ trans('labels.how_works') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link  d-flex rounded {{ request()->is('admin/choose_us*') ? 'active' : '' }}" aria-current="page"
                href="{{ URL::to('/admin/choose_us') }}">
                <i class="fa-solid fa-tag"></i>
                <span>{{ trans('labels.choose_us') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7"> 
            <a class="nav-link  d-flex rounded {{ request()->is('admin/gallery*') ? 'active' : '' }}" aria-current="page"
                href="{{ URL::to('/admin/gallery') }}">
                <i class="fa-solid fa-images"></i>
                <span>{{ trans('labels.gallery') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7 dropdown multimenu">
            <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
                href="#locations" data-bs-toggle="collapse" role="button" aria-expanded="false"
                aria-controls="locations">
                <span class="d-flex"><i class="fa-sharp fa-solid fa-location-dot"></i><span
                        class="multimenu-title">{{ trans('labels.locations') }}</span></span>
            </a>
            <ul class="collapse" id="locations">
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded {{ request()->is('admin/pickup_location*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/pickup_location') }}">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i>{{ trans('labels.pickup_location') }}</span>
                    </a>
                </li>
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded {{ request()->is('admin/drop_location*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/drop_location') }}">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i>{{ trans('labels.drop_location') }}</span>
                    </a>
                </li>

            </ul>
        </li>
        </li>
    @endif --}}
    {{-- business management --}}
    {{-- <li class="nav-item mt-3">
        <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.business_management') }}</h6>
    </li>

    @if (Auth::user()->type == '1')
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link  d-flex rounded {{ request()->is('admin/users*') ? 'active' : '' }}" aria-current="page"
                href="{{ URL::to('/admin/users') }}">
                <i class="fa-solid fa-user-plus"></i>
                <span>{{ trans('labels.vendors') }}</span>
            </a>
        </li>
    @endif
    @if (App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first() != null &&
    App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first()->activated == 1)
    <li class="nav-item mb-2 fs-7">
        <a class="nav-link rounded d-flex {{ request()->is('admin/customers*') ? 'active' : '' }}" aria-current="page" href="{{ URL::to('admin/customers') }}">
            <i class="fa-solid fa-users"></i>
            <p class="w-100 d-flex justify-content-between">
                <span>{{ trans('labels.customers') }}</span>
                @if (env('Environment') == 'sendbox')<span class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>@endif
            </p>
        </a>
    </li>
    @endif
    @if (Auth::user()->type == 1 || Auth::user()->type == 2 && App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
            App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link  d-flex rounded {{ request()->is('admin/plan*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('/admin/plan') }}">
                <i class="fa-solid fa-medal"></i>
                <span>{{ trans('labels.pricing_plan') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link d-flex rounded {{ request()->is('admin/transaction') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('/admin/transaction') }}">
                <i class="fa-solid fa-file-invoice-dollar"></i>
                <span>{{ trans('labels.transactions') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link  d-flex rounded {{ request()->is('admin/payment') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('/admin/payment') }}">
                <i class="fa-solid fa-money-check-dollar-pen"></i>
                <span>{{ trans('labels.payment') }}</span>
            </a>
        </li>
    @endif

    @if (Auth::user()->type == 1)
        <li class="nav-item mb-2 fs-7 dropdown multimenu">
            <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
                href="#location" data-bs-toggle="collapse" role="button" aria-expanded="false"
                aria-controls="location">
                <span class="d-flex"><i class="fa-sharp fa-solid fa-location-dot"></i><span
                        class="multimenu-title">{{ trans('labels.location') }}</span></span>
            </a>
            <ul class="collapse" id="location">
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded {{ request()->is('admin/countries') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/countries') }}">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i>{{ trans('labels.countries') }}</span>
                    </a>
                </li>
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded {{ request()->is('admin/cities') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/cities') }}">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i>{{ trans('labels.cities') }}</span>
                    </a>
                </li>
            </ul>
        </li>
    @endif
    @if (Auth::user()->type == 1)
        @if (App\Models\SystemAddons::where('unique_identifier', 'custom_domain')->first() != null &&
                App\Models\SystemAddons::where('unique_identifier', 'custom_domain')->first()->activated == 1)
            <li class="nav-item mb-2 fs-7">
                <a class="nav-link d-flex rounded {{ request()->is('admin/custom_domain*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/custom_domain') }}">
                    <i class="fa-solid fa-link"></i>
                    <p class="w-100 d-flex justify-content-between">
                        <span>{{ trans('labels.custom_domains') }}</span>
                        @if (env('Environment') == 'sendbox')
                            <span
                                class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                        @endif
                    </p>
                </a>
            </li>
        @endif
    @endif
    @if (Auth::user()->type == 2)
        @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)

            @if (App\Models\SystemAddons::where('unique_identifier', 'custom_domain')->first() != null &&
                    App\Models\SystemAddons::where('unique_identifier', 'custom_domain')->first()->activated == 1)
                <?php
                if (Auth::user()->type == 2) {
                    $checkplan = App\Models\Transaction::where('vendor_id', Auth::user()->id)
                        ->orderByDesc('id')
                        ->first();
                    $custom_domain = @$checkplan->custom_domain;
                } else {
                    $custom_domain = 1;
                }
                ?>
                @if (@$custom_domain == 1)
                    <li class="nav-item mb-2 fs-7">
                        <a class="nav-link d-flex rounded {{ request()->is('admin/custom_domain*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/custom_domain') }}">
                            <i class="fa-solid fa-link"></i>
                            <p class="w-100 d-flex justify-content-between">
                                <span>{{ trans('labels.custom_domains') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span
                                        class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                                @endif
                            </p>

                        </a>
                    </li>
                @endif
            @endif
        @else
            @if (App\Models\SystemAddons::where('unique_identifier', 'custom_domain')->first() != null &&
                    App\Models\SystemAddons::where('unique_identifier', 'custom_domain')->first()->activated == 1)
                <li class="nav-item mb-2 fs-7">
                    <a class="nav-link d-flex rounded {{ request()->is('admin/custom_domain*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/custom_domain') }}">
                        <i class="fa-solid fa-link"></i>
                        <p class="w-100 d-flex justify-content-between">
                            <span>{{ trans('labels.custom_domains') }}</span>
                            @if (env('Environment') == 'sendbox')
                                <span
                                    class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                            @endif
                        </p>

                    </a>
                </li>
            @endif
        @endif
    @endif --}}
        <li class="nav-item mt-3">
            <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.service_management') }}</h6>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link rounded d-flex {{ request()->is('admin/categories*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('/admin/categories') }}">
                <i class="fa-sharp fa-solid fa-list"></i> <span
                    class="">{{ trans('labels.categories') }}</span>
            </a>
        </li>
    {{-- 
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link rounded d-flex {{ request()->is('admin/products*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('/admin/products') }}">
                <i class="fa-solid fa-list-timeline"></i> <span class="">{{ trans('labels.products') }}</span>
            </a>
        </li>

        <li class="nav-item mt-3">
            <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.promotions') }}</h6>
        </li>
        <li class="nav-item mb-2 fs-7 dropdown multimenu">
            <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
                href="#banners" data-bs-toggle="collapse" role="button" aria-expanded="false"
                aria-controls="banners">
                <span class="d-flex"><i class="fa-solid fa-image"></i><span
                        class="multimenu-title">{{ trans('labels.banners') }}</span></span>
            </a>
            <ul class="collapse" id="banners">
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded {{ request()->is('admin/bannersection-1*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/bannersection-1') }}">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i>{{ trans('labels.section-1') }}</span>
                    </a>
                </li>
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded {{ request()->is('admin/bannersection-2*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/bannersection-2') }}">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i>{{ trans('labels.section-2') }}</span>
                    </a>
                </li>

            </ul>
        </li>

        @if (App\Models\SystemAddons::where('unique_identifier', 'coupon')->first() != null &&
                App\Models\SystemAddons::where('unique_identifier', 'coupon')->first()->activated == 1)
            <li class="nav-item mb-2 fs-7">
                <a class="nav-link  d-flex rounded {{ request()->is('admin/promocode*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/promocode') }}">
                    <i class="fa-solid fa-tags"></i>
                    <p class="w-100 d-flex justify-content-between">
                        <span class="nav-text ">{{ trans('labels.coupons') }}</span>
                        @if (env('Environment') == 'sendbox')
                            <span
                                class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                        @endif
                    </p>
                </a>
            </li>
        @endif
    --}}

    @if (Auth::user()->type == 1)
        {{-- Product approval Page --}}
        <li class="nav-item mt-3">
            <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.product_management') }}</h6>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link d-flex rounded {{ request()->is('admin/products/approval') ? 'active' : '' }}" aria-current="page"
                href="{{ URL::to('/admin/products/approval') }}">
                <i class="fa-solid fa-clipboard-check"></i>
                <span>{{ trans('labels.product_approval_page') }}</span>
            </a>
        </li>

        {{-- landing Page --}}
        {{-- <li class="nav-item mt-3">
            <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.landing_page') }}</h6>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link d-flex rounded {{ request()->is('admin/features*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('/admin/features') }}">
                <i class="fa-solid fa-list"></i>
                <span>{{ trans('labels.features') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link d-flex rounded {{ request()->is('admin/promotionalbanners*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('/admin/promotionalbanners') }}">
                <i class="fa-solid fa-bullhorn"></i>
                <span>{{ trans('labels.promotional_banners') }}</span>
            </a>
        </li>
        @if (App\Models\SystemAddons::where('unique_identifier', 'blog')->first() != null &&
                App\Models\SystemAddons::where('unique_identifier', 'blog')->first()->activated == 1)
            <li class="nav-item mb-2 fs-7">
                <a class="nav-link d-flex rounded {{ request()->is('admin/blogs*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/blogs') }}">
                    <i class="fa-solid fa-blog"></i>
                    <p class="w-100 d-flex justify-content-between">
                        <span class="nav-text ">{{ trans('labels.blogs') }}</span>
                        @if (env('Environment') == 'sendbox')
                            <span
                                class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                        @endif
                    </p>
                </a>
            </li>
        @endif
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link d-flex rounded {{ request()->is('admin/faqs*') ? 'active' : '' }}" aria-current="page"
                href="{{ URL::to('/admin/faqs') }}">
                <i class="fa-solid fa-question"></i>
                <span>{{ trans('labels.faqs') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link d-flex rounded {{ request()->is('admin/testimonials*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('/admin/testimonials') }}">
                <i class="fa-solid fa-comment-dots"></i>
                <span>{{ trans('labels.testimonials') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link rounded d-flex {{ request()->is('admin/subscribers*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('admin/subscribers') }}">
                <i class="fa-solid fa-envelope"></i> <span class="">{{ trans('labels.subscribers') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link  d-flex rounded {{ request()->is('admin/contacts') ? 'active' : '' }} "
                aria-current="page" href="{{ URL::to('/admin/contacts') }}">
                <i class="fa-solid fa-solid fa-address-book"></i>
                <span>{{ trans('labels.inquiries') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7 dropdown multimenu d-none">
            <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
                href="#pages" data-bs-toggle="collapse" role="button" aria-expanded="false"
                aria-controls="pages">
                <span class="d-flex"><i class="fa-solid fa-file-lines"></i></i><span
                        class="multimenu-title">{{ trans('labels.cms_pages') }}</span></span>
            </a>
            <ul class="collapse" id="pages">
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded {{ request()->is('admin/privacypolicy') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/privacypolicy') }}">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i>{{ trans('labels.privacy_policy') }}</span>
                    </a>
                </li>
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded {{ request()->is('admin/termscondition') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/termscondition') }}">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i>{{ trans('labels.terms_condition') }}</span>
                    </a>
                </li>
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded {{ request()->is('admin/aboutus*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/aboutus') }}">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i>{{ trans('labels.about_us') }}</span>
                    </a>
                </li>

            </ul>
        </li> --}}
    @endif


    {{-- other --}}
    <li class="nav-item mt-3">
        <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.other') }}</h6>
    </li>

    <li class="nav-item mb-2 fs-7">
        <a class="nav-link d-flex rounded {{ request()->is('admin/settings') ? 'active' : '' }}" aria-current="page"
            href="{{ URL::to('/admin/settings') }}">
            <i class="fa-solid fa-gear"></i>
            <span>{{ trans('labels.setting') }}</span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7">
        <a class="nav-link d-flex rounded {{ request()->is('admin/faqs*') ? 'active' : '' }}"
            aria-current="page" href="{{ URL::to('/admin/faqs') }}">
            <i class="fa-solid fa-question"></i>
            <span>{{ trans('labels.faqs') }}</span>
        </a>
    </li>

    <li class="nav-item mb-2 fs-7 dropdown multimenu">
        <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
            href="#pages" data-bs-toggle="collapse" role="button" aria-expanded="false"
            aria-controls="pages">
            <span class="d-flex"><i class="fa-solid fa-file-lines"></i><span
                    class="multimenu-title">{{ trans('labels.cms_pages') }}</span></span>
        </a>
        <ul class="collapse" id="pages">
            <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded {{ request()->is('admin/privacypolicy') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/privacypolicy') }}">
                    <span class="d-flex align-items-center multimenu-menu-indicator"><i
                            class="fa-solid fa-circle-small"></i>{{ trans('labels.privacy_policy') }}</span>
                </a>
            </li>
            <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded {{ request()->is('admin/termscondition') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/termscondition') }}">
                    <span class="d-flex align-items-center multimenu-menu-indicator"><i
                            class="fa-solid fa-circle-small"></i>{{ trans('labels.terms_condition') }}</span>
                </a>
            </li>
            {{-- <li class="nav-item ps-4 mb-1">
                <a class="nav-link rounded {{ request()->is('admin/aboutus*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/aboutus') }}">
                    <span class="d-flex align-items-center multimenu-menu-indicator"><i
                            class="fa-solid fa-circle-small"></i>{{ trans('labels.about_us') }}</span>
                </a>
            </li> --}}
        </ul>
    </li>
    {{-- @if (Auth::user()->type == 2)
        @if (App\Models\SystemAddons::where('unique_identifier', 'blog')->first() != null &&
                App\Models\SystemAddons::where('unique_identifier', 'blog')->first()->activated == 1)
            <li class="nav-item mb-2 fs-7">
                <a class="nav-link d-flex rounded {{ request()->is('admin/blogs*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/blogs') }}">
                    <i class="fa-solid fa-blog"></i>
                    <p class="w-100 d-flex justify-content-between">
                        <span class="nav-text ">{{ trans('labels.blogs') }}</span>
                        @if (env('Environment') == 'sendbox')
                            <span
                                class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                        @endif
                    </p>
                </a>
            </li>
        @endif
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link d-flex rounded {{ request()->is('admin/testimonials*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('/admin/testimonials') }}">
                <i class="fa-solid fa-comment-dots"></i>
                <span>{{ trans('labels.testimonials') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link rounded d-flex {{ request()->is('admin/subscribers*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('admin/subscribers') }}">
                <i class="fa-solid fa-envelope"></i> <span class="">{{ trans('labels.subscribers') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link  d-flex rounded {{ request()->is('admin/contacts') ? 'active' : '' }} "
                aria-current="page" href="{{ URL::to('/admin/contacts') }}">
                <i class="fa-solid fa-solid fa-address-book"></i>
                <span>{{ trans('labels.inquiries') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link rounded d-flex {{ request()->is('admin/share*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('admin/share') }}">
                <i class="fa-solid fa-share-from-square"></i> <span
                    class="">{{ trans('labels.share') }}</span>
            </a>
        </li>
    @endif

    <li class="nav-item mb-2 fs-7 {{ Auth::user()->type != 1 ? (in_array('23', $modules) == true ? '' : 'd-none') : '' }}" id="23">
        <a class="nav-link rounded d-flex {{ request()->is('admin/systemaddons*') ? 'active' : '' }}" href="{{ URL::to('/admin/systemaddons') }}" aria-expanded="false">
            <i class="fa fa-puzzle-piece"></i><span class="nav-text ">{{ trans('labels.addons_manager') }}</span>
        </a>
    </li> --}}
</ul>
