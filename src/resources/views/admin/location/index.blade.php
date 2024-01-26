@extends('admin.layout.default')

@section('content')

@php

if (request()->is('admin/pickup_location*')) {

    $section = 1;

    $locationtitle = trans('labels.pickup_location');

    $locationurl = 'pickup_location';

    $location_url = URL::to('admin/pickup_location/');

} elseif (request()->is('admin/drop_location*')) {

    $section = 2;

    $locationtitle = trans('labels.drop_location');

    $locationurl = 'drop_location';

    $location_url = URL::to('admin/drop_location/');

}

@endphp

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

                                    @if ($section == 1)

                                        <td>{{ trans('labels.pickup_location') }}</td>

                                    @else

                                        <td>{{ trans('labels.drop_location') }}</td>

                                    @endif

                                    <td>{{ trans('labels.status') }}</td>

                                    <td>{{ trans('labels.action') }}</td>

                                </tr>

                            </thead>

                            <tbody>

                                @php

                                    $i = 1;

                                @endphp

                                @foreach ($locations as $location)

                                    @if ($location->type == $section)

                                        <tr class="fs-7">

                                            <td>@php

                                                echo $i++;

                                            @endphp</td>

                                            @if ($location->type == 1)

                                            <td>{{ $location->pickup_location }}</td>

                                            @else

                                            <td>{{ $location->drop_location }}</td>

                                            @endif

                                            <td>

                                                @if ($location->is_available == '1')

                                                <a href="javascript:void(0)"

                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else

                    

                                                onclick="statusupdate('{{ URL::to('admin/' . $locationurl . '/status_change-' . $location->id . '/2') }}')" @endif

                                                    class="btn btn-sm btn-outline-success"><i class="fa-regular fa-check"></i></a>

                                            @else

                                                <a href="javascript:void(0)"

                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else

                    

                                                onclick="statusupdate('{{ URL::to('admin/' . $locationurl . '/status_change-' . $location->id . '/1') }}')" @endif

                                                    class="btn btn-sm btn-outline-danger"><i class="fa-regular fa-xmark"></i></a>

                                            @endif

                                            </td>

                                            <td>

                                                <a href="{{ URL::to('/admin/'.$locationurl.'/edit-' . $location->id) }}"

                                                    class="btn btn-outline-primary btn-sm"> <i

                                                        class="fa-regular fa-pen-to-square"></i></a>

                                                <a href="javascript:void(0)"

                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else

                                                onclick="statusupdate('{{ URL::to('/admin/'.$locationurl.'/delete-' . $location->id.'-'.$location->type) }}')" @endif

                                                    class="btn btn-outline-danger btn-sm"> <i

                                                        class="fa-regular fa-trash"></i></a>

                                            </td>

                                        </tr>

                                    @endif

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

