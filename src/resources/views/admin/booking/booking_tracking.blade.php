@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')
    <div class="row mt-3">
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <div class="card-header text-center">
                        <h4 class="card-title mb-0">#{{ $invoice->booking_number }}</h4>
                    </div>
                    <div class="basic-list-group">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                {{ trans('labels.payment_status') }}
                                @if ($invoice->payment_status == 1)
                                    @if ($invoice->status == 5)
                                        <a href="javascript::void(0)"
                                            onclick="statusupdate('{{ Url::to('admin/bookings/payment_status-' . $invoice->booking_number . '/2') }}')"><span
                                                class="text-danger">{{ trans('labels.unpaid') }}</span></a>
                                    @else
                                        <span class="text-danger">{{ trans('labels.unpaid') }}</span>
                                    @endif
                                @else
                                    <span class="text-success">{{ trans('labels.paid') }}</span>
                                @endif
                            </li>
                            @if ($invoice->payment_status == 2)
                                <li class="list-group-item px-0 d-flex justify-content-between">
                                    {{ trans('labels.transaction_id') }}
                                    <span class="text-muted text-end">
                                        {{ $invoice->transaction_id == '' ? '-' : $invoice->transaction_id }}
                                    </span>
                                </li>
                                <li class="list-group-item px-0 d-flex justify-content-between">
                                    {{ trans('labels.payment_type') }}
                                    <span class="text-muted">
                                        {{-- payment_type = COD : 1,RazorPay : 2, Stripe : 3, Flutterwave : 4, Paystack : 5, Mercado Pago : 7, PayPal : 8, MyFatoorah : 9, toyyibpay : 10 --}}
                                        @if ($invoice->transaction_type == 1)
                                            {{ trans('labels.cod') }}
                                        @elseif($invoice->transaction_type == 2)
                                            {{ trans('labels.razorpay') }}
                                        @elseif($invoice->transaction_type == 3)
                                            {{ trans('labels.stripe') }}
                                        @elseif($invoice->transaction_type == 4)
                                            {{ trans('labels.flutterwave') }}
                                        @elseif($invoice->transaction_type == 5)
                                            {{ trans('labels.paystack') }}
                                        @elseif($invoice->transaction_type == 7)
                                            {{ trans('labels.mercadopago') }}
                                        @elseif($invoice->transaction_type == 8)
                                            {{ trans('labels.paypal') }}
                                        @elseif($invoice->transaction_type == 9)
                                            {{ trans('labels.myfatoorah') }}
                                        @elseif($invoice->transaction_type == 10)
                                            {{ trans('labels.toyyibpay') }}
                                        @endif
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </div>

                </div>
            </div>
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <div class="media d-flex align-items-center mb-2">
                        <h3 class="mb-0 mx-3">{{ $invoice->customer_name }}</h3>
                    </div>
                    <div class="basic-list-group">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 d-flex align-items-center">
                                <h5 class="m-2"><i class="fa fa-phone"></i></h5>
                                {{ $invoice->customer_mobile }}
                            </li>
                            <li class="list-group-item px-0 d-flex align-items-center">
                                <h5 class="m-2"><i class="fa fa-envelope"></i></h5>
                                {{ $invoice->customer_email }}
                            </li>
                            <li class="list-group-item px-0 d-flex align-items-center">
                                <h5 class="m-2"><i class="fa-solid fa-location-dot"></i></h5>
                                {{ $invoice->customer_address }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-6 mb-3 payments">
            <div class="row">
                <div class="col-md-12 my-2 d-flex justify-content-end">
                    @if ($invoice->status == 1)
                        @php
                            $status = trans('labels.pending');
                            $color = 'warning';
                        @endphp
                    @elseif ($invoice->status == 2)
                        @php
                            $status = trans('labels.accept');
                            $color = 'info';
                        @endphp
                    @elseif ($invoice->status == 3)
                        @php
                            $status = trans('labels.in_progress');
                            $color = 'info';
                        @endphp
                    @elseif ($invoice->status == 4 || $invoice->status == 5)
                        @php
                            $status = trans('labels.canceled');
                            $color = 'danger';
                        @endphp
                    @elseif ($invoice->status == 6)
                        @php
                            $status = trans('labels.completed');
                            $color = 'success';
                        @endphp
                    @endif
                    @if ($invoice->status == 4 || $invoice->status == 5 || $invoice->status == 6)
                        <label class="text-{{ $color }} fw-500">{{ $status }}</label>
                    @else
                        <button type="button"
                            class="btn btn-sm btn-dark {{ session()->get('direction') == 2 ? 'dropdown-toggle-rtl' : 'dropdown-toggle' }}"
                            data-bs-toggle="dropdown">{{ $status }}</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item w-auto " title="Accept"
                                onclick="statusupdate('{{ Url::to('admin/bookings/status_change-' . $invoice->booking_number . '/2') }}')">{{ trans('labels.accept') }}</a>
                            <a class="dropdown-item w-auto " title="InProgress"
                                onclick="statusupdate('{{ Url::to('admin/bookings/status_change-' . $invoice->booking_number . '/3') }}')">{{ trans('labels.in_progress') }}</a>
                            <a class="dropdown-item w-auto " title="Reject"
                                onclick="statusupdate('{{ Url::to('admin/bookings/status_change-' . $invoice->booking_number . '/4') }}')">{{ trans('labels.cancel') }}</a>
                            <a class="dropdown-item w-auto " title="Complete"
                                onclick="statusupdate('{{ Url::to('admin/bookings/status_change-' . $invoice->booking_number . '/6') }}')">{{ trans('labels.complete') }}</a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <div class="progress-barrr">
                        @if ($invoice->status == 4 || $invoice->status == 5)
                            <div
                                class="{{ session()->get('direction') == 2 ? 'progress-step-rtl' : 'progress-step' }} is-active">
                                <div class="step-count"><i class="fa fa-xmark"></i></div>
                                <div class="step-description">{{ trans('labels.canceled') }}</div>
                            </div>
                        @else
                            <div
                                class="{{ session()->get('direction') == 2 ? 'progress-step-rtl' : 'progress-step' }} {{ $invoice->status == 1 ? 'is-active' : '' }}">
                                <div class="step-count"><i class="fa fa-tasks"></i></div>
                                <div class="step-description">{{ trans('labels.pending') }}</div>
                            </div>
                            <div
                                class="{{ session()->get('direction') == 2 ? 'progress-step-rtl' : 'progress-step' }} {{ $invoice->status == 2 ? 'is-active' : '' }}">
                                <div class="step-count"><i class="fa fa-circle-check"></i></div>
                                <div class="step-description">{{ trans('labels.accept') }}</div>
                            </div>
                            <div
                                class="{{ session()->get('direction') == 2 ? 'progress-step-rtl' : 'progress-step' }} {{ $invoice->status == 3 ? 'is-active' : '' }}">
                                <div class="step-count"><i class="fa fa-circle-check"></i></div>
                                <div class="step-description">{{ trans('labels.in_progress') }}</div>
                            </div>
                            <div
                                class="{{ session()->get('direction') == 2 ? 'progress-step-rtl' : 'progress-step' }} {{ $invoice->status == 6 ? 'is-active' : '' }}">
                                <div class="step-count"><i class="fa fa-check"></i></div>
                                <div class="step-description">{{ trans('labels.completed') }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ trans('labels.image') }}</th>
                                    <th>{{ trans('labels.product') }}</th>
                                    <th class="text-end">{{ trans('labels.checkin_detail') }}</th>
                                    <th class="text-end">{{ trans('labels.checkout_detail') }}</th>
                                    <th class="text-end">{{ trans('labels.total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><img src="{{ helper::image_path($invoice->product_image) }}" class="rounded hw-50"
                                            alt=""></td>
                                    <td>{{ $invoice['product_info']->title }}</td>
                                    <td class="text-end">
                                        {{ helper::date_formate($invoice->checkin_date) }}
                                        {{date("g:i a", strtotime($invoice->checkin_time))}}<br><small>{{ $invoice->checkin_location }}</small> </td>
                                    <td class="text-end">
                                        {{ helper::date_formate($invoice->checkout_date) }}
                                        {{date("g:i a", strtotime($invoice->checkout_time))}}<br><small> {{ $invoice->checkout_location }}</small></td>
                                    <td class="text-end">
                                        {{ helper::currency_formate($invoice->subtotal, $invoice->vendor_id) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end" colspan="4">
                                        <strong>{{ trans('labels.subtotal') }}</strong>
                                    </td>
                                    <td class="text-end"><strong>
                                            {{ helper::currency_formate($invoice->subtotal, $invoice->vendor_id) }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end" colspan="4"> <strong>{{ trans('labels.tax') }}</strong>
                                    </td>
                                    <td class="text-end"><strong>
                                            {{ helper::currency_formate($invoice->tax, $invoice->vendor_id) }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end" colspan="4">
                                        <strong>{{ trans('labels.discount') }}({{ $invoice->offer_code }})</strong>
                                    </td>
                                    <td class="text-end">
                                        <strong>-{{ helper::currency_formate($invoice->offer_amount, $invoice->vendor_id) }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end" colspan="4">
                                        <strong>{{ trans('labels.grand_total') }}</strong>
                                    </td>
                                    <td class="text-end"><strong>
                                            {{ helper::currency_formate($invoice->grand_total, $invoice->vendor_id) }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
