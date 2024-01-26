<?php

namespace App\helper;

use App\Models\Booking;
use App\Models\Settings;
use App\Models\User;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\PricingPlan;
use App\Models\Country;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Stripe;
use URL;

class helper
{
    // admin
    public static function appdata($vendor_id)
    {
        if (file_exists(storage_path('installed'))) {
            $data = Settings::first();
            if (!empty($vendor_id)) {
                $data = Settings::where('vendor_id', $vendor_id)->first();
            }
            return $data;
        } else {
            return redirect('install');
            exit;
        }
    }
    public static function currency_formate($price, $vendor_id)
    {
        $price = floatval($price);
        if (@helper::appdata($vendor_id)->currency_position == "1") {
            return @helper::appdata($vendor_id)->currency . number_format($price, 2);
        }
        if (@helper::appdata($vendor_id)->currency_position == "2") {
            return number_format($price, 2) . @helper::appdata($vendor_id)->currency;
        }
        return $price;
    }
    // email-----------------------------------------
    public static function send_mail_forpassword($email, $password, $logo)
    {
        $data = ['title' => trans('labels.email_verification'), 'email' => $email, 'name' => $email, 'password' => $password, 'logo' => helper::image_path($logo)];
        try {
            Mail::send('email.sendpassword', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['email']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function send_mail_forotp($name, $email, $otp, $logo)
    {
        $data = ['title' => trans('labels.email_verification'), 'email' => $email, 'name' => $name, 'otp' => $otp, 'logo' => helper::image_path($logo)];
        try {
            Mail::send('email.otpverification', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['email']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function send_mail_forbooking($booking_info, $traceurl, $contacturl)
    {
        $vendor_email = User::where('id', $booking_info->vendor_id)->first();
        $data = $booking_info->toArray();
        $data['title'] = "Order Invoice";
        $data['traceurl'] = $traceurl;
        $data['contacturl'] = $contacturl;
        $data['company_name'] = helper::appdata($vendor_email->vendor_id)->web_title;
        $data['vendor_email'] = $vendor_email->email;
        try {
            Mail::send('email.emailinvoice', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['customer_email']);
            });
            Mail::send('email.bookinginvoice', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['vendor_email']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 1;
        }
    }
    public static function booking_status_email($email, $name, $title, $message_text, $vendor)
    {
        $data = ['email' => $email, 'name' => $name, 'title' => $title,'vendor' => $vendor->name, 'message_text' => $message_text,'logo' => helper::image_path(@helper::appdata($vendor->id)->logo)];
        try {
            Mail::send('email.bookingstatus', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['email']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function send_subscription_email($vendor_email, $vendor_name, $plan_name, $duration, $price, $payment_method, $transaction_id)
    {
        $admininfo = User::where('id', '1')->first();
        $data = ['title' => "Subscription Purchase Confirmation", 'vendor_email' => $vendor_email, 'vendor_name' => $vendor_name, 'admin_email' => $admininfo->email, 'admin_name' => $admininfo->name, 'plan_name' => $plan_name, 'duration' => $duration, 'price' => $price, 'payment_method' => $payment_method, 'transaction_id' => $transaction_id];
        $adminemail = ['title' => "New Subscription Purchase Notification", 'vendor_email' => $vendor_email, 'vendor_name' => $vendor_name, 'admin_email' => $admininfo->email, 'admin_name' => $admininfo->name, 'plan_name' => $plan_name, 'duration' => $duration, 'price' => $price, 'payment_method' => $payment_method, 'transaction_id' => $transaction_id];
        try {
            Mail::send('email.subscription', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['vendor_email']);
            });
            Mail::send('email.adminsubscription', $adminemail, function ($message) use ($adminemail) {
                $message->from(env('MAIL_USERNAME'))->subject($adminemail['title']);
                $message->to($adminemail['admin_email']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function bank_transfer_request($vendor_email, $vendor_name, $admin_email, $admin_name)
    {
        $adminemail = ['title' => "Bank transfer", 'vendor_email' => $vendor_email, 'vendor_name' => $vendor_name, 'admin_email' => $admin_email, 'admin_name' => $admin_name];
        $data = ['title' => "Bank transfer", 'vendor_email' => $vendor_email, 'vendor_name' => $vendor_name, 'admin_email' => $admin_email, 'admin_name' => $admin_name];
        try {
            Mail::send('email.banktransfervendor', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['vendor_email']);
            });
            Mail::send('email.banktransferadmin', $adminemail, function ($message) use ($adminemail) {
                $message->from(env('MAIL_USERNAME'))->subject($adminemail['title']);
                $message->to($adminemail['admin_email']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function subscription_rejected($vendor_email, $vendor_name, $plan_name, $payment_method)
    {
        $admindata = User::select('name', 'email')->where('id', '1')->first();
        $data = ['title' => "Bank transfer rejected", 'vendor_email' => $vendor_email, 'vendor_name' => $vendor_name, 'admin_email' => $admindata->email, 'admin_name' => $admindata->name, 'plan_name' => $plan_name, 'payment_method' => $payment_method];
        try {
            Mail::send('email.banktransferreject', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['vendor_email']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function send_pass($email, $name, $password, $id)
    {
        $data = ['title' => "New Password", 'email' => $email, 'name' => $name, 'password' => $password, 'logo' => @helper::appdata($id)->logo];
        try {
            Mail::send('email.sendpassword', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['email']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function vendor_contact_data($vendor_name, $vendor_email, $full_name, $useremail, $usermobile, $usermessage)
    {
        $data = ['title' => "Inquiry", 'vendor_name' => $vendor_name, 'vendor_email' => $vendor_email, 'full_name' => $full_name, 'useremail' => $useremail, 'usermobile' => $usermobile, 'usermessage' => $usermessage];
        try {
            Mail::send('email.vendorcontcatform', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['vendor_email']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    // email ------------------
    public static function date_formate($date)
    {
        return date("d M, Y", strtotime($date));
    }

    public static function checkplan($id, $type)
    {
        date_default_timezone_set('America/New_York');
        $vendordata = User::where('id', $id)->first();
        $checkplan = Transaction::where('vendor_id', $vendordata->id)->orderByDesc('id')->first();
        $totalservice = Product::where('vendor_id', $vendordata->id)->count();
        if ($vendordata->allow_without_subscription != 1) {
            if (!empty($checkplan)) {
                if ($vendordata->is_available == 2) {
                    return response()->json(['status' => 2, 'message' => trans('messages.account_blocked_by_admin'), 'showclick' => "0", 'plan_message' => '', 'plan_date' => '', 'checklimit' => ''], 200);
                }
                if ($checkplan->payment_type == 'banktransfer') {
                    if ($checkplan->status == 1) {
                        return response()->json(['status' => 2, 'message' => trans('messages.bank_request_pending'), 'showclick' => "0", 'plan_message' => trans('messages.bank_request_pending'), 'plan_date' => '', 'checklimit' => ''], 200);
                    } elseif ($checkplan->status == 3) {
                        return response()->json(['status' => 2, 'message' => trans('messages.bank_request_rejected'), 'showclick' => "1", 'plan_message' => trans('messages.bank_request_rejected'), 'plan_date' => '', 'checklimit' => ''], 200);
                    }
                }
                if ($checkplan->expire_date != "") {
                    if (date('Y-m-d') > $checkplan->expire_date) {
                        return response()->json(['status' => 2, 'message' => trans('messages.plan_expired'), 'expdate' => $checkplan->expire_date, 'showclick' => "1", 'plan_message' => trans('messages.plan_expired'), 'plan_date' => $checkplan->expire_date, 'checklimit' => ''], 200);
                    }
                }
                if (Str::contains(request()->url(), 'admin')) {
                    if ($checkplan->service_limit != -1) {
                        if ($totalservice >= $checkplan->service_limit) {
                            if (Auth::user()->type == 1) {
                                return response()->json(['status' => 2, 'message' => trans('messages.products_limit_exceeded'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => '', 'checklimit' => ''], 200);
                            }
                            if (Auth::user()->type == 2) {
                                if ($checkplan->expire_date != "") {
                                   
                                    return response()->json(['status' => 2, 'message' => trans('messages.vendor_products_limit_message'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => $checkplan->expire_date, 'checklimit' => 'service'], 200);
                                } else {
                                    return response()->json(['status' => 2, 'message' => trans('messages.vendor_products_limit_message'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.lifetime_subscription'), 'plan_date' => $checkplan->expire_date, 'checklimit' => 'service'], 200);
                                }
                            }
                        }
                    }
                    if ($checkplan->appoinment_limit != -1) {
                        if ($checkplan->appoinment_limit <= 0) {
                            if (Auth::user()->type == 1) {
                                return response()->json(['status' => 2, 'message' => trans('messages.order_limit_exceeded'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => '', 'checklimit' => ''], 200);
                            }
                            if (Auth::user()->type == 2) {
                                if ($checkplan->expire_date != "") {
                                    return response()->json(['status' => 2, 'message' => trans('messages.vendor_order_limit_message'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => $checkplan->expire_date, 'checklimit' => 'booking'], 200);
                                } else {
                                    return response()->json(['status' => 2, 'message' => trans('messages.vendor_order_limit_message'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.lifetime_subscription'), 'plan_date' => $checkplan->expire_date, 'checklimit' => 'service'], 200);
                                }
                            }
                        }
                    }
                }
                if (@$type == 3) {
                    if ($checkplan->appoinment_limit != -1) {
                        if ($checkplan->appoinment_limit <= 0) {
                            return response()->json(['status' => 2, 'message' => trans('messages.front_store_unavailable'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => '', 'checklimit' => 'booking'], 200);
                        }
                    }
                }
                if ($checkplan->expire_date != "") {
                    return response()->json(['status' => 1, 'message' => trans('messages.plan_expires'), 'expdate' => $checkplan->expire_date, 'showclick' => "0", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => $checkplan->expire_date, 'checklimit' => ''], 200);
                } else {
                    return response()->json(['status' => 1, 'message' => trans('messages.lifetime_subscription'), 'expdate' => $checkplan->expire_date, 'showclick' => "0", 'plan_message' => trans('messages.lifetime_subscription'), 'plan_date' => $checkplan->expire_date, 'checklimit' => ''], 200);
                }
            } else {
                if (Auth::user()->type == 1) {
                    return response()->json(['status' => 2, 'message' => trans('messages.doesnot_select_any_plan'), 'expdate' => '', 'showclick' => "0", 'plan_message' => '', 'plan_date' => '', 'checklimit' => ''], 200);
                }
                if (Auth::user()->type == 2) {
                    return response()->json(['status' => 2, 'message' => trans('messages.vendor_plan_purchase_message'), 'expdate' => '', 'showclick' => "1", 'plan_message' => '', 'plan_date' => '', 'checklimit' => ''], 200);
                }
            }
        }
    }
 
    public static function image_path($image)
    {

        $url = url(env('ASSETPATHURL') . 'admin-assets/images/about/dummy.jpg');
        if (Str::contains($image, 'profile')) {
            $url = url(env('ASSETPATHURL') . 'admin-assets/images/profile/' . $image);
        }
        if (Str::contains($image, 'category')) {
            $url = url(env('ASSETPATHURL') . 'admin-assets/images/categories/' . $image);
        }
        if (Str::contains($image, 'product')) {
            $url = url(env('ASSETPATHURL') . 'admin-assets/images/product/' . $image);
        }
        if (Str::contains($image, 'theme-')) {
            $url = url(env('ASSETPATHURL') . 'admin-assets/images/theme/' . $image);
        }
        if (Str::contains($image, 'feature-')) {
            $url = url(env('ASSETPATHURL') . 'admin-assets/images/feature/' . $image);
        }
        if (Str::contains($image, 'testimonial-')) {
            $url = url(env('ASSETPATHURL') . 'admin-assets/images/testimonials/' . $image);
        }
        if (Str::contains($image, 'gallery-')) {
            $url = url(env('ASSETPATHURL') . 'admin-assets/images/gallery/' . $image);
        }
        if (Str::contains($image, 'choose-') || Str::contains($image, 'faq-')) {
            $url = url(env('ASSETPATHURL') . 'admin-assets/images/index/' . $image);
        }
        if (Str::contains($image, 'payment')  || Str::contains($image, 'cod') || Str::contains($image, 'stripe') || Str::contains($image, 'paystack') || Str::contains($image, 'razorpay') || Str::contains($image, 'wallet') || Str::contains($image, 'flutterwave') || Str::contains($image, 'bank') || Str::contains($image, 'mercadopago') || Str::contains($image, 'paypal') || Str::contains($image, 'myfatoorah') || Str::contains($image, 'toyyibpay')) {
            $url = url(env('ASSETPATHURL') . 'admin-assets/images/about/payment/' . $image);
        }
        if (Str::contains($image, 'screenshot')) {
            $url = url('storage/app/public/admin-assets/images/screenshot/' . $image);
        }
        if (Str::contains($image, 'logo')) {
            $url = url(env('ASSETPATHURL') . 'admin-assets/images/about/logo/' . $image);
        }
        if (Str::contains($image, 'favicon-')) {
            $url = url(env('ASSETPATHURL') . 'admin-assets/images/about/favicon/' . $image);
        }
        if (Str::contains($image, 'og_image')) {
            $url = url(env('ASSETPATHURL') . 'admin-assets/images/about/og_image/' . $image);
        }
        if (Str::contains($image, 'banner') || Str::contains($image, 'promotion') || Str::contains($image, 'listing') ) {
            $url = url(env('ASSETPATHURL') . 'admin-assets/images/banner/' . $image);
        }
        if (Str::contains($image, 'blog')) {
            $url = url(env('ASSETPATHURL') . 'admin-assets/images/blog/' . $image);
        }
        if (Str::contains($image, 'flag')) {
            $url = url(env('ASSETPATHURL') . 'admin-assets/images/language/' . $image);
        }
        if (Str::contains($image, 'auth')) {
            $url = url(env('ASSETPATHURL') . 'admin-assets/images/authimage/' . $image);
        }
        if (Str::contains($image, 'cover')) {
            $url = url(env('ASSETPATHURL') . 'admin-assets/images/coverimage/' . $image);
        }
        if (Str::contains($image, 'login') || Str::contains($image, 'default') || Str::contains($image, 'home')) {
            $url = url(env('ASSETPATHURL') . 'admin-assets/images/about/' . $image);
        }
        return $url;
    }
    public static function get_plan_exp_date($duration, $days)
    {
        date_default_timezone_set(helper::appdata('')->timezone);
        $purchasedate = date("Y-m-d h:i:sa");
        $exdate = "";
        if (!empty($duration) && $duration != "") {
            if ($duration == "1") {
                $exdate = date('Y-m-d', strtotime($purchasedate . ' + 30 days'));
            }
            if ($duration == "2") {
                $exdate = date('Y-m-d', strtotime($purchasedate . ' + 90 days'));
            }
            if ($duration == "3") {
                $exdate = date('Y-m-d', strtotime($purchasedate . ' + 180 days'));
            }
            if ($duration == "4") {
                $exdate = date('Y-m-d', strtotime($purchasedate . ' + 365 days'));
            }
            if ($duration == "5") {
                $exdate = "";
            }
        }
        if (!empty($days) && $days != "") {
            $exdate = date('Y-m-d', strtotime($purchasedate . ' + ' . $days .  'days'));
        }
        return $exdate;
    }
    // front
    public static function vendor_data($slug)
    {
        $vendordata = User::where('slug', $slug)->first();
        return $vendordata;
    }
    public static function push_notification($token,$title,$body,$type,$order_id)
    {   
        $customdata = array(
            "type" => $type,
            "order_id" => $order_id,
        );
        
        $msg = array(
            'body' =>$body,
            'title'=>$title,
            'sound'=>1/*Default sound*/
        );
        $fields = array(
            'to'           =>$token,
            'notification' =>$msg,
            'data'=> $customdata
        );
        $headers = array(
            'Authorization: key=' . @helper::appdata('')->firebase,
            'Content-Type: application/json'
        );
        #Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $firebaseresult = curl_exec ( $ch );
        curl_close ( $ch );
        
        return $firebaseresult;
    }

    public static function payment($amount, $payment_id, $payment_type, $booking_number, $customer_name, $customer_email, $customer_mobile, $customer_address,$slug,$offer_code,$offer_amount)
    {
        
        try {
            if ($payment_type == "3") {
                $paymentmethod = Payment::where('id', $payment_type)->where('is_available', 1)->first();
                Stripe\Stripe::setApiKey($paymentmethod->secret_key);
                $charge = Stripe\Charge::create([
                    'amount' => $amount * 100,
                    'currency' => $paymentmethod->currency,
                    'description' => 'Example charge',
                    'source' => $payment_id,
                ]);
                $payment_id = $charge->id;
            } else {
                $payment_id = $payment_id;
            }
            $bookinginfo = new Booking();
            $bookinginfo->vendor_id = session()->get('booking')['vendor_id'];
            $bookinginfo->user_id = session()->get('booking')['user_id'];
            $bookinginfo->product_id = session()->get('booking')['product_id'];
            $bookinginfo->booking_number = session()->get('booking')['booking_number'];
            $bookinginfo->checkin_date = session()->get('booking')['checkin_date'];
            $bookinginfo->checkin_time = session()->get('booking')['checkin_time'];
            $bookinginfo->checkin_location = session()->get('booking')['checkin_location'];
            $bookinginfo->checkout_date = session()->get('booking')['checkout_date'];
            $bookinginfo->checkout_time = session()->get('booking')['checkout_time'];
            $bookinginfo->checkout_location = session()->get('booking')['checkout_location'];
            $bookinginfo->per_day_price = session()->get('booking')['per_day_price'];
            $bookinginfo->per_hour_price = session()->get('booking')['per_hour_price'];
            $bookinginfo->subtotal = session()->get('booking')['subtotal'];
            $bookinginfo->tax = session()->get('booking')['tax'];
            $bookinginfo->grand_total = $amount;
            $bookinginfo->offer_code = $offer_code;
            $bookinginfo->offer_amount = $offer_amount;
            $bookinginfo->product_image = session()->get('booking')['product_image'];
            $bookinginfo->customer_name = $customer_name;
            $bookinginfo->customer_email = $customer_email;
            $bookinginfo->customer_mobile = $customer_mobile;
            $bookinginfo->customer_address = $customer_address;
            $bookinginfo->transaction_id = $payment_id;
            $bookinginfo->transaction_type = $payment_type;
            $bookinginfo->status= 1;
            $bookinginfo->payment_status = 2;
            $bookinginfo->save();
            $user = User::where('id',session()->get('booking')['vendor_id'])->first();
            $traceurl = URL::to($user->slug . '/booking-' . $bookinginfo->booking_number);
            $contacturl = URL::to($user->slug . '/contact');
            $checkmail =  helper::send_mail_forbooking($bookinginfo, $traceurl, $contacturl);
           
            return $bookinginfo;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function vendor_register($vendor_name, $vendor_email, $vendor_mobile, $vendor_password, $firebasetoken, $slug, $google_id, $facebook_id, $country_id, $city_id)
    {
        try {
            if (!empty($slug)) {
                $slug;
            } else {
                $check = User::where('slug', Str::slug($vendor_name, '-'))->first();
                if ($check != "") {
                    $last = User::select('id')->orderByDesc('id')->first();
                    $slug =   Str::slug($vendor_name . " " . ($last->id + 1), '-');
                } else {
                    $slug = Str::slug($vendor_name, '-');
                }
            }

            $rec = helper::appdata('');
           
            date_default_timezone_set($rec->timezone);
            $logintype = "normal";
            if ($google_id != "") {
                $logintype = "google";
            }

            if ($facebook_id != "") {
                $logintype = "facebook";
            }

            $user = new User();
            $user->name = $vendor_name;
            $user->email = $vendor_email;
            $user->password = $vendor_password;
            $user->google_id = $google_id;
            $user->facebook_id = $facebook_id;
            $user->mobile = $vendor_mobile;
            $user->type = "2";
            $user->image = "default.png";
            $user->slug = $slug;
            $user->login_type = $logintype;
            $user->token = $firebasetoken;
            $user->country_id = $country_id;
            $user->city_id = $city_id;
            $user->is_available = "1";
            $user->is_verified = "1";
            $user->wallet = 0;
            $user->save();
            $vendor_id = \DB::getPdo()->lastInsertId();
            $paymentlist = Payment::select('payment_name', 'currency', 'image', 'is_activate')->where('vendor_id', '1')->where('id', "!=", "6")->get();
          
            foreach ($paymentlist as $payment) {
                $gateway = new Payment;
                $gateway->vendor_id = $vendor_id;
                $gateway->payment_name = $payment->payment_name;
                $gateway->currency = $payment->currency;
                $gateway->image = $payment->image;
                $gateway->public_key = '-';
                $gateway->secret_key = '-';
                $gateway->encryption_key = '-';
                $gateway->environment = '1';
                $gateway->is_available = '1';
                $gateway->is_activate = $payment->is_activate;
                $gateway->save();
            }
            $data = new Settings;
            $data->vendor_id = $vendor_id;
            $data->currency = $rec->currency;
            $data->currency_position = $rec->currency_position;
            if (empty($rec->logo)) {
                $data->logo = "defaultlogo.png";
            } else {
                $data->logo = $rec->logo;
            }
            if (empty($rec->favicon)) {
                $data->favicon = "defaultfavicon.png";
            } else {
                $data->favicon = $rec->favicon;
            }
            $data->footer_description = "";
            $data->timezone = $rec->timezone;
            $data->web_title = $rec->web_title;
            $data->copyright = $rec->copyright;
            $data->email = $user->email;
            $data->mobile = $user->mobile;
            $data->contact = $user->mobile;
            $data->interval_time = 1;
            $data->interval_type = 2;
            $message = "Hi, 
I would like to create Order for {product} 👇
---------------------------
 Order Id : {order_no}
👉 Payment type : {payment_type}
---------------------------
👉 Subtotal : {sub_total}
👉 Tax : {total_tax}
👉 Discount ({offer_code}) : - {discount_amount}
---------------------------
📃 Total : {grand_total}
---------------------------
✅ Customer Info
---------------------------
Customer name : {customer_name}
Customer phone : {customer_mobile}
Customer email: {customer_email}
---------------------------
📍 Customer address : {address} .
---------------------------
🗓️ Pickup Date :{pickup_date}
⏱️ Pickup time : {pickup_time}
    Pickup Location : {pickup_location}
🗓️ Dropoff Date :{dropoff_date}
⏱️ Dropoff time : {dropoff_time}
    Dropoff Location : {dropoff_location}
---------------------------
Track your Order👇
{track_order_url}
Click here for next order 👇
{website_url}
Thanks for the order 🥳";
            $data->whatsapp_message = $message ;
            $data->whatsapp_number = $user->mobile;
            $data->primary_color = "#80b213";
            $data->secondary_color ="#28282B";
            $data->footer_description ="Lorem Ipsum Is Simply Dummy Text Of The Printing And Typesetting Industry. Lorem Ipsum Has Been The Industry's Standard Dummy Text Ever Since The 1500s, When An Unknown Printer Took A Galley Of Type And Scrambled It To Make A Type Specimen Book. It Has Survived Not Only Five Centuries, But Also The Leap Into Electronic Typesetting, Remaining Essentially Unchanged.";
            $data->telegram_message = $message;
            $data->save();
            return $vendor_id;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public static function whatsappmessage($booking_number, $vendordata)
    {
        $payment_type = "-";
        $getbooking = Booking::where('booking_number', $booking_number)->first();
        $product = Product::where('id', $getbooking->product_id)->first();
        if ($getbooking->payment_status == "1") {
            $payment_status = "UnPaid";
        }
        if ($getbooking->payment_status == "2") {
            $payment_status = "Paid";
        }
       
        if (strtolower($getbooking->transaction_type) == "2") {
            $payment_type = "RazorPAy";
        }
        if (strtolower($getbooking->transaction_type) == '3') {
            $payment_type = "Stripe";
        }
        if (strtolower($getbooking->transaction_type) == '4') {
            $payment_type = "Flutterwave";
        }
        if (strtolower($getbooking->transaction_type) == '5') {
            $payment_type = "PayStack";
        }
      
        $var = ["{product}", "{order_no}", "{sub_total}", "{total_tax}", "{offer_code}", "{discount_amount}", "{grand_total}", "{customer_name}", "{customer_mobile}", "{customer_email}", "{address}", "{pickup_date}", "{pickup_time}", "{pickup_location}", "{dropoff_date}", "{dropoff_time}", "{dropoff_location}","{payment_type}", "{track_order_url}", "{website_url}"];
        $newvar   = [$product->title, $getbooking->booking_number, helper::currency_formate($getbooking->subtotal, $vendordata->id), helper::currency_formate($getbooking->tax, $vendordata->id), $getbooking->offer_code, helper::currency_formate($getbooking->offer_amount, $vendordata->id), helper::currency_formate($getbooking->grand_total, $vendordata->id), $getbooking->customer_name, $getbooking->customer_mobile, $getbooking->customer_email, $getbooking->customer_address, $getbooking->checkin_date, $getbooking->checkin_time, $getbooking->checkin_location, $getbooking->checkout_date, $getbooking->checkout_time, $getbooking->checkout_location, $payment_type, URL::to($vendordata->slug . '/booking-' . $booking_number), URL::to('/' . $vendordata->slug)];
        $whmessage = str_replace($var, $newvar, str_replace("\n", "%0a", helper::appdata($vendordata->id)->whatsapp_message));

        return $whmessage;
    }
    public function telegram($vendor_slug, $booking_number)
    {
        try {
            $vendordata = User::where('slug', $vendor_slug)->first();
            $payment_type = "-";
            $getbooking = Booking::where('booking_number', $booking_number)->first();
            $product = Product::where('id', $getbooking->product_id)->first();
           
            if (strtolower($getbooking->transaction_type) == "2") {
                $payment_type = "RazorPAy";
            }
            if (strtolower($getbooking->transaction_type) == '3') {
                $payment_type = "Stripe";
            }
            if (strtolower($getbooking->transaction_type) == '4') {
                $payment_type = "Flutterwave";
            }
            if (strtolower($getbooking->transaction_type) == '5') {
                $payment_type = "PayStack";
            }
           
            $var = ["{product}", "{order_no}", "{sub_total}", "{total_tax}", "{offer_code}", "{discount_amount}", "{grand_total}", "{customer_name}", "{customer_mobile}", "{customer_email}", "{address}", "{pickup_date}", "{pickup_time}", "{pickup_location}", "{dropoff_date}", "{dropoff_time}", "{dropoff_location}","{payment_type}", "{track_order_url}", "{website_url}"];
            $newvar   = [$product->title, $getbooking->booking_number, helper::currency_formate($getbooking->subtotal, $vendordata->id), helper::currency_formate($getbooking->tax, $vendordata->id), $getbooking->offer_code, helper::currency_formate($getbooking->offer_amount, $vendordata->id), helper::currency_formate($getbooking->grand_total, $vendordata->id), $getbooking->customer_name, $getbooking->customer_mobile, $getbooking->customer_email, $getbooking->customer_address, $getbooking->checkin_date, $getbooking->checkin_time, $getbooking->checkin_location, $getbooking->checkout_date, $getbooking->checkout_time, $getbooking->checkout_location, $payment_type, URL::to($vendordata->slug . '/booking-' . $booking_number), URL::to('/' . $vendordata->slug)];

            $telegrammessage = str_replace($var, $newvar, helper::appdata($vendordata->id)->telegram_message);
            $apiToken = helper::appdata($vendordata->id)->telegram_access_token;
            $chatIds = array(helper::appdata($vendordata->id)->telegram_chat_id); // AND SOME MORE
            $data = [
                'text' => $telegrammessage
            ];
            foreach ($chatIds as $chatId) {
                // Send Message To chat id
                file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?chat_id=$chatId&" . http_build_query($data));
            }
            return redirect('/' . $vendordata->slug . '/success-'.$booking_number)->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
    public static function plandetail($plan_id)
    {
        $planinfo = PricingPlan::where('id', $plan_id)->first();
        return $planinfo;
    }

    public static function get_city()
    {
        $city =  Country::where('is_deleted','2')->where('is_available','1')->get();
        return $city;
    }
}
