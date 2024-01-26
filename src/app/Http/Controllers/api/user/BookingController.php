<?php

namespace App\Http\Controllers\api\user;

use App\helper\helper;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Promocode;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Testimonials;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Stripe;



class BookingController extends Controller
{
    public function promocode(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 200);
        }

        $promocodes = Promocode::where('vendor_id', $request->vendor_id)->where('is_available', 1)->get();

        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $promocodes], 200);
    }

    public function payment(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 200);
        }

        $paymentmethod = Payment::select('id', 'environment', 'payment_name', 'currency', 'public_key', 'secret_key', 'encryption_key', 'bank_name', 'account_holder_name', 'account_number', 'bank_ifsc_code', DB::raw("CONCAT('" . url(env('ASSETPATHURL') . 'admin-assets/images/about/payment') . "/', image) AS image"))->where('vendor_id', $request->vendor_id)->where('is_available', 1)->where('is_activate', 1)->get();

        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $paymentmethod], 200);
    }

    public function get_charge(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 200);
        }
        if ($request->product_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.product_id_required')], 200);
        }
        if ($request->start_time == "") {
            return response()->json(["status" => 0, "message" => trans('messages.start_time_required')], 200);
        }
        if ($request->end_time == "") {
            return response()->json(["status" => 0, "message" => trans('messages.end_time_required')], 200);
        }
        if ($request->start_date == "") {
            return response()->json(["status" => 0, "message" => trans('messages.start_date_required')], 200);
        }
        if ($request->end_date == "") {
            return response()->json(["status" => 0, "message" => trans('messages.end_date_required')], 200);
        }

        $checkindate = Carbon::createFromFormat('Y-m-d', $request->start_date)->format('Y-m-d');
        $checkoutdate = Carbon::createFromFormat('Y-m-d', $request->end_date)->format('Y-m-d');
        $product = Product::where('id', $request->product_id)->first();

        $start  = new Carbon($checkindate . $request->start_time);
        $end    = new Carbon($checkoutdate . $request->end_time);

        $diff_in_hours = $start->diffInHours($end);
        if ($start->gt($end)) {
            return response()->json(["status" => 0, "message" => trans('messages.check_out_date_must_be_greater')], 200);
        }
        if ($diff_in_hours < $product->minimum_booking_hour) {
            return response()->json(["status" => 0, "message" => trans('messages.booking_limit') . ' ' . $product->minimum_booking_hour . ' ' . trans('labels.hour')], 200);
        }
        if (($product->per_hour_price != "" || $product->per_hour_price != null) && ($product->per_day_price == "" || $product->per_day_price == null)) {
            $subtotal = (int)$product->per_hour_price * $diff_in_hours;
        }
        if (($product->per_hour_price == "" || $product->per_hour_price == null) && ($product->per_day_price != "" || $product->per_day_price != null)) {
            $diff = Carbon::parse($checkindate)->diffInDays($checkoutdate);
            $subtotal = (int)$product->per_day_price * $diff;
        }
        if (($product->per_hour_price != "" || $product->per_hour_price != null) && ($product->per_day_price != "" || $product->per_day_price != null)) {
            $diff = Carbon::parse($checkindate)->diffInDays($checkoutdate);
            $diffrence = $start->longAbsoluteDiffForHumans($end, 2);
            $explode = explode(' ', $diffrence);
            $days = $explode[0];
            if (Str::contains($diffrence, 'hour') && $diff != 0) {
                $hours = $explode[2];
            } else {
                $hours = 0;
            }
            if ($diff == 0) {
                $subtotal = (int)$product->per_hour_price * $diff_in_hours;
            } else {
                $subtotal = ((int)$product->per_day_price * $days) + ((int)$product->per_hour_price * $hours);
            }
        }

        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'subtotal' => $subtotal, 'day' => $start->longAbsoluteDiffForHumans($end, 2), 'tax' => $product->tax], 200);
    }


    public function get_location(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 200);
        }

        $pickup_location = Location::select('pickup_location')->where('type', 1)->where('is_available', 1)->where('vendor_id', $request->vendor_id)->get();
        $drop_location = Location::select('drop_location')->where('type', 2)->where('is_available', 1)->where('vendor_id', $request->vendor_id)->get();


        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'pickup_location' => $pickup_location, 'drop_location' => $drop_location], 200);
    }

    public function apply_coupon(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 200);
        }
        if ($request->offer_code == "") {
            return response()->json(["status" => 0, "message" => trans('messages.offer_code_required')], 200);
        }
        if ($request->price == "") {
            return response()->json(["status" => 0, "message" => trans('messages.wrong')], 200);
        }

        $getcoupon = Promocode::where('offer_code', $request->offer_code)->where('is_available', '1')->where('vendor_id', $request->vendor_id)->first();
        if (!empty($getcoupon->usage_limit)) {
            $totalcoupon = Booking::where('offer_code', $request->offer_code)->where('vendor_id', $request->vendor_id)->count();
            if ($totalcoupon >= $getcoupon->usage_limit) {
                return response()->json(["status" => 0, "message" => trans('Coupon Limit Exceed')], 200);
            }
        }
        $currentdate = date('Y-m-d');
        if ($request->price < $getcoupon->min_amount) {
            $min_amount = helper::currency_formate($getcoupon->min_amount, $request->vendor_id);
            return response()->json(["status" => 0, "message" => trans('messages.amount_greter_min_amount') . $min_amount], 200);
        } else {
            if ($currentdate > $getcoupon->exp_date) {
                return response()->json(["status" => 0, "message" => trans('messages.coupon_code_expire')], 200);
            } else {
                if ($getcoupon->offer_type == 1) {
                    $offer_amount = $getcoupon->offer_amount;
                } else {
                    $offer_amount = $request->price * $getcoupon->offer_amount / 100;
                }

                return response()->json(['status' => 1, 'message' => trans('messages.success'), 'offer_code' => $getcoupon->offer_code, 'offer_amount' => $offer_amount], 200);
            }
        }
    }


    // Baki che booking API

    public function booking(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 200);
        }
        if ($request->amount == "") {
            return response()->json(["status" => 0, "message" => trans('messages.amount_required')], 200);
        }
        if ($request->payment_type == "") {
            return response()->json(["status" => 0, "message" => trans('messages.payment_type_required')], 200);
        }
        if ($request->customer_name == "") {
            return response()->json(["status" => 0, "message" => trans('messages.customer_name_required')], 200);
        }
        if ($request->customer_email == "") {
            return response()->json(["status" => 0, "message" => trans('messages.customer_email_required')], 200);
        }
        if ($request->customer_mobile == "") {
            return response()->json(["status" => 0, "message" => trans('messages.customer_mobile_required')], 200);
        }
        if ($request->customer_address == "") {
            return response()->json(["status" => 0, "message" => trans('messages.customer_address_required')], 200);
        }
        if ($request->product_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.product_id_required')], 200);
        }
        if ($request->checkin_date == "") {
            return response()->json(["status" => 0, "message" => trans('messages.checkin_date_required')], 200);
        }
        if ($request->checkout_date == "") {
            return response()->json(["status" => 0, "message" => trans('messages.checkout_date_required')], 200);
        }
        if ($request->checkin_time == "") {
            return response()->json(["status" => 0, "message" => trans('messages.checkin_time_required')], 200);
        }
        if ($request->checkout_time == "") {
            return response()->json(["status" => 0, "message" => trans('messages.checkout_time_required')], 200);
        }

        if ($request->checkin_location == "") {
            return response()->json(["status" => 0, "message" => trans('messages.checkin_location_required')], 200);
        }

        if ($request->checkout_location == "") {
            return response()->json(["status" => 0, "message" => trans('messages.checkout_location_required')], 200);
        }

        if ($request->subtotal == "") {
            return response()->json(["status" => 0, "message" => trans('messages.subtotal_required')], 200);
        }

        if ($request->product_image == "") {
            return response()->json(["status" => 0, "message" => trans('messages.product_image_required')], 200);
        }
        $vendordata = User::where('id', $request->vendor_id)->first();
        date_default_timezone_set(helper::appdata($vendordata->id)->timezone);
        $checkplan = helper::checkplan($vendordata->id, 3);
        $v = json_decode(json_encode($checkplan));
        if (@$v->original->status == 2) {
            return response()->json(["status" => 0, "message" => @$v->original->message], 200);
        }
        $checkplan = Transaction::where('vendor_id', $vendordata->id)->orderByDesc('id')->first();
        if ($checkplan->appoinment_limit == -1 || $checkplan->appoinment_limit > 0) {
            $checkindate = Carbon::createFromFormat('Y-m-d', $request->checkin_date)->format('Y-m-d');
            $checkoutdate = Carbon::createFromFormat('Y-m-d', $request->checkout_date)->format('Y-m-d');
            $product = Product::where('id', $request->product_id)->first();
            $start  = new Carbon($checkindate . $request->checkin_time);
            $end    = new Carbon($checkoutdate . $request->checkout_time);
            $diff_in_hours = $start->diffInHours($end);
            if ($start->gt($end)) {
                return response()->json(["status" => 0, "message" => trans('messages.check_out_date_must_be_greater')], 200);
            }
            if ($diff_in_hours < $product->minimum_booking_hour) {
                return response()->json(["status" => 0, "message" => trans('messages.booking_limit') . ' ' . $product->minimum_booking_hour . ' ' . trans('labels.hour')], 200);
            }
            if (($product->per_hour_price != "" || $product->per_hour_price != null) && ($product->per_day_price == "" || $product->per_day_price == null)) {
                $subtotal = (int)$product->per_hour_price * $diff_in_hours;
            }
            if (($product->per_hour_price == "" || $product->per_hour_price == null) && ($product->per_day_price != "" || $product->per_day_price != null)) {
                $diff = Carbon::parse($checkindate)->diffInDays($checkoutdate);
                $subtotal = (int)$product->per_day_price * $diff;
            }
            if (($product->per_hour_price != "" || $product->per_hour_price != null) && ($product->per_day_price != "" || $product->per_day_price != null)) {
                $diff = Carbon::parse($checkindate)->diffInDays($checkoutdate);
                $diffrence = $start->longAbsoluteDiffForHumans($end, 2);
                $explode = explode(' ', $diffrence);
                $days = $explode[0];
                if (Str::contains($diffrence, 'hour') && $diff != 0) {
                    $hours = $explode[2];
                } else {
                    $hours = 0;
                }
                if ($diff == 0) {
                    $subtotal = (int)$product->per_hour_price * $diff_in_hours;
                } else {
                    $subtotal = ((int)$product->per_day_price * $days) + ((int)$product->per_hour_price * $hours);
                }
            }
            $vendordata = User::where('id', $request->vendor_id)->first();
            $checkplan = Transaction::where('vendor_id', $request->vendor_id)->orderByDesc('id')->first();
            // payment_type = COD : 1,RazorPay : 2, Stripe : 3, Flutterwave : 4, Paystack : 5, Mercado Pago : 7, PayPal : 8, MyFatoorah : 9, toyyibpay : 10
            try {
                if ($request->payment_type == "3") {
                    $paymentmethod = Payment::where('type', $request->payment_type)->where('is_available', 1)->where('vendor_id', $request->vendor_id)->first();
                    $stripe = new \Stripe\StripeClient($paymentmethod->secret_key);
                    $gettoken = $stripe->tokens->create([
                        'card' => [
                            'number' => $request->card_number,
                            'exp_month' => $request->card_exp_month,
                            'exp_year' => $request->card_exp_year,
                            'cvc' => $request->card_cvc,
                        ],
                    ]);
                    Stripe\Stripe::setApiKey($paymentmethod->secret_key);
                    $payment = Stripe\Charge::create([
                        "amount" => $request->amount * 100,
                        "currency" => $paymentmethod->currency,
                        "source" => $gettoken->id,
                        "description" => "Rental-SAAS-OrderPayment",
                    ]);
                    $payment_id = $payment->id;
                } else {
                    $payment_id = $request->payment_id;
                }
                $bookinginfo = new Booking();
                $bookinginfo->vendor_id = $request->vendor_id;
                $bookinginfo->user_id = $request->user_id;
                $bookinginfo->product_id = $request->product_id;
                $bookinginfo->booking_number = Str::random(8);
                $bookinginfo->checkin_date = $request->checkin_date;
                $bookinginfo->checkin_time = $request->checkin_time;
                $bookinginfo->checkin_location = $request->checkin_location;
                $bookinginfo->checkout_date = $request->checkout_date;
                $bookinginfo->checkout_time = $request->checkout_time;
                $bookinginfo->checkout_location = $request->checkout_location;
                $bookinginfo->per_day_price = $product->per_day_price;
                $bookinginfo->per_hour_price = $product->per_hour_price;
                $bookinginfo->subtotal = $request->subtotal;
                $bookinginfo->tax = $request->tax;
                $bookinginfo->grand_total = $request->amount;
                $bookinginfo->offer_code = @$request->offer_code;
                $bookinginfo->offer_amount = @$request->offer_amount;
                $bookinginfo->product_image = $request->product_image;
                $bookinginfo->customer_name = $request->customer_name;
                $bookinginfo->customer_email = $request->customer_email;
                $bookinginfo->customer_mobile = $request->customer_mobile;
                $bookinginfo->customer_address = $request->customer_address;
                $bookinginfo->transaction_id = $payment_id;
                $bookinginfo->transaction_type = $request->payment_type;
                $bookinginfo->status = 1;
                $bookinginfo->payment_status = 2;
                $bookinginfo->save();
                $user = User::where('id', $request->vendor_id)->first();
                $traceurl = URL::to($user->slug . '/booking-' . $bookinginfo->booking_number);
                $contacturl = URL::to($user->slug . '/contact');
                $checkmail =  helper::send_mail_forbooking($bookinginfo, $traceurl, $contacturl);
                return response()->json(['status' => 1, 'message' => trans('messages.success'), 'booking_number' => $bookinginfo->booking_number, 'payment_id' => $payment_id], 200);
            } catch (\Throwable $th) {
                return response()->json(['status' => 0, 'message' => trans('messages.error')], 200);
            }
        }
    }
    public function booking_details(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 200);
        }
        if ($request->booking_number == "") {
            return response()->json(["status" => 0, "message" => trans('messages.booking_number_required')], 200);
        }
        $vendordata = User::where('id', $request->vendor_id)->first();
        $booking = Booking::where('booking_number', $request->booking_number)->where('vendor_id', $vendordata->id)->first();
        $product = Product::with('category_info', 'product_image_api')->where('id', $booking->product_id)->first();
        $checkindate = Carbon::createFromFormat('Y-m-d', $booking->checkin_date)->format('Y-m-d');
        $checkoutdate = Carbon::createFromFormat('Y-m-d', $booking->checkout_date)->format('Y-m-d');
        $start = new Carbon($checkindate . $booking->checkin_time);
        $end = new Carbon($checkoutdate . $booking->checkout_time);
        $day = $start->longAbsoluteDiffForHumans($end, 2);
        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'booking' => $booking, 'vendordata' => $vendordata, 'product' => $product, 'day' => $day], 200);
    }
    public function status_update(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 200);
        }
        if ($request->status == "") {
            return response()->json(["status" => 0, "message" => trans('messages.status_required')], 200);
        }
        if ($request->booking_number == "") {
            return response()->json(["status" => 0, "message" => trans('messages.booking_number_required')], 200);
        }
        $booking = Booking::where('booking_number',$request->booking_number)->where('vendor_id',$request->vendor_id)->first();
        $booking->status = $request->status;
        $booking->update();
        return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
    }
    public function reviews(Request $request)
    {
          if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 200);
        }
        $testimonials = Testimonials::select('*',\DB::raw("CONCAT('".url('/storage/app/public/admin-assets/images/testimonials/')."/', image) AS image_url"))->where('vendor_id',$request->vendor_id)->get();
        return response()->json(['status' => 1, 'message' => trans('messages.success'),'reviews' => $testimonials], 200);
    }
}
