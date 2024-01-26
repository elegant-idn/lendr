<!DOCTYPE html>
<html lang="en" dir="{{ session()->get('direction') == 2 ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta property="og:title" content="{{ helper::appdata('')->meta_title }}" />
    <meta property="og:description" content="{{ helper::appdata('')->meta_description }}" />
    <meta property="og:image" content='{{ helper::image_path(helper::appdata('')->og_image) }}' />
    <title>{{ helper::appdata('')->web_title }}</title>
    {{-- <link rel="icon" type="image" sizes="16x16" href="{{ helper::image_path(helper::appdata(Auth::user()->id)->favicon) }}"><!-- Favicon icon --> --}}
    <link rel="stylesheet" href="{{ asset('admin-assets/css/bootstrap/bootstrap.min.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('admin-assets/css/fontawesome/all.min.css') }}">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="{{ asset('admin-assets/css/toastr/toastr.min.css') }}">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ asset('admin-assets/css/sweetalert/sweetalert2.min.css') }}">
   
    <!-- Sweetalert CSS -->
    <link rel="stylesheet" href="{{ asset('admin-assets/css/style.css') }}"><!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('admin-assets/css/responsive.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('admin-assets/css/timepicker/jquery.timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/datatables/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/datatables/buttons.dataTables.min.css') }}">
</head>
<body>
    <!-- PreLoader -->
    @include('admin.layout.preloader')
    <main>
        <div class="wrapper">
            @include('admin.layout.header')
            <div class="content-wrapper">
                @include('admin.layout.sidebar')
                <div class="{{ session()->get('direction') == 2 ? 'main-content-rtl' : 'main-content' }}">
                    <div class="page-content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 ml-sm-auto">
                                @if (env('Environment') == 'live')
                                @if(request()->is('admin/custom_domain'))
                                    <div class="alert alert-warning" role="alert">
                                        {{ trans('messages.custom_domain_message')}}
                                    </div>
                                    @endif
                                    @if(request()->is('admin/apps'))
                                    <div class="alert alert-warning" role="alert">
                                        {{ trans('messages.addon_message')}}
                                    </div>
                                    @endif
                                @endif
                                    @if (Auth::user()->type == 2)
                                    <?php
                                    $checkplan = helper::checkplan(Auth::user()->id, '');
                                    $plan = json_decode(json_encode($checkplan));
                                    ?>
                                    @if (@$plan->original->status == '2')
                                    <div class="alert alert-warning" role="alert">
                                        {{ @$plan->original->message }}{{ empty($plan->original->expdate) ? '' : ':' . $plan->original->expdate }}
                                        @if (@$plan->original->showclick == 1)
                                        <u><a href="{{ URL::to('/admin/plan') }}">{{ trans('labels.click_here') }}</a></u>
                                        @endif
                                    </div>
                                    @endif
                                    @endif
                                </div>
                            </div>
                            @yield('content')
                        </div>
                    </div>
                </div>
                <!--Modal: order-modal-->
                <div class="modal fade" id="order-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-notify modal-info" role="document">
                        <div class="modal-content text-center">
                            <div class="modal-header d-flex justify-content-center">
                                <p class="heading">{{ trans('messages.be_up_to_date') }}</p>
                            </div>
                            <div class="modal-body"><i class="fa fa-bell fa-4x animated rotateIn mb-4"></i>
                                <p>{{ trans('messages.new_order_arrive') }}</p>
                            </div>
                            <div class="modal-footer flex-center">
                                <a role="button" class="btn btn-outline-secondary-modal waves-effect" onClick="window.location.reload();" data-bs-dismiss="modal">{{ trans('labels.okay') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Modal: modalPush-->
            </div>
            @include('admin.layout.footer')
        </div>
    </main>
    <script src="{{ asset('admin-assets/js/jquery/jquery.min.js') }}"></script><!-- jQuery JS -->
    <script src="{{ asset('admin-assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script><!-- Bootstrap JS -->
    <script src="{{ asset('admin-assets/js/toastr/toastr.min.js') }}"></script><!-- Toastr JS -->
    <script src="{{ asset('admin-assets/js/sweetalert/sweetalert2.min.js') }}"></script><!-- Sweetalert JS -->
    <script src="{{ asset('admin-assets/js/datatables/jquery.dataTables.min.js') }}"></script><!-- Datatables JS -->
    <script src="{{ asset('admin-assets/js/datatables/dataTables.bootstrap5.min.js') }}"></script><!-- Datatables Bootstrap5 JS -->
    <script src="{{ asset('admin-assets/js/datatables/dataTables.buttons.min.js') }}"></script><!-- Datatables Buttons JS -->
    <script src="{{ asset('admin-assets/js/datatables/jszip.min.js') }}"></script><!-- Datatables Excel Buttons JS -->
    <script src="{{ asset('admin-assets/js/datatables/pdfmake.min.js') }}"></script><!-- Datatables Make PDF Buttons JS -->
    <script src="{{ asset('admin-assets/js/datatables/vfs_fonts.js') }}"></script><!-- Datatables Export PDF Buttons JS -->
    <script src="{{ asset('admin-assets/js/datatables/buttons.html5.min.js') }}"></script><!-- Datatables Buttons HTML5 JS -->
    <script src="{{ asset('admin-assets/js/chartjs/chart_3.9.1.min.js') }}"></script>
    <script>
       
        var are_you_sure = "{{trans('messages.are_you_sure')}}";
        var yes = "{{trans('messages.yes')}}";
        var no = "{{trans('messages.no')}}";
        toastr.options = {"closeButton": true,}
        @if(Session::has('success'))
        toastr.success("{{ session('success') }}");
        @endif
        @if(Session::has('error'))
        toastr.error("{{ session('error') }}");
        @endif
        
    </script>
  
    @if (Auth::user()->type == 2)
    <script src="{{ asset('admin-assets/js/sound.js') }}"></script>
    @endif
   
    <script src="{{ asset('admin-assets/js/common.js') }}"></script><!-- Common JS -->
    @yield('scripts')
</body>
</html>