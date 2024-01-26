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

                                    <td>{{ trans('labels.name') }}</td>

                                    <td>{{ trans('labels.position') }}</td>

                                    <td>{{ trans('labels.description') }}</td>

                                    <td>{{ trans('labels.ratting') }}</td>

                                    <td>{{ trans('labels.action') }}</td>

                                </tr>

                            </thead>

                            <tbody>

                                @php

                                    $i = 1;

                                @endphp

                              @foreach ($testimonials as $testimonial)

                              <tr class="fs-7">

                                <td>@php

                                    echo $i++;

                                @endphp</td>

                                <td><img src="{{helper::image_path($testimonial->image)}}"  class="img-fluid rounded hw-50 object-fit-cover" alt=""></td>

                                <td>{{$testimonial->name}}</td>

                                <td>{{$testimonial->position}}</td>

                                <td>{{$testimonial->description}}</td>

                                <td>{{$testimonial->star}}</td>

                                <td>

                                    <a href="{{ URL::to('/admin/testimonials/edit-'.$testimonial->id ) }}"

                                        class="btn btn-outline-primary btn-sm mx-1"> <i

                                            class="fa-regular fa-pen-to-square"></i></a>

                                    <a href="javascript:void(0)"

                                        @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/testimonials/delete-'.$testimonial->id) }}')" @endif

                                        class="btn btn-outline-danger btn-sm">

                                        <i class="fa-regular fa-trash"></i></a>

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

