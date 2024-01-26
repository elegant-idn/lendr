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

                                    <td>{{ trans('labels.action') }}</td>

                                </tr>

                            </thead>

                            <tbody>

                                @php

                                    $i = 1;

                                @endphp

                                @foreach ($allgallery as $gallery)

                                    <tr class="fs-7">

                                        <td>@php

                                            

                                            echo $i++;

                                            

                                        @endphp</td>

                                        <td><img src="{{ helper::image_path($gallery->image) }}"

                                                class="img-fluid rounded hw-50" alt=""></td>

                                        {{-- <td>

                                            @if ($gallery->is_available == '1')

                                                <a href="javascript:void(0)"  @if (env('Environment') == 'sendbox') onclick="myFunction()" @else

                                                    onclick="statusupdate('{{ URL::to('/admin/gallery/change_status-' . $gallery->id . '/2') }}')" @endif

                                                    class="btn btn-sm btn-outline-success"><i class="fa-regular fa-check"></i></a>

                                            @else

                                                <a href="javascript:void(0)"  @if (env('Environment') == 'sendbox') onclick="myFunction()" @else

                                                    onclick="statusupdate('{{ URL::to('/admin/gallery/change_status-' . $gallery->id . '/1') }}')" @endif

                                                    class="btn btn-sm btn-outline-danger"><i class="fa-regular fa-xmark"></i></a>

                                            @endif

                                        </td> --}}

                                        <td>

                                            <a href="{{ URL::to('/admin/gallery/edit-' . $gallery->id) }}"

                                                class="btn btn-outline-primary btn-sm"> <i

                                                    class="fa-regular fa-pen-to-square"></i></a>

                                            <a href="javascript:void(0)"  @if (env('Environment') == 'sendbox') onclick="myFunction()" @else

                                                onclick="statusupdate('{{ URL::to('/admin/gallery/delete-' . $gallery->id) }}')" @endif

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

