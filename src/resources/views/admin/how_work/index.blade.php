@extends('admin.layout.default')

@section('content')

    @include('admin.breadcrumb.breadcrumb')



    <div class="row mt-3">

        <div class="col-12">

            <form action="{{ URL::to('admin/how_works/savecontent') }}" method="POST">

                @csrf

                <div class="card border-0 mb-3 p-3">

                    <div class="row">

                        <div class="col-md-6 mb-lg-0">

                            <div class="form-group">

                                <label class="form-label">{{ trans('labels.title') }}<span class="text-danger"> *

                                    </span></label>

                                <input type="text"

                                    class="form-control {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"

                                    name="title" placeholder="{{ trans('labels.title') }}" value="{{$content->work_title}}" required>

                                @error('title')

                                    <small class="text-danger">{{ $message }}</small>

                                @enderror



                            </div>

                        </div>

                        <div class="col-md-6 mb-lg-0">

                            <div class="form-group">

                                <label class="form-label">{{ trans('labels.subtitle') }}<span class="text-danger"> *

                                    </span></label>

                                <input type="text"

                                    class="form-control {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"

                                    name="subtitle" placeholder="{{ trans('labels.subtitle') }}" value="{{$content->work_subtitle}}" required>

                                @error('subtitle')

                                    <small class="text-danger">{{ $message }}</small>

                                @enderror



                            </div>

                        </div>

                        <div class="text-end">

                            <button type="submit" class="btn btn-secondary">{{ trans('labels.save') }}</button>

                        </div>

                    </div>

                </div>

            </form>

            <div class="card border-0 mb-3">

                <div class="text-end">

                    <a href="{{ URL::to(request()->url() . '/add') }}" class="btn btn-secondary mx-3 mt-3">

                        <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}</a>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-striped table-bordered py-3 zero-configuration w-100 dataTable no-footer">

                            <thead>

                                <tr class="text-uppercase fw-500">

                                    <td>{{ trans('labels.srno') }}</td>

                                    <td>{{ trans('labels.title') }}</td>

                                    <td>{{ trans('labels.subtitle') }}</td>

                                    <td>{{ trans('labels.action') }}</td>

                                </tr>

                            </thead>

                            <tbody>

                                @php

                                    $i = 1;

                                @endphp

                                @foreach ($allworkcontent as $content)

                                <tr class="fs-7">

                                    <td>@php

                                        

                                        echo $i++;

                                        

                                    @endphp</td>

                                    <td>{{$content->title}}</td>

                                    <td>{{$content->sub_title}}</td>

                                    <td>

                                        <a href="{{ URL::to('/admin/how_works/edit-' . $content->id) }}"

                                                class="btn btn-outline-primary btn-sm"> <i

                                                    class="fa-regular fa-pen-to-square"></i></a>

                                            <a href="javascript:void(0)"  @if (env('Environment') == 'sendbox') onclick="myFunction()" @else

                                                onclick="statusupdate('{{ URL::to('/admin/how_works/delete-' . $content->id) }}')" @endif

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

