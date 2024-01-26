@extends('admin.layout.default')

@section('content')

    @php

        if (request()->is('admin/bannersection-1*')) {

            $section = 1;

            $title = trans('labels.section-1');

            $url = 'bannersection-1';

            $table_url = URL::to('admin/bannersection-1/');

        } elseif (request()->is('admin/bannersection-2*')) {

            $section = 2;

            $title = trans('labels.section-2');

            $url = 'bannersection-2';

            $table_url = URL::to('admin/bannersection-2/');

        } else {

            $section = 3;

            $title = trans('labels.section-3');

            $url = 'bannersection-3';

            $table_url = URL::to('admin/bannersection-3/');

        }

    @endphp

           @include('admin.breadcrumb.breadcrumb')

          

            <div class="row mt-3">

                <div class="col-12">

                    <div class="card border-0 mb-3">

                        <div class="card-body">

                            <div class="table-responsive">

                                @include('admin.banner.table')

                            </div>

                        </div>

                    </div>

                </div>

            </div>

@endsection

