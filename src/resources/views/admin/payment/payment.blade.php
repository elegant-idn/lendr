@extends('admin.layout.default')

@section('content')
    <div class="d-flex align-items-center mb-3">

        <h5 class="text-uppercase">{{ trans('labels.payment_settings') }}</h5>

    </div>

    <div class="row">

        <div class="col-12">

            <div class="card border-0">

                <div class="card-body">

                    <form action="{{ URL::to('admin/payment/update') }}" method="POST" class="payments"
                        enctype="multipart/form-data">

                        @csrf

                        <div class="accordion accordion-flush" id="accordionExample">

                            @php
                                
                                $i = 1;
                                
                            @endphp

                            @foreach ($getpayment as $key => $pmdata)
                                @php
                                    
                                    $transaction_type = strtolower($pmdata->payment_name);
                                    
                                    $image_tag_name = $transaction_type . '_image';
                                    
                                @endphp

                                <input type="hidden" name="transaction_type[]" value="{{ $pmdata->id }}">

                                <div
                                    class="accordion-item card rounded border mb-3 {{ $transaction_type == 'cod' && Auth::user()->type == 1 ? 'd-none' : '' }} {{ $transaction_type == 'banktransfer' && Auth::user()->type == 2 ? 'd-none' : '' }}">

                                    <h2 class="accordion-header" id="heading{{ $transaction_type }}">

                                        <button
                                            class="{{ session()->get('direction') == 2 ? 'accordion-button-rtl' : 'accordion-button' }} rounded collapsed"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#targetto-{{ $i }}-{{ $transaction_type }}"
                                            aria-expanded="false"
                                            aria-controls="targetto-{{ $i }}-{{ $transaction_type }}">

                                            <b>{{ trans('labels.' . $transaction_type) }}
                                                @if (
                                                    $transaction_type == 'mercadopago' ||
                                                        $transaction_type == 'paypal' ||
                                                        $transaction_type == 'myfatoorah' ||
                                                        $transaction_type == 'toyyibpay')
                                                    @if (env('Environment') == 'sendbox')
                                                        <span
                                                            class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                    @endif
                                                @endif
                                            </b>

                                        </button>

                                    </h2>

                                    <div id="targetto-{{ $i }}-{{ $transaction_type }}"
                                        class="accordion-collapse collapse"
                                        aria-labelledby="heading{{ $transaction_type }}"
                                        data-bs-parent="#accordionExample">

                                        <div class="accordion-body">

                                            <div class="row">

                                                @if ($transaction_type == 'banktransfer')
                                                    <div class="col-md-6">

                                                        <div class="form-group">

                                                            <label class="form-label">

                                                                {{ trans('labels.bank_name') }} <span class="text-danger">
                                                                    *</span> </label>

                                                            <input type="text" class="form-control" name="bank_name"
                                                                placeholder="{{ trans('labels.bank_name') }}"
                                                                value="{{ $pmdata->bank_name }}"
                                                                {{ Auth::user()->type == 1 ? 'required' : '' }}>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="form-group">

                                                            <label class="form-label">

                                                                {{ trans('labels.account_holder_name') }} <span
                                                                    class="text-danger"> *</span> </label>

                                                            <input type="text" class="form-control"
                                                                name="account_holder_name"
                                                                placeholder="{{ trans('labels.account_holder_name') }}"
                                                                value="{{ $pmdata->account_holder_name }}"
                                                                {{ Auth::user()->type == 1 ? 'required' : '' }}>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="form-group">

                                                            <label class="form-label">

                                                                {{ trans('labels.account_number') }} <span
                                                                    class="text-danger"> *</span></label>

                                                            <input type="text" class="form-control" name="account_number"
                                                                placeholder="{{ trans('labels.account_number') }}"
                                                                value="{{ $pmdata->account_number }}"
                                                                {{ Auth::user()->type == 1 ? 'required' : '' }}>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="form-group">

                                                            <label class="form-label">

                                                                {{ trans('labels.bank_ifsc_code') }} <span
                                                                    class="text-danger"> *</span></label>

                                                            <input type="text" class="form-control" name="bank_ifsc_code"
                                                                placeholder="{{ trans('labels.bank_ifsc_code') }}"
                                                                value="{{ $pmdata->bank_ifsc_code }}"
                                                                {{ Auth::user()->type == 1 ? 'required' : '' }}>

                                                        </div>

                                                    </div>
                                                @endif

                                                @if (in_array($transaction_type, [
                                                        'razorpay',
                                                        'stripe',
                                                        'flutterwave',
                                                        'paystack',
                                                        'mercadopago',
                                                        'paypal',
                                                        'myfatoorah',
                                                        'toyyibpay',
                                                    ]))
                                                    <div class="col-md-6">

                                                        <p class="form-label">{{ trans('labels.environment') }}</p>

                                                        <div class="form-check form-check-inline">

                                                            <input class="form-check-input" type="radio"
                                                                name="environment[{{ $transaction_type }}]"
                                                                id="{{ $transaction_type }}_{{ $key }}_environment"
                                                                value="1"
                                                                {{ $pmdata->environment == 1 ? 'checked' : '' }}>

                                                            <label class="form-check-label"
                                                                for="{{ $transaction_type }}_{{ $key }}_environment">

                                                                {{ trans('labels.sandbox') }} </label>

                                                        </div>

                                                        <div class="form-check form-check-inline">

                                                            <input class="form-check-input" type="radio"
                                                                name="environment[{{ $transaction_type }}]"
                                                                id="{{ $transaction_type }}_{{ $i }}_environment"
                                                                value="2"
                                                                {{ $pmdata->environment == 2 ? 'checked' : '' }}>

                                                            <label class="form-check-label"
                                                                for="{{ $transaction_type }}_{{ $i }}_environment">

                                                                {{ trans('labels.production') }} </label>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6 d-flex justify-content-end align-items-center">

                                                        <input id="checkbox-switch-{{ $transaction_type }}" type="checkbox"
                                                            class="checkbox-switch"
                                                            name="is_available[{{ $transaction_type }}]" value="1"
                                                            {{ $pmdata->is_available == 1 ? 'checked' : '' }}>

                                                        <label for="checkbox-switch-{{ $transaction_type }}"
                                                            class="switch">

                                                            <span
                                                                class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                    class="switch__circle-inner"></span></span>

                                                            <span
                                                                class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>

                                                            <span
                                                                class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>

                                                        </label>

                                                    </div>

                                                    <div
                                                        class="col-md-6 {{ $transaction_type == 'mercadopago' ? 'd-none' : '' }}  {{ $transaction_type == 'myfatoorah' ? 'd-none' : '' }}">

                                                        <div class="form-group">

                                                            <label for="{{ $transaction_type }}_publickey"
                                                                class="form-label">

                                                                {{ trans('labels.public_key') }} <span
                                                                    class="text-danger"> *</span></label>

                                                            <input type="text" id="{{ $transaction_type }}_publickey"
                                                                class="form-control"
                                                                name="public_key[{{ $transaction_type }}]"
                                                                placeholder="{{ trans('labels.public_key') }}"
                                                                value="{{ $pmdata->public_key }}">

                                                        </div>

                                                    </div>

                                                    <div
                                                        class=" {{ $transaction_type == 'mercadopago' ? 'col-md-12' : 'col-md-6' }} {{ $transaction_type == 'myfatoorah' ? 'col-md-12' : 'col-md-6' }}">

                                                        <div class="form-group">

                                                            <label for="{{ $transaction_type }}_secretkey"
                                                                class="form-label">

                                                                {{ trans('labels.secret_key') }} <span
                                                                    class="text-danger"> *</span></label>

                                                            <input type="text" required
                                                                id="{{ $transaction_type }}_secretkey"
                                                                class="form-control"
                                                                name="secret_key[{{ $transaction_type }}]"
                                                                placeholder="{{ trans('labels.secret_key') }}"
                                                                value="{{ $pmdata->secret_key }}">

                                                        </div>

                                                    </div>

                                                    @if ($transaction_type == 'flutterwave')
                                                        <div class="col-md-12">

                                                            <div class="form-group">

                                                                <label for="encryption_key"
                                                                    class="form-label">{{ trans('labels.encryption_key') }}
                                                                    <span class="text-danger"> *</span>

                                                                </label>

                                                                <input type="text" id="encryptionkey"
                                                                    class="form-control" name="encryption_key"
                                                                    placeholder="{{ trans('labels.encryption_key') }}"
                                                                    value="{{ $pmdata->encryption_key }}">

                                                            </div>

                                                        </div>
                                                    @endif

                                                    <div class="col-md-6">

                                                        <div class="form-group">

                                                            <label for="image" class="form-label">

                                                                {{ trans('labels.image') }} </label>

                                                            <input type="file" class="form-control"
                                                                name="{{ $image_tag_name }}">

                                                            <img src="{{ helper::image_path($pmdata->image) }}"
                                                                alt="" class="img-fluid rounded hw-50 mt-1">

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="form-group">

                                                            <label for="{{ $transaction_type }}currency"
                                                                class="form-label"> {{ trans('labels.currency') }} <span
                                                                    class="text-danger"> *</span>

                                                            </label>

                                                            <input type="text" required
                                                                id="{{ $transaction_type }}currency" class="form-control"
                                                                name="currency[{{ $transaction_type }}]"
                                                                placeholder="{{ trans('labels.currency') }}"
                                                                value="{{ $pmdata->currency }}">

                                                        </div>

                                                    </div>
                                                @else
                                                    <div class="col-md-6">

                                                        <div class="form-group">

                                                            <label for="image" class="form-label">

                                                                {{ trans('labels.image') }} </label>

                                                            <input type="file" class="form-control"
                                                                name="{{ $image_tag_name }}">

                                                            <img src="{{ helper::image_path($pmdata->image) }}"
                                                                alt="" class="img-fluid rounded hw-50 mt-1">

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6 d-flex justify-content-end align-items-center">

                                                        <input id="checkbox-switch-{{ $transaction_type }}"
                                                            type="checkbox" class="checkbox-switch"
                                                            name="is_available[{{ $transaction_type }}]" value="1"
                                                            {{ $pmdata->is_available == 1 ? 'checked' : '' }}>

                                                        <label for="checkbox-switch-{{ $transaction_type }}"
                                                            class="switch">

                                                            <span
                                                                class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                    class="switch__circle-inner"></span></span>

                                                            <span
                                                                class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>

                                                            <span
                                                                class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>

                                                        </label>

                                                    </div>
                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                </div>
                            @endforeach

                        </div>

                        <div class="form-group text-end">

                            <button class="btn btn-secondary"
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>
@endsection

@section('scripts')
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/payment.js') }}"></script>
@endsection
