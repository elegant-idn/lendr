@extends('admin.layout.default')

@section('content')
    <div class="bg-white shadow rounded py-4 mt-3 position-relative">
        <div class="position-absolute top-0 end-0 p-3">
            <a href="javascript:void(0)" style="width:50px;height:40px"
                onclick="statusupdate('{{ route('products.status_change', ['slug' => $product->slug, 'status' => 1]) }}')"
                class="btn btn-outline-success"><i class="fa-regular fa-check"></i></a>
            <a href="javascript:void(0)" style="width:50px;height:40px"
                onclick="statusupdate('{{ route('products.delete', ['slug' => $product->slug]) }}')"
                class="btn btn-outline-danger"><i class="fa-regular fa-xmark"></i></a>
        </div>
        <div class="px-4 py-4">
            <h4 class="fw-bold">{{$product->title}} </h4>
        </div>
        <div class="border-top bg-light">
            <div class="px-4 py-3">
                <span class="fw-bold">{{trans('labels.category')}}: </span> {{$product->category}}
            </div>
        </div>
        <div class="border-top">
            <div class="px-4 py-3">
                <span class="fw-bold">{{trans('labels.slug')}}: </span> {{$product->slug}}
            </div>
        </div>
        <div class="border-top bg-light">
            <div class="px-4 py-3">
                <span class="fw-bold">{{trans('labels.description')}}: </span>
                <dd>{{$product->description}}<dd>
            </div>
        </div>
        {{-- <div class="border-top">
            <div class="px-4 py-3">
                <span class="fw-bold">{{trans('labels.additional_details')}}: </span>
                <dd>{{$product->additional_details}}</dd>
            </div>
        </div> --}}
        {{-- <div class="border-top bg-light">
            <div class="px-4 py-3">
                <span class="fw-bold">{{trans('labels.tax')}}: </span> {{$product->tax}} %
            </div>
        </div> --}}
        {{-- <div class="border-top">
            <div class="px-4 py-3">
                <span class="fw-bold">{{trans('labels.per_hour_price')}}: </span> {{$product->per_hour_price}} $
            </div>
        </div> --}}
        <div class="border-top">
            <div class="px-4 py-3">
                <span class="fw-bold">{{trans('labels.per_day_price')}}: </span> {{$product->per_day_price}} $
            </div>
        </div>
        <div class="border-top bg-light">
            <div class="px-4 py-3">
                <span class="fw-bold">{{trans('labels.final_per_day_price')}}: </span> {{$product->final_per_day_price}} $
            </div>
        </div>
        {{-- <div class="border-top">
            <div class="px-4 py-3">
                <span class="fw-bold">{{trans('labels.minimum_booking_hour')}}: </span> {{$product->minimum_booking_hour}}
            </div>
        </div> --}}
        <div class="border-top">
            <div class="px-4 py-3">
                <span class="fw-bold">{{trans('labels.contact_name')}}: </span> {{$product->contact_name}}
            </div>
        </div>
        <div class="border-top bg-light">
            <div class="px-4 py-3">
                <span class="fw-bold">{{trans('labels.contact_mobile')}}: </span> {{$product->contact_mobile}}
            </div>
        </div>
        <div class="border-top">
            <div class="px-4 py-3">
                <span class="fw-bold">{{trans('labels.contact_email')}}: </span> {{$product->contact_email}}
            </div>
        </div>
        <div class="border-top bg-light">
            <div class="px-4 py-3">
                <span class="fw-bold">{{trans('labels.contact_location')}}: </span> {{$product->contact_location}}
            </div>
        </div>
        <div class="border-top">
            <div class="px-4 py-3">
                <span class="fw-bold">{{trans('labels.created_at')}}: </span> {{$product->created_at}}
            </div>
        </div>
        <div class="container-fluid bg-light">
            <div class="border-top bg-light">
                <div class="px-4 py-3">
                    <span class="fw-bold">{{trans('labels.gallery')}}: </span>
                </div>
            </div>
            <div class="row mx-auto px-5">
                @foreach ($product->product_image_api as $image)
                <div class="col-3 mb-3 d-flex">
                    <div class="shadow rounded align-self-center">
                        <img src="{{$image->image}}" class="img-fluid" alt="Image">
                    </div>
                </div>
                @endforeach
            </div>
            </div>
    </div>
@endsection

