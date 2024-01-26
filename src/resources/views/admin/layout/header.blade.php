<header class="page-topbar">
    <div class="navbar-header">
        <button class="navbar-toggler d-lg-none d-md-block px-4" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarcollapse" aria-expanded="false" aria-controls="sidebarcollapse">
            <i class="fa-regular fa-bars fs-4"></i>
        </button>
        <div class="px-3 d-flex align-items-center">
            @if (session('vendor_login'))
                <a href="{{ URL::to('/admin/admin_back') }}"
                    class="btn btn-primary btn-sm mx-1"><i class="fa-solid fa-backward"></i></a>
            @endif
                @if (Auth::user()->type == 2)
            <a class="btn btn-outline-secondary btn-sm mx-1" href="{{ URL::to('/' . Auth::user()->slug) }}"
                target="_blank"><i class="fa-solid fa-link"></i>
            </a>
            @endif
          
                    {{-- <div class="header-btn d-flex align-items-center">
                        <a href="#">
                            <div class="dropdown border py-1 rounded-2 mx-3">
                                <a class=" dropdown-toggle mx-1 border-0 rounded-1 language-drop" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ helper::image_path(session()->get('flag')) }}" alt=""
                                        class="img-fluid" width="25px">
                                    {{ session()->get('language') }}
                                </a>

                                <ul class="dropdown-menu drop-menu {{ session()->get('direction') == 2 ? 'drop-menu-rtl' : 'drop-menu'}}" >
                                    @foreach (helper::listoflanguage() as $languagelist)
                                        <li>
                                            <a class="dropdown-item d-flex text-start"
                                                href="{{ URL::to('/lang/change?lang=' . $languagelist->code) }}">
                                                <img src="{{ helper::image_path($languagelist->image) }}"
                                                    alt="" class="img-fluid mx-1" width="25px">
                                                {{ $languagelist->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </a>
                    </div> --}}
             
            <div class="dropwdown d-inline-block">
                <button class="btn header-item" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ helper::image_path(Auth::user()->image) }}">
                    <span class="d-none d-xxl-inline-block d-xl-inline-block ms-1">{{ Auth::user()->name }}</span>
                    <i class="fa-regular fa-angle-down d-none d-xxl-inline-block d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu box-shadow">
                    <a href="{{ URL::to('admin/settings') }}#editprofile"
                        class="dropdown-item d-flex align-items-center">
                        <i class="fa-light fa-address-card fs-5 mx-2"></i>{{ trans('labels.edit_profile') }}
                    </a>
                    <a href="{{ URL::to('admin/settings') }}#changepasssword" class="dropdown-item d-flex align-items-center">
                       
                        <i class="fa-light fa-lock-keyhole fs-5 mx-2"></i>{{ trans('labels.change_password') }}

                    </a>
                
                    <a href="javascript:void(0)" onclick="statusupdate('{{ URL::to('/admin/logout')}}')"
                        class="dropdown-item d-flex align-items-center">
                        <i class="fa-light fa-right-from-bracket fs-5 mx-2"></i>{{ trans('labels.logout') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
