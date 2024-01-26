@extends('admin.layout.default')

@section('content')

    @include('admin.breadcrumb.breadcrumb')

    <div class="row mt-3">

        <div class="col-12">

            @if (Auth::user()->type == 2)

            <form action="{{ URL::to('admin/faqs/savecontent') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="card border-0 mb-3 p-3">

                    <div class="row">

                        <div class="col-md-6 mb-lg-0">

                            <div class="form-group">

                                <label class="form-label">{{trans('labels.image')}} (250 x 250) <span class="text-danger"> * </span></label>

                                <input type="file" class="form-control" name="image" required>

                            </div>

                            <img src="{{helper::image_path($content->faq_image)}}" class="img-fluid rounded hw-70" alt="">

                        </div>

                        <div class="text-end">

                            <button type="submit" class="btn btn-secondary">{{ trans('labels.save') }}</button>

                        </div>

                    </div>

                </div>

            </form>

            @endif

            <div class="card border-0 mb-3">

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-striped table-bordered py-3 zero-configuration w-100 dataTable no-footer">

                            <thead>

                                <tr class="text-uppercase fw-500">

                                    <td>{{ trans('labels.srno') }}</td>

                                    <td>{{ trans('labels.question') }}</td>

                                    <td>{{ trans('labels.answer') }}</td>

                                    <td>{{ trans('labels.action') }}</td>

                                </tr>

                            </thead>

                            <tbody>

                                @php

                                    $i = 1;

                                @endphp

                                @foreach ($faqs as $faq)

                                    <tr class="fs-7">

                                        <td>@php

                                            echo $i++;

                                        @endphp</td>

                                        <td>{{ $faq->question }}</td>

                                        <td>{{ $faq->answer }}</td>

                                        <td>

                                            <a href="{{ URL::to('/admin/faqs/edit-' . $faq->id) }}"

                                                class="btn btn-outline-primary btn-sm mx-1"> <i

                                                    class="fa-regular fa-pen-to-square"></i></a>

                                            <a href="javascript:void(0)"

                                                @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/faqs/delete-' . $faq->id) }}')" @endif

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

