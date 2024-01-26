@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')
    <div class="row">

    </div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 my-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered py-3 zero-configuration w-100">
                            <thead>
                                <tr class="text-uppercase fw-500">
                                    <td>{{ trans('labels.srno') }}</td>
                                    @if (Auth::user()->type == 1)
                                        <td>{{ trans('labels.name') }}</td>
                                    @endif
                                    <td>{{ trans('labels.plan') }}</td>
                                    <td>{{ trans('labels.amount') }}</td>
                                    <td>{{ trans('labels.payment_type') }}</td>
                                    <td>{{ trans('labels.purchase_date') }}</td>
                                    <td>{{ trans('labels.expire_date') }}</td>
                                    <td>{{ trans('labels.status') }}</td>
                                    @if (Auth::user()->type == '1')
                                        <td>{{ trans('labels.action') }}</td>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($transaction as $transaction)
                                    <tr class="fs-7">
                                        <td>@php
                                            echo $i++;
                                        @endphp</td>
                                        @if (Auth::user()->type == 1)
                                            <td>{{ @$transaction['vendor_info']->name }}</td>
                                        @endif
                                        <td>{{ @$transaction['plan_info']->name }}</td>
                                        <td>{{ helper::currency_formate($transaction->amount, '') }}</td>
                                        <td>
                                            @if ($transaction->payment_type == 'banktransfer')
                                                {{ trans('labels.' . $transaction->payment_type) }}
                                                : <small><a href="{{ helper::image_path($transaction->screenshot) }}"
                                                        target="_blank"
                                                        class="text-danger">{{ trans('labels.click_here') }}</a></small>
                                            @elseif($transaction->payment_type != '')
                                                {{-- payment_type = COD : 1,RazorPay : 2, Stripe : 3, Flutterwave : 4, Paystack : 5, Mercado Pago : 7, PayPal : 8, MyFatoorah : 9, toyyibpay : 10 --}}
                                                @if ($transaction->payment_type == 1)
                                                    {{ trans('labels.offline') }}
                                                @endif
                                                @if ($transaction->payment_type == 2)
                                                    {{ trans('labels.razorpay') }} : {{ $transaction->payment_id }}
                                                @endif
                                                @if ($transaction->payment_type == 3)
                                                    {{ trans('labels.stripe') }} : {{ $transaction->payment_id }}
                                                @endif
                                                @if ($transaction->payment_type == 4)
                                                    {{ trans('labels.flutterwave') }} : {{ $transaction->payment_id }}
                                                @endif
                                                @if ($transaction->payment_type == 5)
                                                    {{ trans('labels.paystack') }} : {{ $transaction->payment_id }}
                                                @endif
                                                @if ($transaction->payment_type == 7)
                                                    {{ trans('labels.mercadopago') }} : {{ $transaction->payment_id }}
                                                @endif
                                                @if ($transaction->payment_type == 8)
                                                    {{ trans('labels.paypal') }} : {{ $transaction->payment_id }}
                                                @endif
                                                @if ($transaction->payment_type == 9)
                                                    {{ trans('labels.myfatoorah') }} : {{ $transaction->payment_id }}
                                                @endif
                                                @if ($transaction->payment_type == 10)
                                                    {{ trans('labels.toyyibpay') }} : {{ $transaction->payment_id }}
                                                @endif
                                            @elseif($transaction->amount == 0)
                                                -
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($transaction->payment_type == 'banktransfer')
                                                @if ($transaction->status == 2)
                                                    <span
                                                        class="badge bg-success">{{ helper::date_formate($transaction->purchase_date) }}</span>
                                                @else
                                                    -
                                                @endif
                                            @else
                                                <span
                                                    class="badge bg-success">{{ helper::date_formate($transaction->purchase_date) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($transaction->duration != '5')
                                                @if ($transaction->payment_type == 'banktransfer')
                                                    @if ($transaction->status == 2)
                                                        <span
                                                            class="badge bg-danger">{{ helper::date_formate($transaction->expire_date) }}</span>
                                                    @else
                                                        -
                                                    @endif
                                                @else
                                                    <span
                                                        class="badge bg-danger">{{ helper::date_formate($transaction->expire_date) }}</span>
                                                @endif
                                            @else 
                                                {{ trans('labels.lifetime') }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($transaction->payment_type == 'banktransfer')
                                                @if ($transaction->status == 1)
                                                    <span class="badge bg-warning">{{ trans('labels.pending') }}</span>
                                                @elseif ($transaction->status == 2)
                                                    <span class="badge bg-success">{{ trans('labels.accepted') }}</span>
                                                @elseif ($transaction->status == 3)
                                                    <span class="badge bg-danger">{{ trans('labels.rejected') }}</span>
                                                @else
                                                    -
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        @if (Auth::user()->type == '1')
                                            <td>
                                                @if ($transaction->payment_type == 'banktransfer')
                                                    @if ($transaction->status == 1)
                                                        <a class="btn btn-sm btn-outline-success"
                                                            onclick="statusupdate('{{ URL::to('admin/transaction-' . $transaction->id . '-2') }}')"><i
                                                                class="fas fa-check"></i></a>
                                                        <a class="btn btn-sm btn-outline-danger"
                                                            onclick="statusupdate('{{ URL::to('admin/transaction-' . $transaction->id . '-3') }}')"><i
                                                                class="fas fa-close"></i></a>
                                                    @else
                                                        -
                                                    @endif
                                                @else
                                                    -
                                                @endif

                                            </td>
                                        @endif
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
