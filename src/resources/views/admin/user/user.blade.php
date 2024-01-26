@extends('admin.layout.default')

@section('content')

    @include('admin.breadcrumb.breadcrumb')

    <div class="row">

        <div class="col-12">

            <div class="card border-0 my-3">

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-striped table-bordered py-3 zero-configuration w-100">

                            <thead>

                                <tr class="text-uppercase fw-500">

                                    <td>{{ trans('labels.srno') }}</td>

                                    <td>{{ trans('labels.image') }}</td>

                                    <td>{{ trans('labels.name') }}</td>

                                    <td>{{ trans('labels.email') }}</td>

                                    <td>{{ trans('labels.mobile') }}</td>

                                    <td>{{ trans('labels.status') }}</td>

                                    <td>{{ trans('labels.action') }}</td>



                                </tr>

                            </thead>

                            <tbody>

                                @php

                                    $i = 1;

                                @endphp

                                @foreach ($users as $user)

                                    <tr class="">

                                        <td>@php

                                            echo $i++;

                                        @endphp</td>

                                        <td><img src="{{ helper::image_path($user->image) }}" height="50" width="50"

                                                alt=""></td>

                                        <td>{{ $user->name }}</td>

                                        <td>{{ $user->email }}</td>

                                        <td>{{ $user->mobile }}</td>

                                        <td>

                                            @if ($user->is_available == '1')

                                                <a class="btn btn-sm btn-outline-success" href="javascript::void(0)"

                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/users/status-' . $user->slug . '/2') }}')" @endif><i class="fa-regular fa-check"></i>

                                                </a>

                                            @else

                                                <a class="btn btn-sm btn-outline-danger" href="javascript::void(0)"

                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else  onclick="statusupdate('{{ URL::to('admin/users/status-' . $user->slug . '/1') }}')" @endif><i class="fa-regular fa-xmark "></i>

                                                </a>

                                            @endif

                                        </td>

                                        <td>

                                            <a href="{{ URL::to('admin/users/edit-' . $user->slug) }}" class="btn btn-outline-primary btn-sm"> <i

                                                class="fa-regular fa-pen-to-square"></i>

                                            </a>

                                            <a class="btn btn-sm btn-outline-dark" href="{{ URL::to('/admin/users/login-' . $user->slug) }}"> <i class="fa-regular fa-arrow-right-to-bracket"></i> </a>

                                            <a class="btn btn-sm btn-primary" href="{{ URL::to('/' . $user->slug) }}" target="_blank"><i class="fa-regular fa-eye"></i></a>

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



