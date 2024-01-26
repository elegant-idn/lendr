@extends('admin.layout.default')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-uppercase">{{ trans('labels.share') }}</h5>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <div class="card-block text-center">
                        <?php
                        $isMob = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile'));
                        ?>
                        <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{ URL::to('/') }}/{{ Auth::user()->slug }}&choe=UTF-8"
                            title="Link to Google.com" />
                        <div class="card-block">
                            @if ($isMob == '1')
                                <a href="whatsapp://send/send?text={{ URL::to('/') }}/{{ Auth::user()->slug }}"
                                    target="_blank"
                                    class="btn btn-social btn-min-width btn-adn-flat mr-2 mb-2 btn-adn"><i
                                        class="fa-brands fa-whatsapp text-wa-color"></i>
                                    {{ trans('labels.whatsapp') }}</a>
                            @else
                                <a href="https://web.whatsapp.com/send?text={{ URL::to('/') }}/{{ Auth::user()->slug }}"
                                    target="_blank"
                                    class="btn btn-social btn-min-width btn-adn-flat mr-2 mb-2 btn-adn"><i
                                        class="fa-brands fa-whatsapp text-wa-color"></i>
                                    {{ trans('labels.whatsapp') }}</a>
                            @endif
                            <a href="https://www.facebook.com/sharer.php?u={{ URL::to('/') }}/{{ Auth::user()->slug }}"
                                target="_blank"
                                class="btn btn-social btn-min-width btn-facebook-flat mr-2 mb-2"><i
                                    class="fa-brands fa-facebook text-fb-color"></i>
                                {{ trans('labels.facebook') }}</a>
                            <a href="http://twitter.com/share?text={{ Auth::user()->name }}&url={{ URL::to('/') }}/{{ Auth::user()->slug }}&hashtags=restaurant,whatsapporder,onlineorder"
                                target="_blank"
                                class="btn btn-social btn-min-width btn-twitter-flat mr-2 mb-2 btn-twitter"><i
                                    class="fa-brands fa-twitter text-tw-color"></i>
                                {{ trans('labels.twitter') }}</a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ URL::to('/') }}/{{ Auth::user()->slug }}"
                                target="_blank"
                                class="btn btn-social btn-min-width btn-linkedin-flat mr-2 mb-2 btn-linkedin"><i
                                    class="fa-brands fa-linkedin text-ld-color"></i>
                                {{ trans('labels.linkedin') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection