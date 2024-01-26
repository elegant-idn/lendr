@extends('admin.layout.default')

@section('content')

    @include('admin.breadcrumb.breadcrumb')

    <div class="row mt-3">

        <div class="col-12">

            <div class="card border-0 mb-3">

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-striped table-bordered py-3 zero-configuration w-100 dataTable no-footer">

                            <thead>

                                <tr class="text-uppercase fw-500">

                                    <td>{{ trans('labels.srno') }}</td>

                                    <td>{{ trans('labels.image') }}</td>

                                    <td>{{ trans('labels.category') }}</td>

                                    <td>{{ trans('labels.title') }}</td>

                                    <td>{{ trans('labels.per_hour_price') }}</td>

                                    <td>{{ trans('labels.per_day_price') }}</td>

                                    <td>{{ trans('labels.tax') }}</td>



                                    <td>{{ trans('labels.status') }}</td>

                                    <td>{{ trans('labels.action') }}</td>

                                </tr>

                            </thead>

                            <tbody>

                                @php

                                    $i = 1;

                                @endphp

                                @foreach ($products as $item)

                                    <tr class="fs-7">

                                        <td>@php

                                            echo $i++;

                                        @endphp</td>

                                        <td><img src="{{ @helper::image_path($item['product_image']->image) }}"

                                                class="img-fluid rounded hw-50" alt=""></td>

                                        <td>{{ $item['category_info']->name }}</td>

                                        <td>{{ $item->title }}</td>

                                        <td>{{ helper::currency_formate($item->per_hour_price, Auth::user()->id) }}</td>

                                        <td>{{ helper::currency_formate($item->per_day_price, Auth::user()->id) }}</td>

                                        <td>{{ $item->tax }}%</td>



                                        <td>

                                            @if ($item->is_available == '1')

                                                <a href="javascript:void(0)"

                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ Url::to('admin/products/status_change-' . $item->slug . '/2') }}')" @endif

                                                    class="btn btn-sm btn-outline-success"><i

                                                        class="fa-regular fa-check"></i></a>

                                            @else

                                                <a href="javascript:void(0)"

                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else

                                                        onclick="statusupdate('{{ URL::to('admin/products/status_change-' . $item->slug . '/1') }}')" @endif

                                                    class="btn btn-sm btn-outline-danger"><i

                                                        class="fa-regular fa-xmark"></i></a>

                                            @endif

                                        </td>

                                        <td>

                                            <a href="{{ URL::to('admin/products/edit-' . $item->slug) }}"

                                                class="btn btn-outline-primary btn-sm"> <i

                                                    class="fa-regular fa-pen-to-square"></i></a>

                                            <a href="javascript:void(0)"

                                                @if (env('Environment') == 'sendbox') onclick="myFunction()" @else

                                                        onclick="statusupdate('{{ URL::to('/admin/products/delete-' . $item->slug) }}')" @endif

                                                class="btn btn-outline-danger btn-sm"> <i

                                                    class="fa-regular fa-trash"></i></a>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

