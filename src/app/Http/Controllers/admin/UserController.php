<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DeletionToken;
use App\helper\helper;
use App\Models\Settings;
use App\Models\Country;
use App\Models\Customdomain;
use App\Models\PricingPlan;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function view_users()
    {
        $users = User::where('type', "2")->orderBydesc('id')->get();
        return view('admin.user.user', compact('users'));
    }
    public function add()
    { 
        $countries = Country::where('is_deleted',2)->where('is_available',1)->get();
        return view('admin.user.add_user',compact('countries'));
    }
    public function edit($slug)
    {
        $user = User::where('slug', $slug)->first();
        $countries = Country::where('is_deleted',2)->where('is_available',1)->get();
        $getplanlist = PricingPlan::where('is_available', 1)->get();
        return view('admin.user.edit_user', compact('user', 'getplanlist','countries'));
    }
    public function edit_vendorprofile(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'mobile' => 'required|numeric|unique:users,mobile,' . $request->id,
            'profile.*' => 'mimes:jpeg,png,jpg',
        ], [
            'name.required' => trans('messages.name_required'),
            'email.required' => trans('messages.email_required'),
            'mobile.required' => trans('messages.mobile_required'),
            'email.email' =>  trans('messages.invalid_email'),
            'email.unique' => trans('messages.unique_email'),
            'mobile.unique' => trans('messages.unique_mobile'),
        ]);
        $check_slug = User::where('slug', Str::slug($request->name, '-'))->first();
        if (!empty($check_slug)) {
            $last_id = User::select('id')->orderByDesc('id')->first();
            $slug = Str::slug($request->name . ' ' . $last_id->id, '-');
        } else {
            $slug = Str::slug($request->name, '-');
        }
        $edituser = User::where('id', $request->id)->first();
        $edituser->slug = $slug;
        $edituser->name = $request->name;
        $edituser->email = $request->email;
        $edituser->mobile = $request->mobile;
        $edituser->country_id = $request->country;
        $edituser->city_id = $request->city;
        if ($request->has('profile')) {
            if (file_exists(storage_path('app/public/admin-assets/images/profile/' . Auth::user()->image))) {
                unlink(storage_path('app/public/admin-assets/images/profile/' .  Auth::user()->image));
            }
            $edit_image = $request->file('profile');
            $profileImage = 'profile-' . uniqid() . "." . $edit_image->getClientOriginalExtension();
            $edit_image->move(storage_path('app/public/admin-assets/images/profile/'), $profileImage);
            $edituser->image = $profileImage;
        }
        if (!isset($request->allow_store_subscription)) {
            if (isset($request->plan_checkbox) && $request->plan != null && !empty($request->plan)) {

                $plan = PricingPlan::where('id', $request->plan)->first();
                $edituser->plan_id = $plan->id;
                $edituser->purchase_amount = $plan->price;
                $edituser->purchase_date = date("Y-m-d h:i:sa");
                $edituser->allow_without_subscription = 2;
                $transaction = new Transaction();
                $transaction->vendor_id = $edituser->id;
                $transaction->plan_id = $plan->id;
                $transaction->plan_name = $plan->name;
                $transaction->payment_type = 1;
                $transaction->payment_id = "";
                $transaction->amount = $plan->price;
                $transaction->service_limit = $plan->order_limit;
                $transaction->appoinment_limit = $plan->appointment_limit;
                $transaction->status = 2;
                $transaction->purchase_date = date("Y-m-d h:i:sa");
                $transaction->expire_date = helper::get_plan_exp_date($plan->duration, $plan->days);
                $transaction->duration = $plan->duration;
                $transaction->days = $plan->days;
                $transaction->custom_domain = $plan->custom_domain;
                $transaction->themes_id = $plan->themes_id;
                $transaction->save();
                // $edituser->update();
                if ($plan->custom_domain == "2") {
                    Settings::where('vendor_id', Auth::user()->id)->update(['custom_domain' => "-"]);
                }
                if ($plan->custom_domain == "1") {
                    $checkdomain = Customdomain::where('vendor_id', Auth::user()->id)->first();
                    if (@$checkdomain->status == 2) {
                        Settings::where('vendor_id', Auth::user()->id)->update(['custom_domain' => $checkdomain->current_domain]);
                    }
                }
            }
        }
        if (Str::contains(request()->url(), 'users')) {

            if (isset($request->allow_store_subscription)) {
                $edituser->plan_id = "";
                $edituser->purchase_amount = "";
                $edituser->purchase_date = "";
            }
            $edituser->allow_without_subscription = isset($request->allow_store_subscription) ? 1 : 2;
            $edituser->available_on_landing = isset($request->show_landing_page) ? 1 : 2;
            // $edituser->update();
        }
        $edituser->update();
        return redirect('/admin/users')->with('success', trans('messages.success'));
    }
    public function change_status($slug, $status)
    {
        User::where('slug', $slug)->update(['is_available' => $status]);
        return redirect('/admin/users')->with('success', trans('messages.success'));
    }
    public function vendor_login(Request $request, $slug)
    {
        session()->put('vendor_login', 1);
        $user = User::where('slug', $slug)->first();
        Auth::login($user);
        return redirect('/admin/dashboard');
    }
    public function admin_back(Request $request)
    {
        $getuser = User::where('type', '1')->first();
        Auth::login($getuser);
        session()->forget('vendor_login');
        return redirect('/admin/users');
    }
    public function confirm_deletion($token)
    {
        $decodedToken = urldecode($token);
        $deletionToken = DeletionToken::where('token', $decodedToken)->first();
        if ($deletionToken && $deletionToken->expires_at > now()) {
            $deletionToken->delete();
            $deletionToken->user->update(['is_available' => false]);

            return view('deleteaccount', ['message' => 'Your account has been successfully deleted.']);
        }
        return view('deleteaccount', ['message' => 'It seems there was an issue processing your request. Please make sure your token is valid and try again. If the problem persists, reach out to our support team for assistance. Thank you for your understanding.']);
    }
}
