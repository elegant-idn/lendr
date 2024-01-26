@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')
    <div class="row settings mt-3">
        <div class="col-xl-3 mb-3">
            <div class="card card-sticky-top border-0">
                <ul class="list-group list-options">
                    {{-- <a href="#basicinfo" data-tab="basicinfo"
                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center active"
                        aria-current="true">{{ trans('labels.basic_info') }}
                        <i class="fa-regular fa-angle-right"></i>
                    </a>
                    @if (Auth::user()->type == 2)
                        <a href="#themesettings" data-tab="themesettings"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.theme_settings') }} <i
                                class="fa-regular fa-angle-right"></i></a>
                    @endif --}}
                    <a href="#editprofile" data-tab="editprofile"
                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                        aria-current="true">{{ trans('labels.edit_profile') }}
                        <i class="fa-regular fa-angle-right"></i>
                    </a>
                    <a href="#changepasssword" data-tab="changepasssword"
                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                        aria-current="true">{{ trans('labels.change_password') }}
                        <i class="fa-regular fa-angle-right"></i>
                    </a>
                    <a href="#seo" data-tab="seo"
                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                        aria-current="true">{{ trans('labels.seo') }}
                        <i class="fa-regular fa-angle-right"></i>
                    </a>
                    {{-- @if (Auth::user()->type == 2)
                        @if (App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first()->activated == 1)
                            <a href="#whatsapp" data-tab="whatsapp"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.whatsapp_message_settings') }}@if (env('Environment') == 'sendbox')
                                    <span class="badge badge bg-danger me-5">{{ trans('labels.addon') }}</span>
                                @endif
                                <i class="fa-regular fa-angle-right"></i>
                            </a>
                        @endif

                        @if (App\Models\SystemAddons::where('unique_identifier', 'telegram_message')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'telegram_message')->first()->activated == 1)
                            <a href="#telegram" data-tab="telegram"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.telegram_message_settings') }}@if (env('Environment') == 'sendbox')
                                    <span class="badge badge bg-danger me-5">{{ trans('labels.addon') }}</span>
                                @endif
                                <i class="fa-regular fa-angle-right"></i>
                            </a>
                        @endif

                    @endif --}}
                    @if (Auth::user()->type == 1)
                        <a href="#landing_page" data-tab="landing_page"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.landing_page') }}
                            <i class="fa-regular fa-angle-right"></i>
                        </a>
                    @endif
                    <a href="#productSettings" data-tab="productSettings"
                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                        aria-current="true">{{ trans('labels.product_settings') }}
                        <i class="fa-regular fa-angle-right"></i>
                    </a>
                </ul>
            </div>
        </div>
        <div class="col-xl-9">
            <div id="settingmenuContent">
                {{-- <div id="basicinfo">
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="card border-0 box-shadow">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <h5 class="text-uppercase">{{ trans('labels.basic_info') }}</h5>
                                    </div>
                                    <form action="{{ URL::to('admin/add') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label class="form-label">{{ trans('labels.currency_symbol') }}<span
                                                        class="text-danger"> * </span></label>
                                                <input type="text" class="form-control" name="currency"
                                                    value="{{ $settingdata->currency }}"
                                                    placeholder="{{ trans('labels.currency_symbol') }}" required>
                                                @error('currency')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror

                                            </div>
                                            <div class="form-group col-sm-4">
                                                <p class="form-label">{{ trans('labels.currency_position') }}</p>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input form-check-input-secondary"
                                                        type="radio" name="currency_position" id="radio"
                                                        value="1" checked
                                                        {{ $settingdata->currency_position == '1' ? 'checked' : '' }} />
                                                    <label for="radio"
                                                        class="form-check-label">{{ trans('labels.left') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input form-check-input-secondary"
                                                        type="radio" name="currency_position" id="radio1"
                                                        value="2"
                                                        {{ $settingdata->currency_position == '2' ? 'checked' : '' }} />
                                                    <label for="radio1"
                                                        class="form-check-label">{{ trans('labels.right') }}</label>
                                                </div>

                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label class="form-label"
                                                    for="">{{ trans('labels.maintenance_mode') }} </label>
                                                <input id="maintenance_mode-switch" type="checkbox" class="checkbox-switch"
                                                    name="maintenance_mode" value="1"
                                                    {{ $settingdata->maintenance_mode == 1 ? 'checked' : '' }}>
                                                <label for="maintenance_mode-switch" class="switch">
                                                    <span
                                                        class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                            class="switch__circle-inner"></span></span>
                                                    <span
                                                        class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                    <span
                                                        class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                </label>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">{{ trans('labels.time_zone') }}</label>
                                            <select class="form-select" name="timezone">
                                                <option {{ @$settingdata->timezone == 'Pacific/Midway' ? 'selected' : '' }}
                                                    value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa

                                                </option>
                                                <option {{ @$settingdata->timezone == 'America/Adak' ? 'selected' : '' }}
                                                    value="America/Adak">(GMT-10:00) Hawaii-Aleutian</option>
                                                <option {{ @$settingdata->timezone == 'Etc/GMT+10' ? 'selected' : '' }}
                                                    value="Etc/GMT+10">(GMT-10:00) Hawaii</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Pacific/Marquesas' ? 'selected' : '' }}
                                                    value="Pacific/Marquesas">(GMT-09:30) Marquesas Islands

                                                </option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Pacific/Gambier' ? 'selected' : '' }}
                                                    value="Pacific/Gambier">(GMT-09:00) Gambier Islands</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'America/Anchorage' ? 'selected' : '' }}
                                                    value="America/Anchorage">(GMT-09:00) Alaska</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'America/Ensenada' ? 'selected' : '' }}
                                                    value="America/Ensenada">(GMT-08:00) Tijuana, Baja California

                                                </option>
                                                <option {{ @$settingdata->timezone == 'Etc/GMT+8' ? 'selected' : '' }}
                                                    value="Etc/GMT+8">(GMT-08:00) Pitcairn Islands</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'America/Los_Angeles' ? 'selected' : '' }}
                                                    value="America/Los_Angeles">(GMT-08:00) Pacific Time (US &amp;
                                                    Canada)
                                                </option>
                                                <option {{ @$settingdata->timezone == 'America/Denver' ? 'selected' : '' }}
                                                    value="America/Denver">(GMT-07:00) Mountain Time (US &amp;
                                                    Canada)
                                                </option>
                                                <option
                                                    {{ @$settingdata->timezone == 'America/Chihuahua' ? 'selected' : '' }}
                                                    value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz,
                                                    Mazatlan

                                                </option>
                                                <option
                                                    {{ @$settingdata->timezone == 'America/Dawson_Creek' ? 'selected' : '' }}
                                                    value="America/Dawson_Creek">(GMT-07:00) Arizona</option>
                                                <option {{ @$settingdata->timezone == 'America/Belize' ? 'selected' : '' }}
                                                    value="America/Belize">(GMT-06:00) Saskatchewan, Central

                                                    America

                                                </option>
                                                <option {{ @$settingdata->timezone == 'America/Cancun' ? 'selected' : '' }}
                                                    value="America/Cancun">(GMT-06:00) Guadalajara, Mexico City,
                                                    Monterrey

                                                </option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Chile/EasterIsland' ? 'selected' : '' }}
                                                    value="Chile/EasterIsland">(GMT-06:00) Easter Island</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'America/Chicago' ? 'selected' : '' }}
                                                    value="America/Chicago">(GMT-06:00) Central Time (US &amp;
                                                    Canada)
                                                </option>
                                                <option
                                                    {{ @$settingdata->timezone == 'America/New_York' ? 'selected' : '' }}
                                                    value="America/New_York">(GMT-05:00) Eastern Time (US &amp;
                                                    Canada)
                                                </option>
                                                <option {{ @$settingdata->timezone == 'America/Havana' ? 'selected' : '' }}
                                                    value="America/Havana">(GMT-05:00) Cuba</option>
                                                <option {{ @$settingdata->timezone == 'America/Bogota' ? 'selected' : '' }}
                                                    value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio

                                                    Branco

                                                </option>
                                                <option
                                                    {{ @$settingdata->timezone == 'America/Caracas' ? 'selected' : '' }}
                                                    value="America/Caracas">(GMT-04:30) Caracas</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'America/Santiago' ? 'selected' : '' }}
                                                    value="America/Santiago">(GMT-04:00) Santiago</option>
                                                <option {{ @$settingdata->timezone == 'America/La_Paz' ? 'selected' : '' }}
                                                    value="America/La_Paz">(GMT-04:00) La Paz</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Atlantic/Stanley' ? 'selected' : '' }}
                                                    value="Atlantic/Stanley">(GMT-04:00) Faukland Islands</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'America/Campo_Grande' ? 'selected' : '' }}
                                                    value="America/Campo_Grande">(GMT-04:00) Brazil</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'America/Goose_Bay' ? 'selected' : '' }}
                                                    value="America/Goose_Bay">(GMT-04:00) Atlantic Time (Goose Bay)
                                                </option>
                                                <option
                                                    {{ @$settingdata->timezone == 'America/Glace_Bay' ? 'selected' : '' }}
                                                    value="America/Glace_Bay">(GMT-04:00) Atlantic Time (Canada)
                                                </option>
                                                <option
                                                    {{ @$settingdata->timezone == 'America/St_Johns' ? 'selected' : '' }}
                                                    value="America/St_Johns">(GMT-03:30) Newfoundland</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'America/Araguaina' ? 'selected' : '' }}
                                                    value="America/Araguaina">(GMT-03:00) UTC-3</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'America/Montevideo' ? 'selected' : '' }}
                                                    value="America/Montevideo">(GMT-03:00) Montevideo</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'America/Miquelon' ? 'selected' : '' }}
                                                    value="America/Miquelon">(GMT-03:00) Miquelon, St. Pierre

                                                </option>
                                                <option
                                                    {{ @$settingdata->timezone == 'America/Godthab' ? 'selected' : '' }}
                                                    value="America/Godthab">(GMT-03:00) Greenland</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'America/Argentina' ? 'selected' : '' }}
                                                    value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires

                                                </option>
                                                <option
                                                    {{ @$settingdata->timezone == 'America/Sao_Paulo' ? 'selected' : '' }}
                                                    value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'America/Noronha' ? 'selected' : '' }}
                                                    value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Atlantic/Cape_Verde' ? 'selected' : '' }}
                                                    value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Atlantic/Azores' ? 'selected' : '' }}
                                                    value="Atlantic/Azores">(GMT-01:00) Azores</option>
                                                <option {{ @$settingdata->timezone == 'Europe/Belfast' ? 'selected' : '' }}
                                                    value="Europe/Belfast">(GMT) Greenwich Mean Time : Belfast

                                                </option>
                                                <option {{ @$settingdata->timezone == 'Europe/Dublin' ? 'selected' : '' }}
                                                    value="Europe/Dublin">(GMT) Greenwich Mean Time : Dublin

                                                </option>
                                                <option {{ @$settingdata->timezone == 'Europe/Lisbon' ? 'selected' : '' }}
                                                    value="Europe/Lisbon">(GMT) Greenwich Mean Time : Lisbon

                                                </option>
                                                <option {{ @$settingdata->timezone == 'Europe/London' ? 'selected' : '' }}
                                                    value="Europe/London">(GMT) Greenwich Mean Time : London

                                                </option>
                                                <option {{ @$settingdata->timezone == 'Africa/Abidjan' ? 'selected' : '' }}
                                                    value="Africa/Abidjan">(GMT) Monrovia, Reykjavik</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Europe/Amsterdam' ? 'selected' : '' }}
                                                    value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern,
                                                    Rome,
                                                    Stockholm, Vienna</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Europe/Belgrade' ? 'selected' : '' }}
                                                    value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava,
                                                    Budapest,
                                                    Ljubljana, Prague</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Europe/Brussels' ? 'selected' : '' }}
                                                    value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen,
                                                    Madrid, Paris

                                                </option>
                                                <option {{ @$settingdata->timezone == 'Africa/Algiers' ? 'selected' : '' }}
                                                    value="Africa/Algiers">(GMT+01:00) West Central Africa</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Africa/Windhoek' ? 'selected' : '' }}
                                                    value="Africa/Windhoek">(GMT+01:00) Windhoek</option>
                                                <option {{ @$settingdata->timezone == 'Asia/Beirut' ? 'selected' : '' }}
                                                    value="Asia/Beirut">(GMT+02:00) Beirut</option>
                                                <option {{ @$settingdata->timezone == 'Africa/Cairo' ? 'selected' : '' }}
                                                    value="Africa/Cairo">(GMT+02:00) Cairo</option>
                                                <option {{ @$settingdata->timezone == 'Asia/Gaza' ? 'selected' : '' }}
                                                    value="Asia/Gaza">(GMT+02:00) Gaza</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Africa/Blantyre' ? 'selected' : '' }}
                                                    value="Africa/Blantyre">(GMT+02:00) Harare, Pretoria</option>
                                                <option {{ @$settingdata->timezone == 'Asia/Jerusalem' ? 'selected' : '' }}
                                                    value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>
                                                <option {{ @$settingdata->timezone == 'Europe/Minsk' ? 'selected' : '' }}
                                                    value="Europe/Minsk">(GMT+02:00) Minsk</option>
                                                <option {{ @$settingdata->timezone == 'Asia/Damascus' ? 'selected' : '' }}
                                                    value="Asia/Damascus">(GMT+02:00) Syria</option>
                                                <option {{ @$settingdata->timezone == 'Europe/Moscow' ? 'selected' : '' }}
                                                    value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg,
                                                    Volgograd

                                                </option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Africa/Addis_Ababa' ? 'selected' : '' }}
                                                    value="Africa/Addis_Ababa">(GMT+03:00) Nairobi</option>
                                                <option {{ @$settingdata->timezone == 'Asia/Tehran' ? 'selected' : '' }}
                                                    value="Asia/Tehran">(GMT+03:30) Tehran</option>
                                                <option {{ @$settingdata->timezone == 'Asia/Dubai' ? 'selected' : '' }}
                                                    value="Asia/Dubai">(GMT+04:00) Abu Dhabi, Muscat</option>
                                                <option {{ @$settingdata->timezone == 'Asia/Yerevan' ? 'selected' : '' }}
                                                    value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
                                                <option {{ @$settingdata->timezone == 'Asia/Kabul' ? 'selected' : '' }}
                                                    value="Asia/Kabul">(GMT+04:30) Kabul</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Asia/Yekaterinburg' ? 'selected' : '' }}
                                                    value="Asia/Yekaterinburg">(GMT+05:00) Ekaterinburg</option>
                                                <option value="Asia/Tashkent"
                                                    {{ @$settingdata->timezone == 'Asia/Tashkent' ? 'selected' : '' }}>
                                                    (GMT+05:00) Tashkent</option>
                                                <option {{ @$settingdata->timezone == 'Asia/Kolkata' ? 'selected' : '' }}
                                                    value="Asia/Kolkata">
                                                    (GMT+05:30) Chennai, Kolkata,
                                                    Mumbai, New Delhi</option>
                                                <option {{ @$settingdata->timezone == 'Asia/Katmandu' ? 'selected' : '' }}
                                                    value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
                                                <option {{ @$settingdata->timezone == 'Asia/Dhaka' ? 'selected' : '' }}
                                                    value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Asia/Novosibirsk' ? 'selected' : '' }}
                                                    value="Asia/Novosibirsk">(GMT+06:00) Novosibirsk</option>
                                                <option {{ @$settingdata->timezone == 'Asia/Rangoon' ? 'selected' : '' }}
                                                    value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
                                                <option {{ @$settingdata->timezone == 'Asia/Bangkok' ? 'selected' : '' }}
                                                    value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta

                                                </option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Asia/Kuala_Lumpur' ? 'selected' : '' }}
                                                    value="Asia/Kuala_Lumpur">(GMT+08:00) Kuala Lumpur</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Asia/Krasnoyarsk' ? 'selected' : '' }}
                                                    value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
                                                <option {{ @$settingdata->timezone == 'Asia/Hong_Kong' ? 'selected' : '' }}
                                                    value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong

                                                    Kong,
                                                    Urumqi</option>
                                                <option {{ @$settingdata->timezone == 'Asia/Irkutsk' ? 'selected' : '' }}
                                                    value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Australia/Perth' ? 'selected' : '' }}
                                                    value="Australia/Perth">(GMT+08:00) Perth</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Australia/Eucla' ? 'selected' : '' }}
                                                    value="Australia/Eucla">(GMT+08:45) Eucla</option>
                                                <option {{ @$settingdata->timezone == 'Asia/Tokyo' ? 'selected' : '' }}
                                                    value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
                                                <option {{ @$settingdata->timezone == 'Asia/Seoul' ? 'selected' : '' }}
                                                    value="Asia/Seoul">(GMT+09:00) Seoul</option>
                                                <option {{ @$settingdata->timezone == 'Asia/Yakutsk' ? 'selected' : '' }}
                                                    value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Australia/Adelaide' ? 'selected' : '' }}
                                                    value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Australia/Darwin' ? 'selected' : '' }}
                                                    value="Australia/Darwin">(GMT+09:30) Darwin</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Australia/Brisbane' ? 'selected' : '' }}
                                                    value="Australia/Brisbane">(GMT+10:00) Brisbane</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Australia/Hobart' ? 'selected' : '' }}
                                                    value="Australia/Hobart">(GMT+10:00) Hobart</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Asia/Vladivostok' ? 'selected' : '' }}
                                                    value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Australia/Lord_Howe' ? 'selected' : '' }}
                                                    value="Australia/Lord_Howe">(GMT+10:30) Lord Howe Island

                                                </option>
                                                <option {{ @$settingdata->timezone == 'Etc/GMT-11' ? 'selected' : '' }}
                                                    value="Etc/GMT-11">(GMT+11:00) Solomon Is., New Caledonia

                                                </option>
                                                <option {{ @$settingdata->timezone == 'Asia/Magadan' ? 'selected' : '' }}
                                                    value="Asia/Magadan">(GMT+11:00) Magadan</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Pacific/Norfolk' ? 'selected' : '' }}
                                                    value="Pacific/Norfolk">(GMT+11:30) Norfolk Island</option>
                                                <option {{ @$settingdata->timezone == 'Asia/Anadyr' ? 'selected' : '' }}
                                                    value="Asia/Anadyr">(GMT+12:00) Anadyr, Kamchatka</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Pacific/Auckland' ? 'selected' : '' }}
                                                    value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington

                                                </option>
                                                <option {{ @$settingdata->timezone == 'Etc/GMT-12' ? 'selected' : '' }}
                                                    value="Etc/GMT-12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.
                                                </option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Pacific/Chatham' ? 'selected' : '' }}
                                                    value="Pacific/Chatham">(GMT+12:45) Chatham Islands</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Pacific/Tongatapu' ? 'selected' : '' }}
                                                    value="Pacific/Tongatapu">(GMT+13:00) Nuku'alofa</option>
                                                <option
                                                    {{ @$settingdata->timezone == 'Pacific/Kiritimati' ? 'selected' : '' }}
                                                    value="Pacific/Kiritimati">(GMT+14:00) Kiritimati</option>
                                            </select>
                                            @error('timezone')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror

                                        </div>
                                        @if (Auth::user()->type == 1)
                                            @if (App\Models\SystemAddons::where('unique_identifier', 'vendor_app')->first() != null &&
                                                    App\Models\SystemAddons::where('unique_identifier', 'vendor_app')->first()->activated == 1)
                                                <div class="form-group">
                                                    <label
                                                        class="form-label">{{ trans('labels.firebase_server_key') }}</label>
                                                    @if (env('Environment') == 'sendbox')
                                                        <span
                                                            class="badge badge bg-danger ms-2 mb-0">{{ trans('labels.addon') }}</span>
                                                    @endif
                                                    <input type="text" class="form-control" name="firebase_server_key"
                                                        value="{{ @$settingdata->firebase }}"
                                                        placeholder="{{ trans('labels.firebase_server_key') }}" required>
                                                    @error('firebase_server_key')
                                                        <small class="text-danger">{{ $message }}</small> <br>
                                                    @enderror
                                                </div>
                                            @endif
                                        @endif
                                        <div class="form-group">
                                            <label class="form-label">{{ trans('labels.web_title') }}<span
                                                    class="text-danger">
                                                    * </span></label>
                                            <input type="text" class="form-control" name="web_title"
                                                value="{{ $settingdata->web_title }}"
                                                placeholder="{{ trans('labels.web_title') }}" required>
                                            @error('web_title')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror

                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">{{ trans('labels.copyright') }}<span
                                                    class="text-danger">
                                                    * </span></label>
                                            <input type="text" class="form-control" name="copyright"
                                                value="{{ $settingdata->copyright }}"
                                                placeholder="{{ trans('labels.copyright') }}" required>
                                            @error('copyright')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror

                                        </div>



                                        @if (Auth::user()->type == 2)
                                            @if (App\Models\SystemAddons::where('unique_identifier', 'unique_slug')->first() != null &&
                                                    App\Models\SystemAddons::where('unique_identifier', 'unique_slug')->first()->activated == 1)
                                                <div class="form-group">
                                                    <label class="form-label">{{ trans('labels.personlized_link') }}<span
                                                            class="text-danger"> * </span></label>
                                                    @if (env('Environment') == 'sendbox')
                                                        <span
                                                            class="badge badge bg-danger ms-2 mb-0">{{ trans('labels.addon') }}</span>
                                                    @endif
                                                    <div class="input-group">
                                                        <span class="input-group-text">{{ URL::to('/') }}</span>
                                                        <input type="text" class="form-control" id="slug"
                                                            name="slug" value="{{ Auth::user()->slug }}">
                                                    </div>
                                                    @error('slug')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror

                                                </div>
                                            @endif
                                        @endif

                                        @if (Auth::user()->type == 2)
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">{{ trans('labels.contact_email') }}<span
                                                            class="text-danger"> * </span></label>
                                                    <input type="email" class="form-control" name="contact_email"
                                                        value="{{ @$settingdata->email }}"
                                                        placeholder="{{ trans('labels.contact_email') }}" required>
                                                    @error('email')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">{{ trans('labels.contact_mobile') }}<span
                                                            class="text-danger"> * </span></label>
                                                    <input type="number" class="form-control" name="contact_mobile"
                                                        value="{{ @$settingdata->mobile }}"
                                                        placeholder="{{ trans('labels.contact_mobile') }}" required>
                                                    @error('mobile')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">{{ trans('labels.address') }}<span
                                                            class="text-danger"> * </span></label>
                                                    <textarea class="form-control" name="address" rows="3" placeholder="{{ trans('labels.address') }}" required>{{ $settingdata->address }}</textarea>
                                                    @error('address')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror

                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">{{ trans('labels.facebook_link') }}</label>
                                                    <input type="text" class="form-control" name="facebook_link"
                                                        value="{{ @$settingdata->facebook_link }}"
                                                        placeholder="{{ trans('labels.facebook_link') }}">
                                                    @error('facebook_link')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">{{ trans('labels.twitter_link') }}</label>
                                                    <input type="text" class="form-control" name="twitter_link"
                                                        value="{{ @$settingdata->twitter_link }}"
                                                        placeholder="{{ trans('labels.twitter_link') }}">
                                                    @error('twitter_link')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label
                                                        class="form-label">{{ trans('labels.instagram_link') }}</label>
                                                    <input type="text" class="form-control" name="instagram_link"
                                                        value="{{ @$settingdata->instagram_link }}"
                                                        placeholder="{{ trans('labels.instagram_link') }}">
                                                    @error('instagram_link')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">{{ trans('labels.linkedin_link') }}</label>
                                                    <input type="text" class="form-control" name="linkedin_link"
                                                        value="{{ @$settingdata->linkedin_link }}"
                                                        placeholder="{{ trans('labels.linkedin_link') }}">
                                                    @error('linkedin_link')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.footer_description') }}<span
                                                        class="text-danger"> * </span></label>
                                                <textarea class="form-control" name="footer_description" rows="3"
                                                    placeholder="{{ trans('labels.footer_description') }}" required>{{ $settingdata->footer_description }}</textarea>
                                                @error('footer_description')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror

                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="row justify-content-between">
                                                        <label class="col-auto col-form-label"
                                                            for="">{{ trans('labels.footer_features') }} <span
                                                                class="" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Ex. <i class='fa-solid fa-truck-fast'></i> Visit https://fontawesome.com/ for more info">
                                                                <i class="fa-solid fa-circle-info"></i> </span></label>
                                                        @if (count($getfooterfeatures) > 0)
                                                            <span class="col-auto"><button class="btn btn-sm btn-primary"
                                                                    type="button"
                                                                    onclick="add_features('{{ trans('labels.icon') }}','{{ trans('labels.title') }}','{{ trans('labels.description') }}')">
                                                                    {{ trans('labels.add_new') }}
                                                                    {{ trans('labels.footer_features') }} <i
                                                                        class="fa-sharp fa-solid fa-plus"></i></button></span>
                                                        @endif

                                                    </div>
                                                    @forelse ($getfooterfeatures as $key => $features)
                                                        <div class="row">
                                                            <input type="hidden" name="edit_icon_key[]"
                                                                value="{{ $features->id }}">
                                                            <div class="col-md-3 form-group">
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control feature_required {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"
                                                                        onkeyup="show_feature_icon(this)"
                                                                        name="edi_feature_icon[{{ $features->id }}]"
                                                                        placeholder="{{ trans('labels.icon') }}"
                                                                        value="{{ $features->icon }}" required>
                                                                    <p
                                                                        class="input-group-text {{ session()->get('direction') == 2 ? 'input-group-icon-rtl' : '' }}">
                                                                        {!! $features->icon !!}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 form-group">
                                                                <input type="text" class="form-control"
                                                                    name="edi_feature_title[{{ $features->id }}]"
                                                                    placeholder="{{ trans('labels.title') }}"
                                                                    value="{{ $features->title }}" required>
                                                            </div>
                                                            <div class="col-md-5 form-group">
                                                                <input type="text" class="form-control"
                                                                    name="edi_feature_description[{{ $features->id }}]"
                                                                    placeholder="{{ trans('labels.description') }}"
                                                                    value="{{ $features->description }}" required>
                                                            </div>
                                                            <div class="col-md-1 form-group">
                                                                <button class="btn btn-danger" type="button"
                                                                    onclick="statusupdate('{{ URL::to('admin/settings/delete-feature-' . $features->id) }}')">
                                                                    <i class="fa fa-trash"></i> </button>
                                                            </div>
                                                        </div>
                                                    @empty

                                                        <div class="row">
                                                            <div class="col-md-3 form-group">
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control feature_required"
                                                                        onkeyup="show_feature_icon(this)"
                                                                        name="feature_icon[]"
                                                                        placeholder="{{ trans('labels.icon') }}">
                                                                    <p class="input-group-text"></p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 form-group">
                                                                <input type="text"
                                                                    class="form-control feature_required"
                                                                    name="feature_title[]"
                                                                    placeholder="{{ trans('labels.title') }}" required>
                                                            </div>
                                                            <div class="col-md-5 form-group">
                                                                <input type="text"
                                                                    class="form-control feature_required"
                                                                    name="feature_description[]"
                                                                    placeholder="{{ trans('labels.description') }}"
                                                                    required>
                                                            </div>
                                                            <div class="col-md-1 form-group">
                                                                <button class="btn btn-info" type="button"
                                                                    onclick="add_features('{{ trans('labels.icon') }}','{{ trans('labels.title') }}','{{ trans('labels.description') }}')">
                                                                    <i class="fa-sharp fa-solid fa-plus"></i> </button>
                                                            </div>
                                                        </div>
                                                    @endforelse

                                                    <span class="extra_footer_features"></span>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">{{ trans('labels.logo') }} (250 x 250)
                                                </label>
                                                <input type="file" class="form-control" name="logo">
                                                @error('logo')
                                                    <small class="text-danger">{{ $message }}</small> <br>
                                                @enderror

                                                <img class="img-fluid rounded hw-70 mt-1"
                                                    src="{{ helper::image_path($settingdata->logo) }}" alt="">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">{{ trans('labels.favicon') }} (16 x 16)
                                                </label>
                                                <input type="file" class="form-control" name="favicon">
                                                @error('favicon')
                                                    <small class="text-danger">{{ $message }}</small> <br>
                                                @enderror

                                                <img class="img-fluid rounded hw-70 mt-1"
                                                    src="{{ helper::image_path($settingdata->favicon) }}"
                                                    alt="">
                                            </div>
                                        </div>
                                        @if (Auth::user()->type == 2)
                                            <div class="row">
                                                <div class="form-group col-sm-6">
                                                    <label
                                                        class="form-label">{{ trans('labels.landing_page_cover_image') }}
                                                        (650 x 300)
                                                    </label>
                                                    <input type="file" class="form-control"
                                                        name="landin_page_cover_image">
                                                    @error('landin_page_cover_image')
                                                        <small class="text-danger">{{ $message }}</small> <br>
                                                    @enderror

                                                    <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                        src="{{ helper::image_path($settingdata->cover_image) }}"
                                                        alt="">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label class="form-label">{{ trans('labels.auth_page_image') }}
                                                        (650 x 300) <a href="{{URL::to('/'. Auth::user()->slug.'/login')}}" target="_blank" class="ms-2"><i class="fa-solid fa-eye"></i></a>
                                                    </label>
                                                    <input type="file" class="form-control" name="auth_page_image">
                                                    @error('auth_page_image')
                                                        <small class="text-danger">{{ $message }}</small> <br>
                                                    @enderror

                                                    <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                        src="{{ helper::image_path($settingdata->auth_image) }}"
                                                        alt="">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label class="form-label">{{ trans('labels.listing_page_image') }}
                                                        (650 x 300) <a href="{{URL::to('/'. Auth::user()->slug.'/listing')}}" target="_blank" class="ms-2"><i class="fa-solid fa-eye"></i></a>
                                                    </label>
                                                    <input type="file" class="form-control" name="listing_page_image">
                                                    @error('listing_page_image')
                                                        <small class="text-danger">{{ $message }}</small> <br>
                                                    @enderror

                                                    <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                        src="{{ helper::image_path($settingdata->listing_page_image) }}"
                                                        alt="">
                                                </div>
                                                @if (App\Models\SystemAddons::where('unique_identifier', 'notification')->first() != null &&
                                                App\Models\SystemAddons::where('unique_identifier', 'notification')->first()->activated == 1)
                                            <div class="form-group col-md-6">
                                                <label
                                                    class="form-label">{{ trans('labels.notification_sound') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2 mb-0">{{ trans('labels.addon') }}</span>
                                                @endif
                                                <input type="file" class="form-control"
                                                    name="notification_sound">
                                                @error('notification_sound')
                                                    <small class="text-danger">{{ $message }}</small><br>
                                                @enderror
                                                @if (!empty($settingdata->notification_sound) && $settingdata->notification_sound != null)
                                                    <audio controls class="mt-1">
                                                        <source
                                                            src="{{ url(env('ASSETPATHURL') . 'admin-assets/notification/' . $settingdata->notification_sound) }}"
                                                            type="audio/mpeg">
                                                    </audio>
                                                @endif
                                            </div>
                                        @endif
                                            </div>
                                        @endif
                                        <div class="text-end">
                                            <button
                                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                                class="btn btn-secondary">{{ trans('labels.save') }}</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (Auth::user()->type == 2)
                    <div id="themesettings">
                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <h5 class="text-uppercase">{{ trans('labels.theme_settings') }}</h5>
                                        </div>
                                        <form method="POST" action="{{ URL::to('admin/themeupdate') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">

                                                <div class="form-group col-sm-6">
                                                    <label class="form-label">{{ trans('labels.primary_color') }}</label>
                                                    <input type="color"
                                                        class="form-control form-control-color w-100 border-0"
                                                        name="primary_color" value="{{ $settingdata->primary_color }}">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label
                                                        class="form-label">{{ trans('labels.secondary_color') }}</label>
                                                    <input type="color"
                                                        class="form-control form-control-color w-100 border-0"
                                                        name="secondary_color"
                                                        value="{{ $settingdata->secondary_color }}">
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <button
                                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                                    class="btn btn-secondary">{{ trans('labels.save') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif --}}
                <div id="editprofile">
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="card border-0 box-shadow">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <h5 class="text-uppercase">{{ trans('labels.edit_profile') }}</h5>
                                    </div>
                                    <form method="POST" action="{{ URL::to('/admin/edit-profile') }}"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">{{ trans('labels.name') }}<span
                                                        class="text-danger"> * </span></label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ Auth::user()->name }}"
                                                    placeholder="{{ trans('labels.name') }}" required>
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">{{ trans('labels.email') }}<span
                                                        class="text-danger"> * </span></label>
                                                <input type="email" class="form-control" name="email"
                                                    value="{{ Auth::user()->email }}"
                                                    placeholder="{{ trans('labels.email') }}" required>
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label"
                                                    for="mobile">{{ trans('labels.mobile') }}<span
                                                        class="text-danger"> * </span></label>
                                                <input type="number" class="form-control" name="mobile" id="mobile"
                                                    value="{{ Auth::user()->mobile }}"
                                                    placeholder="{{ trans('labels.mobile') }}" required>
                                                @error('mobile')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">{{ trans('labels.image') }}
                                                    (250 x 250)</label>
                                                <input type="file" class="form-control" name="profile">
                                                @error('profile')
                                                    <span class="text-danger">{{ $message }}</span> <br>
                                                @enderror

                                                <img class="img-fluid rounded hw-70 mt-1"
                                                    src="{{ helper::image_Path(Auth::user()->image) }}" alt="">
                                            </div>
                                            {{-- @if (Auth::user()->type == 2)
                                                <div class="form-group col-md-6">
                                                    <label for="country"
                                                        class="form-label">{{ trans('labels.country') }}<span
                                                            class="text-danger"> * </span></label>
                                                    <select name="country" class="form-select" id="country" required>
                                                        <option value="">{{ trans('labels.select') }}</option>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}"
                                                                {{ $country->id == Auth::user()->country_id ? 'selected' : '' }}>
                                                                {{ $country->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="city"
                                                        class="form-label">{{ trans('labels.city') }}<span
                                                            class="text-danger"> * </span></label>
                                                    <select name="city" class="form-select" id="city" required>
                                                        <option value="">{{ trans('labels.select') }}</option>
                                                    </select>

                                                </div>
                                            @endif --}}

                                        </div>
                                        <div class="text-end">
                                            <button
                                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                                class="btn btn-secondary">{{ trans('labels.save') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="changepasssword">
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="card border-0 box-shadow">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <h5 class="text-uppercase">{{ trans('labels.change_password') }}</h5>
                                    </div>
                                    <form action="{{ Url::to('/admin/change-password') }}" method="POST">
                                        @csrf

                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <label class="form-label">{{ trans('labels.current_password') }}<span
                                                        class="text-danger"> * </span></label>
                                                <input type="password" class="form-control" name="current_password"
                                                    value="{{ old('current_password') }}"
                                                    placeholder="{{ trans('labels.current_password') }}" required>
                                                @error('current_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">{{ trans('labels.new_password') }}<span
                                                        class="text-danger"> * </span></label>
                                                <input type="password" class="form-control" name="new_password"
                                                    value="{{ old('new_password') }}"
                                                    placeholder="{{ trans('labels.new_password') }}" required>
                                                @error('new_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">{{ trans('labels.confirm_password') }}<span
                                                        class="text-danger"> * </span></label>
                                                <input type="password" class="form-control" name="confirm_password"
                                                    value="{{ old('confirm_password') }}"
                                                    placeholder="{{ trans('labels.confirm_password') }}" required>
                                                @error('confirm_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button
                                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                                class="btn btn-secondary">{{ trans('labels.save') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="seo">
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="card border-0 box-shadow">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <h5 class="text-uppercase">{{ trans('labels.seo') }}</h5>
                                    </div>
                                    <form action="{{ Url::to('/admin/og_image') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.meta_title') }}<span
                                                        class="text-danger"> * </span></label>
                                                <input type="text" class="form-control" name="meta_title"
                                                    value="{{ $settingdata->meta_title }}"
                                                    placeholder="{{ trans('labels.meta_title') }}" required>
                                                @error('meta_title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.meta_description') }}<span
                                                        class="text-danger"> * </span></label>
                                                <textarea class="form-control" name="meta_description" rows="3"
                                                    placeholder="{{ trans('labels.meta_description') }}" required>{{ $settingdata->meta_description }}</textarea>
                                                @error('meta_description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.og_image') }}
                                                    (1200 x 630) <span class="text-danger"> * </span></label>
                                                <input type="file" class="form-control" name="og_image">
                                                <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                    src="{{ helper::image_Path($settingdata->og_image) }}"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button
                                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                                class="btn btn-secondary">{{ trans('labels.save') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- @if (Auth::user()->type == 2)
                    @if (App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first() != null &&
                            App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first()->activated == 1)
                        <div id="whatsapp">
                            <div class="row mb-5">
                                <div class="col-12">
                                    <div class="card border-0 box-shadow">
                                        <div class="card-body">
                                            <div class="px-3">
                                                <form action="{{ URL::to('admin/whatsappmessage') }}" method="POST">
                                                    @csrf

                                                    <div class="form-body">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <h5 class="text-uppercase">
                                                                {{ trans('labels.whatsapp_message_settings') }}
                                                            </h5>
                                                        </div>
                                                        <div class="card-block">
                                                            <div class="row d-flex mb-2">
                                                                <div class="col">
                                                                    <h5 class="text-center">
                                                                        {{ trans('labels.booking_variable') }}
                                                                    </h5>
                                                                    <hr class="my-2">
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.booking_no') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{order_no}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.product') }}
                                                                        :
                                                                        <small
                                                                            class="pull-right text-primary">{product}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.subtotal') }}
                                                                        :
                                                                        <small
                                                                            class="pull-right text-primary">{sub_total}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">{{ trans('labels.total') }}
                                                                        {{ trans('labels.tax') }} : <small
                                                                            class="pull-right text-primary">{total_tax}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.offer_code') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{offer_code}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.discount') }}
                                                                        {{ trans('labels.amount') }} : <small
                                                                            class="pull-right text-primary">{discount_amount}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.grand_total') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{grand_total}</small>
                                                                    </p>

                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.payment_type') }}:
                                                                        <small
                                                                            class="pull-right text-primary">{payment_type}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.track_booking_url') }}
                                                                        : <small
                                                                            class="pull-right text-primary">{track_order_url}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.website_url') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{website_url}</small>
                                                                    </p>
                                                                </div>
                                                                <div class="col">
                                                                    <h5 class="text-center">
                                                                        {{ trans('labels.customer_variable') }}
                                                                    </h5>
                                                                    <hr class="my-2">
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.customer_name') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{customer_name}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.customer_mobile') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{customer_mobile}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.customer_email') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{customer_email}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.address') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{address}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.pickup_date') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{pickup_date}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.pickup_time') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{pickup_time}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.pickup_location') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{pickup_location}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.dropoff_date') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{dropoff_date}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.dropoff_time') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{dropoff_time}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.dropoff_location') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{dropoff_location}</small>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label class="col-md-2 label-control"
                                                                for="whatsapp_message">{{ trans('labels.whatsapp_message') }}
                                                                :<span class="text-danger"> *</span></label>
                                                            <div class="col-md-10">
                                                                <textarea class="form-control" required="required" name="whatsapp_message" cols="50" rows="10"
                                                                    id="whatsapp_message">{{ $settingdata->whatsapp_message }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label class="col-md-2 label-control"
                                                                for="contact">{{ trans('labels.whatsapp_number') }}:<span
                                                                    class="text-danger"> *</span></label>
                                                            <div class="col-md-10">
                                                                <input type="number" name="contact" class="form-control"
                                                                    placeholder="{{ trans('labels.whatsapp_number') }}"
                                                                    value="{{ $settingdata->whatsapp_number }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-end">
                                                        <button
                                                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                                            class="btn btn-secondary">{{ trans('labels.save') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (App\Models\SystemAddons::where('unique_identifier', 'telegram_message')->first() != null &&
                            App\Models\SystemAddons::where('unique_identifier', 'telegram_message')->first()->activated == 1)
                        <div id="telegram">
                            <div class="row mb-5">
                                <div class="col-12">
                                    <div class="card border-0 box-shadow">
                                        <div class="card-body">
                                            <div class="px-3">
                                                <form action="{{ URL::to('admin/telegrammessage') }}" method="POST">
                                                    @csrf

                                                    <div class="form-body">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <h5 class="text-uppercase">
                                                                {{ trans('labels.telegram_message_settings') }}
                                                            </h5>
                                                        </div>
                                                        <div class="card-block">
                                                            <div class="row d-flex mb-2">
                                                                <div class="col">
                                                                    <h5 class="text-center">
                                                                        {{ trans('labels.booking_variable') }}
                                                                    </h5>
                                                                    <hr class="my-2">
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.booking_no') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{order_no}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.product') }}
                                                                        :
                                                                        <small
                                                                            class="pull-right text-primary">{product}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.subtotal') }}
                                                                        :
                                                                        <small
                                                                            class="pull-right text-primary">{sub_total}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">{{ trans('labels.total') }}
                                                                        {{ trans('labels.tax') }} : <small
                                                                            class="pull-right text-primary">{total_tax}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.offer_code') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{offer_code}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.discount') }}
                                                                        {{ trans('labels.amount') }} : <small
                                                                            class="pull-right text-primary">{discount_amount}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.grand_total') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{grand_total}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.payment_type') }}:
                                                                        <small
                                                                            class="pull-right text-primary">{payment_type}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.track_booking_url') }}
                                                                        : <small
                                                                            class="pull-right text-primary">{track_order_url}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.website_url') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{website_url}</small>
                                                                    </p>
                                                                </div>
                                                                <div class="col">
                                                                    <h5 class="text-center">
                                                                        {{ trans('labels.customer_variable') }}
                                                                    </h5>
                                                                    <hr class="my-2">
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.customer_name') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{customer_name}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.customer_mobile') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{customer_mobile}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.customer_email') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{customer_email}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.address') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{address}</small>
                                                                    </p>

                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.pickup_date') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{pickup_date}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.pickup_time') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{pickup_time}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.pickup_location') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{pickup_location}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.dropoff_date') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{dropoff_date}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.dropoff_time') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{dropoff_time}</small>
                                                                    </p>
                                                                    <p class="mb-1 text-dark">
                                                                        {{ trans('labels.dropoff_location') }} :
                                                                        <small
                                                                            class="pull-right text-primary">{dropoff_location}</small>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label class="col-md-2 label-control"
                                                                for="telegram_message">{{ trans('labels.telegram_message') }}
                                                                :<span class="text-danger"> *</span></label>
                                                            <div class="col-md-10">
                                                                <textarea class="form-control" required="required" name="telegram_message" cols="50" rows="10"
                                                                    id="telegram_message">{{ $settingdata->telegram_message }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label class="col-md-2 label-control"
                                                                for="telegram_access_token">{{ trans('labels.telegram_access_token') }}:<span
                                                                    class="text-danger"> *</span></label>
                                                            <div class="col-md-10">
                                                                <input type="text" name="telegram_access_token"
                                                                    class="form-control"
                                                                    placeholder="{{ trans('labels.telegram_access_token') }}"
                                                                    value="{{ $settingdata->telegram_access_token }}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label class="col-md-2 label-control"
                                                                for="telegram_chat_id">{{ trans('labels.telegram_chat_id') }}:<span
                                                                    class="text-danger"> *</span></label>
                                                            <div class="col-md-10">
                                                                <input type="text" name="telegram_chat_id"
                                                                    class="form-control"
                                                                    placeholder="{{ trans('labels.telegram_chat_id') }}"
                                                                    value="{{ $settingdata->telegram_chat_id }}">
                                                                <span class="text-danger">Get Chat ID : <a
                                                                        href="https://api.telegram.org/bot{TOKEN}/getUpdates"
                                                                        target="_blank">https://api.telegram.org/bot{TOKEN}/getUpdates</a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-end">
                                                        <button
                                                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                                            class="btn btn-secondary">{{ trans('labels.save') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif --}}
                @if (Auth::user()->type == 1)
                    <div id="landing_page">
                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <h5 class="text-uppercase">{{ trans('labels.landing_page') }}</h5>
                                        </div>
                                        <form action="{{ Url::to('/admin/landingsettings') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div class="row">
                                                <div class="form-group col-sm-6">
                                                    <label class="form-label">{{ trans('labels.primary_color') }}</label>
                                                    <input type="color"
                                                        class="form-control form-control-color w-100 border-0"
                                                        name="landing_primary_color"
                                                        value="{{ $settingdata->primary_color }}">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label
                                                        class="form-label">{{ trans('labels.secondary_color') }}</label>
                                                    <input type="color"
                                                        class="form-control form-control-color w-100 border-0"
                                                        name="landing_secondary_color"
                                                        value="{{ $settingdata->secondary_color }}">
                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label class="form-label">{{ trans('labels.contact_email') }}<span
                                                            class="text-danger"> * </span></label>
                                                    <input type="email" class="form-control" name="landing_email"
                                                        value="{{ @$settingdata->email }}"
                                                        placeholder="{{ trans('labels.contact_email') }}" required>
                                                    @error('email')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror

                                                </div>
                                                <div class="form-group col-md-6">

                                                    <label class="form-label">{{ trans('labels.contact_mobile') }}<span
                                                            class="text-danger"> * </span></label>
                                                    <input type="number" class="form-control" name="landing_mobile"
                                                        value="{{ @$settingdata->contact }}"
                                                        placeholder="{{ trans('labels.contact_mobile') }}" required>
                                                    @error('contact_mobile')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror

                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">{{ trans('labels.address') }}<span
                                                            class="text-danger"> * </span></label>
                                                    <textarea class="form-control" name="landing_address" rows="3" placeholder="{{ trans('labels.address') }}"
                                                        required>{{ $settingdata->address }}</textarea>
                                                    @error('address')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror

                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label class="form-label">{{ trans('labels.facebook_link') }}</label>
                                                    <input type="text" class="form-control"
                                                        name="landing_facebook_link"
                                                        value="{{ @$settingdata->facebook_link }}"
                                                        placeholder="{{ trans('labels.facebook_link') }}">
                                                    @error('facebook_link')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">{{ trans('labels.twitter_link') }}</label>
                                                    <input type="text" class="form-control"
                                                        name="landing_twitter_link"
                                                        value="{{ @$settingdata->twitter_link }}"
                                                        placeholder="{{ trans('labels.twitter_link') }}">
                                                    @error('twitter_link')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label
                                                        class="form-label">{{ trans('labels.instagram_link') }}</label>
                                                    <input type="text" class="form-control"
                                                        name="landing_instagram_link"
                                                        value="{{ @$settingdata->instagram_link }}"
                                                        placeholder="{{ trans('labels.instagram_link') }}">
                                                    @error('instagram_link')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">{{ trans('labels.linkedin_link') }}</label>
                                                    <input type="text" class="form-control"
                                                        name="landing_linkedin_link"
                                                        value="{{ @$settingdata->linkedin_link }}"
                                                        placeholder="{{ trans('labels.linkedin_link') }}">
                                                    @error('linkedin_link')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <button
                                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                                    class="btn btn-secondary">{{ trans('labels.save') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="productSettings">
                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <h5 class="text-uppercase">{{ trans('labels.product_settings') }}</h5>
                                        </div>
                                        <form action="{{ Url::to('/admin/save_product') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
    
                                            <div class="row">
                                                <div class="form-group">
                                                    <label class="form-label">{{ trans('labels.commission_type') }}<span
                                                            class="text-danger"> * </span></label>
                                                    <select class="form-control" name="commission_type" value="{{ $settingdata->commission_type }}" placeholder="{{ trans('labels.commission_type') }}" required>
                                                        @foreach($commissionTypes as $label => $value)
                                                            <option value="{{ $value }}" {{ $settingdata->commission_type === $value ? 'selected' : '' }}>
                                                                {{ ucfirst($label) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('commission_type')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
    
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">{{ trans('labels.commission_value') }}<span
                                                            class="text-danger"> * </span></label>
                                                    <input type="number" min="0" step="0.01" class="form-control" name="commission_value"
                                                        value="{{ $settingdata->commission_value }}"
                                                        placeholder="{{ trans('labels.commission_value') }}" required>
                                                    @error('commission_value')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
    
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <button
                                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                                    class="btn btn-secondary">{{ trans('labels.save') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var cityurl = "{{ URL::to('admin/getcity') }}";
        var select = "{{ trans('labels.select') }}";
        var cityid = "{{ Auth::user()->city_id != null ? Auth::user()->city_id : '0' }}";
    </script>
    <script src="{{ url('storage/app/public/admin-assets/js/user.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/settings.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/editor.js') }}"></script>
@endsection
