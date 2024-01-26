<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\PricingPlan;
use App\Models\User;
use App\Models\Transaction;
use App\helper\helper;
use App\Models\Product;
use App\Models\Settings;
use App\Models\Customdomain;
use App\Models\SystemAddons;
use Stripe;
use Validator;



class PlanPricingController extends Controller
{
    public function view_plan(Request $request)
    { 
        if (SystemAddons::where('unique_identifier', 'subscription')->first() == null) {
            return redirect()->back()->with(['error' => 'You can not charge your end customers in regular license. Please purchase extended license to charge your end customers']);
        } else {
            $allplan = PricingPlan::orderBy('price');
            if (Auth::user()->type == 2) {
                $allplan = $allplan->where('is_available', '1');
            }
            $allplan = $allplan->get();
            return view('admin.plan.plan', compact("allplan"));
        }
    }
    public function add_plan(Request $request)
    {
        return view('admin.plan.add_plan');
    }
    public function save_plan(Request $request)
    {
     
        $request->validate([
            'plan_name' => 'required',
            'plan_price' => 'required',
            'plan_duration' => 'required_if:type,1',
            'plan_max_business' => 'required_if:service_limit_type,1',
            'plan_description' => 'required',
            'plan_features' => 'required',
            'plan_appoinment_limit' => 'required_if:booking_limit_type,1',
            'plan_days' => 'required_if:type,2',
        ], [
            'plan_name.required' => trans('messages.name_required'),
            'plan_price.required' => trans('messages.price_required'),
            'plan_duration.required_if' => trans('messages.duration_required'),
            'plan_max_business.required_if' => trans('messages.plan_max_business'),
            'plan_description.required' => trans('messages.description_required'),
            'plan_features.required' => trans('messages.plan_features'),
            'plan_appoinment_limit.required_if' => trans('messages.appoinment_limit'),
            'plan_days.required_if' => trans('messages.days_required'),
        ]);
        $exitplan = PricingPlan::where('price', '0')->count();
        if ($exitplan > 0 && $request->plan_price == '0') {
            return redirect('admin/plan')->with('error', trans('messages.already_exist_plan'));
        } else {
            if ($request->custom_domain == "on") {
                $custom_domain = "1";
            } else {
                $custom_domain = "2";
            }
            if ($request->vendor_app == "on") {
                $vendor_app = "1";
            } else {
                $vendor_app = "2";
            }
            if ($request->zoom == "on") {
                $zoom = "1";
            } else {
                $zoom = "2";
            }
            if ($request->calendar == "on") {
                $calendar = "1";
            } else {
                $calendar = "2";
            }
            if ($request->google_analytics == "on") {
                $google_analytics = "1";
            } else {
                $google_analytics = "2";
            }
            $saveplan = new PricingPlan();
            $saveplan->name = $request->plan_name;
            $saveplan->description = $request->plan_description;
            $saveplan->features = implode("|", $request->plan_features);
            $saveplan->price = $request->plan_price;
            $saveplan->plan_type = $request->type;
            if ($request->type == "1") {
                $saveplan->duration = $request->plan_duration;
                $saveplan->days = 0;
            }
            if ($request->type == "2") {
                $saveplan->duration = "";
                $saveplan->days = $request->plan_days;
            }
            if ($request->service_limit_type == "1") {
                $saveplan->order_limit = $request->plan_max_business;
            } elseif ($request->service_limit_type == "2") {
                $saveplan->order_limit = -1;
            }
            if ($request->booking_limit_type == "1") {
                $saveplan->appointment_limit = $request->plan_appoinment_limit;
            } elseif ($request->booking_limit_type == "2") {
                $saveplan->appointment_limit = -1;
            }
            $saveplan->custom_domain = $custom_domain;
            $saveplan->vendor_app = $vendor_app;
            $saveplan->zoom = $zoom;
            $saveplan->calendar = $calendar;
            $saveplan->google_analytics = $google_analytics;
            $saveplan->themes_id = 1;
            $saveplan->save();
            return redirect('admin/plan')->with('success', trans('messages.success'));
        }
    }
    public function edit_plan($id)
    {
        $editplan = PricingPlan::where('id', $id)->first();
        return view('admin.plan.edit_plan', compact("editplan"));
    }
    public function update_plan(Request $request, $id)
    {
     try {
        $request->validate([
            'plan_name' => 'required',
            'plan_price' => 'required',
            'plan_duration' => 'required_if:type,1',
            'plan_max_business' => 'required_if:service_limit_type,1',
            'plan_description' => 'required',
            'plan_features' => 'required',
            'plan_appoinment_limit' => 'required_if:booking_limit_type,1',
            'plan_days' => 'required_if:type,2',
        ], [
            'plan_name.required' => trans('messages.name_required'),
            'plan_price.required' =>  trans('messages.price_required'),
            'plan_duration.required_if' => trans('messages.plan_duration'),
            'plan_max_business.required_if' => trans('messages.plan_max_business'),
            'plan_description.required' => trans('messages.description_required'),
            'plan_features.required' => trans('messages.plan_features'),
            'plan_appoinment_limit.required_if' => trans('messages.appoinment_limit'),
            'plan_days.required_if' => trans('messages.days_required'),
        ]);
        if ($request->custom_domain == "on") {
            $custom_domain = "1";
        } else {
            $custom_domain = "2";
        }
        if ($request->vendor_app == "on") {
            $vendor_app = "1";
        } else {
            $vendor_app = "2";
        }
        if ($request->zoom == "on") {
            $zoom = "1";
        } else {
            $zoom = "2";
        }
        if ($request->calendar == "on") {
            $calendar = "1";
        } else {
            $calendar = "2";
        }
        if ($request->google_analytics == "on") {
            $google_analytics = "1";
        } else {
            $google_analytics = "2";
        }
        $exitplan = PricingPlan::where('price', '0')->count();
        if ($exitplan > 1 && $request->plan_price == '0') {
            return redirect('admin/plan/edit-' . $id)->with('error', trans('messages.already_exist_plan'));
        } else {
            $editplan = PricingPlan::where('id', $id)->first();
            $editplan->name = $request->plan_name;
            $editplan->description = $request->plan_description;
            $editplan->features = implode("|", $request->plan_features);
            $editplan->price = $request->plan_price;
            $editplan->plan_type = $request->type;
         
            if ($request->type == "1") {
                $editplan->duration = $request->plan_duration;
                $editplan->days = "0";
            }
            if ($request->type == "2") {
                $editplan->duration = "0";
                $editplan->days = $request->plan_days;
            }
            if ($request->service_limit_type == "1") {
                $editplan->order_limit = $request->plan_max_business;
            } elseif ($request->service_limit_type == "2") {
                $editplan->order_limit = "-1";
            }
            if ($request->booking_limit_type == "1") {
                $editplan->appointment_limit = $request->plan_appoinment_limit;
            } elseif ($request->booking_limit_type == "2") {
                $editplan->appointment_limit = "-1";
            }

            $editplan->custom_domain = $custom_domain;
            $editplan->vendor_app = $vendor_app;
            $editplan->zoom = $zoom;
            $editplan->calendar = $calendar;
            $editplan->google_analytics = $google_analytics;
            $editplan->themes_id = 1;
            $editplan->update();
            return redirect('admin/plan')->with('success', trans('messages.success'));
        }
     } catch (\Throwable $th) {
       return $th;
     }
       
    }
    public function status_change($id, $status)
    {
        PricingPlan::where('id', $id)->update(['is_available' => $status]);
        return redirect('admin/plan')->with('success', trans('messages.success'));
    }
    public function select_plan($id)
    {
        $plan = PricingPlan::where('id', $id)->first();
        $totalservice = Product::where('vendor_id', Auth::user()->id)->count();
        if (!empty($totalservice)) {
            if ($plan->order_limit != -1) {
                if ($plan->order_limit < $totalservice) {
                    return redirect('admin/plan')->with('error', trans('messages.not_eligible_for_plan'));
                }
            }
        }
        if ($plan->price > 0) {
            $paymentmethod = Payment::whereNotIn('id', [1])->where('vendor_id', 1)->where('is_available', '1')->where('is_activate','1')->get();
            return view('admin.plan.plan_payment', compact('plan', 'paymentmethod'));
        } else {
            $transaction = new transaction();
            $transaction->vendor_id = Auth::user()->id;
            $transaction->plan_id = $id;
            $transaction->plan_name = $plan->name;
            $transaction->payment_type = "";
            $transaction->payment_id = "";
            $transaction->amount = $plan->price;
            $transaction->service_limit = $plan->order_limit;
            $transaction->appoinment_limit = $plan->appointment_limit;
            $transaction->expire_date = helper::get_plan_exp_date($plan->duration, $plan->days);
            $transaction->duration = $plan->duration;
            $transaction->days = $plan->days;
            $transaction->purchase_date = date("Y-m-d h:i:sa");
            $transaction->custom_domain = $plan->custom_domain;
            $transaction->zoom = $plan->zoom;
            $transaction->calendar = $plan->calendar;
            $transaction->google_analytics = $plan->google_analytics;
            // $transaction->themes_id = $plan->themes_id;
            $transaction->save();
            User::where('id', Auth::user()->id)->update(['plan_id' => $id, 'purchase_amount' => $plan->price, 'purchase_date' => Carbon::now()->toDateTimeString()]);
            return redirect()->back()->with('success', trans('messages.success'));
        }
    }
    public function success(Request $request)
    {
        try {
            if (@$request->paymentId != "") {
                $paymentid = $request->paymentId;
            }
            if (@$request->payment_id != "") {
                $paymentid = $request->payment_id;
            }
            if (@$request->transaction_id != "") {
                $paymentid = $request->transaction_id;
            }

            $plan = PricingPlan::where('id', session()->get('plan_id'))->first();
            $checkuser = User::find(Auth::user()->id);
            $checkuser->plan_id = session()->get('plan_id');
            $checkuser->purchase_amount = session()->get('amount');
            $checkuser->purchase_date = date("Y-m-d h:i:sa");
            $checkuser->save();
            $transaction = new Transaction;
            $transaction->vendor_id = Auth::user()->id;
            $transaction->plan_id = session()->get('plan_id');
            $transaction->plan_name = $plan->name;
            $transaction->payment_type = session()->get('payment_type');
            $transaction->amount = session()->get('amount');
            $transaction->payment_id = @$paymentid;
            $transaction->service_limit = $plan->order_limit;
            $transaction->appoinment_limit = $plan->appointment_limit;
            $transaction->expire_date = helper::get_plan_exp_date($plan->duration, $plan->days);
            $transaction->duration = $plan->duration;
            $transaction->days = $plan->days;
            $transaction->custom_domain = $plan->custom_domain;
            $transaction->zoom = $plan->zoom;
            $transaction->calendar = $plan->calendar;
            $transaction->google_analytics = $plan->google_analytics;
            $transaction->status = "2";
            // $transaction->themes_id = $plan->themes_id;
            $transaction->purchase_date = date("Y-m-d h:i:sa");
            $transaction->save();
            session()->forget(['amount', 'plan_id', 'payment_type']);
            helper::send_subscription_email(Auth::user()->email, Auth::user()->name, $plan->name, helper::get_plan_exp_date($plan->duration, $plan->days), helper::currency_formate($plan->price, ""), $request->payment_type, @$payment_id);
            return redirect('admin/plan')->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
          return $th;
        }
    }
    public function buyplan(Request $request)
    {
        try {
         
            $plan = PricingPlan::where('id', $request->plan_id)->first();
            if (strtolower($request->payment_type) == "3") {
                $paymentmethod = Payment::where('type', $request->payment_type)->where('is_available', 1)->first();
                Stripe\Stripe::setApiKey($paymentmethod->secret_key);
                $charge = Stripe\Charge::create([
                    'amount' => $request->amount * 100,
                    'currency' => $request->currency,
                    'description' => 'Example charge',
                    'source' => $request->payment_id,
                ]);
                $payment_id = $charge->id;
            } else {
                $payment_id = $request->payment_id;
            }
            
            $checkuser = User::find(Auth::user()->id);
            $checkuser->plan_id = $request->plan_id;
            $checkuser->purchase_amount = $request->amount;
            $checkuser->purchase_date = date("Y-m-d h:i:sa");
           
            $transaction = new Transaction();
            if (strtolower($request->payment_type) == 'banktransfer') {
                if ($request->hasFile('screenshot')) {
                    $validator = Validator::make($request->all(), [
                        'screenshot' => 'image|mimes:jpg,jpeg,png',
                    ], [
                        'screenshot.mage' => trans('messages.enter_image_file'),
                        'screenshot.mimes' => trans('messages.valid_image'),
                    ]);
                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                    } else {
                        $filename = 'screenshot-' . uniqid() . "." . $request->file('screenshot')->getClientOriginalExtension();
                        $request->file('screenshot')->move('storage/app/public/admin-assets/images/screenshot/', $filename);
                        $transaction->screenshot = $filename;
                    }
                }
                $payment_id = "";
                $status = 1;
            } else {
                $status = 2;
            }
            $transaction->vendor_id = Auth::user()->id;
            $transaction->plan_id = $request->plan_id;
            $transaction->plan_name = $plan->name;
           
            // payment_type = COD : 1,RazorPay : 2, Stripe : 3, Flutterwave : 4, Paystack : 5, Mercado Pago : 7, PayPal : 8, MyFatoorah : 9, toyyibpay : 10
            
            $transaction->payment_type =  $request->payment_type;
            $transaction->payment_id = $payment_id;
            $transaction->amount = $request->amount;
            $transaction->service_limit = $plan->order_limit;
            $transaction->appoinment_limit = $plan->appointment_limit;
            $transaction->status = $status;
            $transaction->purchase_date = date("Y-m-d h:i:sa");
            $transaction->expire_date = helper::get_plan_exp_date($plan->duration, $plan->days);
            $transaction->duration = $plan->duration;
            $transaction->days = $plan->days;
            $transaction->custom_domain = $plan->custom_domain;
            $transaction->zoom = $plan->zoom;
            $transaction->calendar = $plan->calendar;
            $transaction->google_analytics = $plan->google_analytics;
            $transaction->themes_id = $plan->themes_id;
            $transaction->save();
            $checkuser->save();
            if ($request->payment_type == '6') {
                $admindata = User::select('name','email')->where('id','1')->first();
                helper::bank_transfer_request(Auth::user()->email, Auth::user()->name,$admindata->email, $admindata->name);
                return redirect('admin/plan')->with('success', trans('messages.success'));
            }else{
                helper::send_subscription_email(Auth::user()->email, Auth::user()->name, $plan->name, helper::get_plan_exp_date($plan->duration, $plan->days), helper::currency_formate($plan->price, ""), $request->payment_type, @$payment_id);
                return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
            }
            if ($plan->custom_domain == "2") {
                Settings::where('vendor_id', Auth::user()->id)->update(['custom_domain' => "-"]);
            }
            if ($plan->custom_domain == "1") {
                $checkdomain = Customdomain::where('vendor_id', Auth::user()->id)->first();
                if (@$checkdomain->status == 2) {
                    Settings::where('vendor_id', Auth::user()->id)->update(['custom_domain' => $checkdomain->current_domain]);
                }
            }
            if ($request->payment_type) {
                return redirect('admin/plan')->with('success', trans('messages.success'));
            } else {
                return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
            }
        } catch (\Throwable $th) {
            if ($request->payment_type) {
                return redirect()->back()->with('error', trans('messages.wrong'));
            } else {
                return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
            }
        }
    }
    public function delete(Request $request)
    {
        $deleteplan = PricingPlan::where('id', $request->id)->first();
        $deleteplan->delete();
        return redirect('admin/plan')->with('success', trans('messages.success'));
    }
}
