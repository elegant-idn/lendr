<div class="table-responsive">
    <table class="table table-striped table-bordered py-3 zero-configuration w-100 dataTable no-footer">
        <thead>
            <tr class="text-uppercase fw-500">
                <td>{{ trans('labels.srno') }}</td>
                @if (request()->is('admin/customers*') && Auth::user()->type == 1)
                    <td>{{ trans('labels.vendor_title') }}</td>
                @endif
                <td>{{ trans('labels.order_number') }}</td>
                <td>{{ trans('labels.product') }}</td>
                <td>{{ trans('labels.checkin_detail') }}</td>
                <td>{{ trans('labels.checkout_detail') }}</td>
                <td>{{ trans('labels.status') }}</td>
                <td>{{ trans('labels.action') }}</td>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($getbookings as $booking)
                <tr class="fs-7">
                    <td>@php
                        echo $i++;
                    @endphp</td>
                    @if (request()->is('admin/customers*') && Auth::user()->type == 1)
                        <td>{{ $booking['vendorinfo']->name }}</td>
                    @endif
                    <td>{{ $booking->booking_number }}</td>
                    <td>
                        <a href="{{ URL::to('/admin/invoice-' . $booking->booking_number) }} ">
                            <p class="fw-bold">{{ $booking['product_info']->title }}</p>
                        </a>
                    </td>
                    <td>{{ helper::date_formate($booking->checkin_date) }}
                        {{date("g:i a", strtotime($booking->checkin_time))}}<br><small>{{ $booking->checkin_location }}</small>
                    </td>
                    <td>{{ helper::date_formate($booking->checkout_date) }}
                        {{date("g:i a", strtotime($booking->checkout_time))}}<br><small>{{ $booking->checkout_location }}</small>
                    </td>
                    <td>
                        @if ($booking->status == 1)
                            @php
                                $status = trans('labels.pending');
                                $color = 'warning';
                            @endphp
                        @elseif ($booking->status == 2)
                            @php
                                $status = trans('labels.accepted');
                                $color = 'info';
                            @endphp
                        @elseif ($booking->status == 3)
                            @php
                                $status = trans('labels.in_progress');
                                $color = 'info';
                            @endphp
                        @elseif ($booking->status == 4)
                            @php
                                $status = trans('labels.rejected');
                                $color = 'danger';
                            @endphp
                        @elseif ($booking->status == 5)
                            @php
                                $status = trans('labels.canceled');
                                $color = 'danger';
                            @endphp
                        @elseif ($booking->status == 6)
                            @php
                                $status = trans('labels.completed');
                                $color = 'success';
                            @endphp
                        @endif
                        <span class="badge bg-{{ $color }}">{{ $status }}</span>
                    <td>
                        <div class="d-flex align-items-center">
                            <a class="btn btn-sm btn-primary mx-2" title="View"
                                href="{{ URL::to('/admin/invoice-' . $booking->booking_number) }} "><i class="fa-regular fa-eye"></i></a>
                        </div>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="modal fade" id="payment_modal" tabindex="-1" aria-labelledby="payment_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payment_modal">{{ trans('labels.payment') }} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action=" {{ URL::to('admin/bookings/payment_status-' . '2') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id="booking_number" name="booking_number" value="">
                        <label for="total">{{ trans('labels.price') }}<span class="text-danger"> * </span></label>
                        <input type="text" class="form-control" id="total" name="total" value=""
                            readonly>
                    </div>
                    @error('total')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary">{{ trans('labels.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
