<?php
namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Notifications\NewPassword;
use App\Models\User;
use App\helper\helper;
use App\Models\Country;
use App\Models\Booking;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\PricingPlan;
use Carbon\Carbon;
use App\Models\City;
use Illuminate\Support\Facades\Redirect;
use Session;
class AdminController extends Controller
{
    public function index(Request $request)
    {
         if (empty($request->revenue_year)) {
            $request->revenue_year = date('Y');
        }
        if (empty($request->booking_year)) {
            $request->booking_year = date('Y');
        }
        // if (Auth::user()->type == 1) {

        // $getrevenue_data = Transaction::select(DB::raw("SUM(amount) as count"), DB::raw("MONTHNAME(purchase_date) as month"))->groupBy(DB::raw("MONTHNAME(purchase_date)"))->where(DB::raw("YEAR(purchase_date)"), $request->revenue_year)->orderby('purchase_date')->get();
        $getrevenue_data = Order::where('status', 'Succeeded')
            ->selectRaw("SUM(total_commission_amount) as count, MONTHNAME(accepted_at) as month")
            ->groupByRaw("MONTHNAME(accepted_at)")
            ->whereYear('accepted_at', $request->revenue_year)
            ->orderBy('accepted_at')
            ->get();
        $getpiechart_data = Product::select(DB::raw("COUNT(id) as count"), DB::raw("MONTHNAME(created_at) as month"))->groupBy(DB::raw("MONTHNAME(created_at)"))->where('is_available', 1)->where(DB::raw("YEAR(created_at)"), $request->booking_year)->orderby('created_at')->get();
        $getyears = Order::where('status', 'Succeeded')
            ->selectRaw("YEAR(accepted_at) as year")
            ->groupByRaw("YEAR(accepted_at)")
            ->orderBy('accepted_at')
            ->get();
        $totalrevenue = Order::where('status', 'Succeeded')
            ->selectRaw("SUM(total_commission_amount) as total")
            ->first();
        $getbookings = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.name as user_name')
            ->whereDate('orders.accepted_at', Carbon::today())
            ->orderByDesc('orders.id')
            ->get();
        // } else {
        //     $getyears = Transaction::select(DB::raw("YEAR(purchase_date) as year"))->groupBy(DB::raw("YEAR(purchase_date)"))->orderby('purchase_date')->get();
        //     $totalrevenue = Transaction::select(DB::raw("SUM(amount) as total"))->first();
        //     $getrevenue_data = Booking::select(DB::raw("SUM(grand_total) as count"), DB::raw("MONTHNAME(created_at) as month"))->groupBy(DB::raw("MONTHNAME(created_at)"))->where('vendor_id', Auth::user()->id)->where('payment_status', '2')->where(DB::raw("YEAR(created_at)"), $request->revenue_year)->orderby('created_at')->get();
        //     $getpiechart_data = Booking::select(DB::raw("COUNT(id) as count"), DB::raw("MONTHNAME(created_at) as month"))->groupBy(DB::raw("MONTHNAME(created_at)"))->where('vendor_id', Auth::user()->id)->where(DB::raw("YEAR(created_at)"), $request->booking_year)->orderby('created_at')->get();
        //     $getyears = Booking::select(DB::raw("YEAR(created_at) as year"))->groupBy(DB::raw("YEAR(created_at)"))->where('vendor_id', Auth::user()->id)->orderby('created_at')->get();
        //     $totalrevenue = Booking::select(DB::raw("SUM(grand_total) as total"))->where('vendor_id', Auth::user()->id)->where('payment_status', '2')->first();
        //     $getbookings = Booking::whereDate('created_at', Carbon::today())->where('vendor_id', Auth::user()->id)->orderByDesc('id')->get();
        // }
        $getuserYears = Product::select(DB::raw("YEAR(created_at) as year"))->where('is_available', 1)->whereNot('is_deleted', 1)->groupBy(DB::raw("YEAR(created_at)"))->orderby('created_at')->get();
        $userchart_year = explode(',', $getuserYears->implode('year', ','));
        if (env('Environment') == 'chart') {
            $revenue_lables = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];
            $revenue_data = [636, 1269, 2810, 2843, 3637, 467, 902, 1296, 402, 1173, 1509, 413];
            if (Auth::user()->type == 1) {
                $piechart_lables = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];
                $piechart_data = [16, 14, 25, 28, 45, 31, 25, 35, 49, 21, 32, 31];
            } else {
                $piechart_lables = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];
                $piechart_data = [60, 42, 13, 83, 34, 97, 92, 62, 13, 99, 89, 94];
            }
        } else {
            $revenue_lables = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];
            $revenue_data = [636, 1269, 2810, 2843, 3637, 467, 902, 1296, 402, 1173, 1509, 413];
            if (Auth::user()->type == 1) {
                $piechart_lables = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];
                $piechart_data = [16, 14, 25, 28, 45, 31, 25, 35, 49, 21, 32, 31];
            } else {
                $piechart_lables = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];
                $piechart_data = [60, 42, 13, 83, 34, 97, 92, 62, 13, 99, 89, 94];
            }
            $revenue_lables = explode(',', $getrevenue_data->implode('month', ','));
            $revenue_data = explode(',', $getrevenue_data->implode('count', ','));
            $piechart_lables = explode(',', $getpiechart_data->implode('month', ','));
            $piechart_data = explode(',', $getpiechart_data->implode('count', ','));
        }
        $revenue_year_list = explode(',', $getyears->implode('year', ','));
        $totalusers = User::whereNotIn('id', [1])->where('is_available', 1)->where('type', 3)->count();
        $totalproducts = Product::where('is_available',1)->whereNot('is_deleted',1)->count();
        $totalplans = PricingPlan::count();
        $currentplan = PricingPlan::select('name')->where('id', Auth::user()->plan_id)->first();
        $totaladminbookings = Order::where('status', 'Succeeded')->count();
        // $totalbookings = Booking::where('payment_status',2)->where('vendor_id',Auth::user()->id)->count();
         
        if ($request->ajax()) {
            if ($request->has('revenue_year')) {
                return response()->json(['revenue_lables' => $revenue_lables, 'revenue_data' => $revenue_data], 200);
            }
            if ($request->has('booking_year')) {
                return response()->json(['piechart_lables' => $piechart_lables, 'piechart_data' => $piechart_data], 200);
            }
        } else {
            return view('admin.index', compact('revenue_lables', 'revenue_year_list', 'revenue_data', 'piechart_lables', 'piechart_data', 'totalusers', 'totalplans','totalrevenue', 'userchart_year','currentplan','totaladminbookings','getbookings','totalproducts'));
        }
        return view('admin.index');
    }
    public function login()
    {
        if(!file_exists(storage_path() . "/installed")) {
            return redirect('install');
            exit;
        }
        return view('admin.auth.login');
    }
    public function check_admin_login(Request $request)
    {
        try {
            session()->put('admin_login', 1);
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ], [
                'email.required' => trans('messages.email_required'),
                'email.email' =>  trans('messages.invalid_email'),
                'password.required' => trans('messages.password_required'),
            ]);
            if (Auth::attempt($request->only('email', 'password'))) {
                if (!Auth::user()) {
                    return Redirect::to('/admin/verification')->with('error', Session::get('from_message'));
                }
                if (Auth::user()->type == 1) {
                    return redirect('/admin/dashboard');
                } else {
                    if (Auth::user()->type == 2) {
                        if (Auth::user()->is_available == 1) {
                            return redirect('/admin/dashboard');
                        } else {
                            Auth::logout();
                            return redirect()->back()->with('error', trans('messages.block'));
                        }
                    } else {
                        Auth::logout();
                        return redirect()->back()->with('error', trans('messages.email_password_not_match'));
                    }
                }
            } else {
                return Redirect::to('/admin')->with('error', trans('messages.email_password_not_match'));
            }
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }
    public function forgot_password()
    {
        return view('admin.auth.forgotpassword');
    }
    public function send_password(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => trans('messages.email_required'),
            'email.email' =>  trans('messages.invalid_email'),
        ]);
        $checkuser = User::where('email', $request->email)->where('is_available', 1)->whereIn('type',[1,2])->first();
        if (!empty($checkuser)) {
            $randomPassword = Str::random(16);
            $checkuser->notify(new NewPassword($checkuser->name, $randomPassword));
            $checkuser->password = Hash::make($randomPassword);
            $checkuser->save();
            return redirect('/admin')->with('success', trans('messages.success'));
        } else {
            return redirect()->back()->with('error', trans('messages.invalid_user'));
        }
    }
    public function register()
    {
        $countries =Country::where('is_deleted',2)->where('is_available',1)->get();
        return view('admin.auth.register',compact('countries'));
    }
    public function register_vendor(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'mobile' => 'required|unique:users,mobile',
        ], [
            'name.required' => trans('messages.name_required'),
            'email.required' => trans('messages.email_required'),
            'email.email' =>  trans('messages.invalid_email'),
            'email.unique' => trans('messages.unique_email'),
            'password.required' => trans('messages.password_required'),
            'mobile.required' => trans('messages.mobile_required'),
            'mobile.unique' => trans('messages.unique_mobile'),
        ]);
        $data = helper::vendor_register($request->name, $request->email, $request->mobile, hash::make($request->password), '', $request->slug, '', '',$request->country,$request->city);
        $newuser = User::select('id', 'name', 'email', 'mobile', 'image')->where('id', $data)->first();
        if (Auth::user() && Auth::user()->type == 1) {
            return redirect('admin/users')->with('success', trans('messages.success'));
        } else {
            Auth::login($newuser);
            return redirect('admin/dashboard')->with('success', trans('messages.success'));
        }
    }
    public function edit_profile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
            'mobile' => 'required|numeric|unique:users,mobile,' . Auth::user()->id,
            'profile' => 'mimes:jpeg,png,jpg',
        ], [
            'name.required' => trans('messages.name_required'),
            'email.email' =>  trans('messages.invalid_email'),
            'email.unique' => trans('messages.unique_email'),
            'mobile.unique' => trans('messages.unique_mobile'),
        ]);
        $edituser = User::where('id', Auth::user()->id)->first();
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

        $edituser->update();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function change_password(Request $request)
    {
      
        if (Hash::check($request->current_password, Auth::user()->password)) {
            if ($request->current_password == $request->new_password) {
                return redirect()->back()->with('error', trans('messages.new_old_password_diffrent'));
            } else {
                if ($request->new_password == $request->confirm_password) {
                    $changepassword = User::where('id', Auth::user()->id)->first();
                    $changepassword->password = Hash::make($request->new_password);
                    $changepassword->update();
                    return redirect()->back()->with('success',  trans('messages.success'));
                } else {
                    return redirect()->back()->with('error', trans('messages.new_confirm_password_inccorect'));
                }
            }
        } else {
            return redirect()->back()->with('error', trans('messages.old_password_incorect'));
        }
    }
    public function logout()
    {
        session()->flush();
        Auth::logout();
        return redirect('/admin');
    }
    public function getcity(Request $request)
    {
       
        try {
            $data['city'] = City::select("id","city")->where('country_id', $request->country)->where('is_deleted',2)->where('is_available',1 )->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }

    public function systemverification(Request $request)
    {
        $username = str_replace(' ','',$request->username);

        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6ImtwRjY3NVgxQmcvTUxsNm94T3F5aXc9PSIsInZhbHVlIjoiS1ZxYjNqakE0REdBcVp3WVYrdWY4ZVNXNkg2YUFCTEtHdk1uVC9wYWRRVmJXTVAyWFNXOHJJVUl2RHp2U0F0d3lwQXhxcFpCYTJ4VnVJMEJhbFpEbUE9PSIsIm1hYyI6IjBhMGU1MDI1YjdmODZkMDBmOTBiOTQzZTc4MDYwYjUyNjhlYTExZGYwMGUzZDMxMGNjZGQyYWQ1MGMxZmM1ZmYiLCJ0YWciOiIifQ=='), [
            'form_params' => [
                \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6IlBGb3F0cjU1U1NUTGxkSW14RC9sdFE9PSIsInZhbHVlIjoidTBnNVBKeTNRM25Nbm9YNUp5WmwyV3FlZmZPbHBXdUVoOGFkS1kzKzVQUT0iLCJtYWMiOiI0ZTQ4OTkwMzlmMjM5OWI0NWMwYWU0ODFlZDgwYzAzZmMxNGJkNDgzMjgxYmY4ZWZkMjRkODc4YmEzYmUzNWIzIiwidGFnIjoiIn0=') => $username,
                \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6IklSM0xqajh2UGliWXBldGEwNmtnNEE9PSIsInZhbHVlIjoiMXZ0R3g2S1c2anZzbThKQjZlSTNMQT09IiwibWFjIjoiNTBmYTY4N2Y1NzU1NDFlNjhjY2ViM2IyYzU5NTZiOTQ1NThlMDE4YmEyNDU4ZTJiZGZiYTg5MzFjYWMxNzc2ZiIsInRhZyI6IiJ9') => $request->email,
                \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6IlVJSHNwQVMrNHFnVmRXcEdtK1p4SUE9PSIsInZhbHVlIjoiclNUejZTTUZjOUdXUTF1RUsrOEUvVE5WczRoQzJsQTlFTkQ3ZkdwOEVLQT0iLCJtYWMiOiI1MjNiM2I2MjRhYWI1Mzk1N2NmYmFmOTgzMmMwYTBhYTUwYjM4NjFhOWJiNDEzYjE2NTdkNDMyMGFlNWZlNjQ5IiwidGFnIjoiIn0=') =>$request->purchase_key,
                \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6IjRLYlJtZlJoT1VFbjBDSnN2Tm1FU2c9PSIsInZhbHVlIjoiQytNa2p6UlVsR2g2bTFCZEQ0aTVYdz09IiwibWFjIjoiMzYyNjEzMDM4ZTc0MWRhYTkwMTk1YTM2OGE1NjAwYTA0OTcyMmQ3NDBkY2VlNTMzM2RlYzlkYjFlZjJiOTM4OCIsInRhZyI6IiJ9') =>$request->domain,
                \Illuminate\Support\Facades\Crypt::decrypt('^ "eyJpdiI6ImRHYUxXcWFxbjQrV255L24yTE5zWkE9PSIsInZhbHVlIjoiS09NcVZKVG5VNmZ5U0ZXdk55S1RlWWhySmNqaUJTNG1oWTVPSlJGTzM3UT0iLCJtYWMiOiJiNWIxZmUzZmJiMzYzZTA4MDdkNjMzZGU2NzFkOTEzYzJmMTc1NDVhYzAzM2QwMzRmMmYwZDQ3Njg4MWJlOGJjIiwidGFnIjoiIn0=') => \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6IkNpdFloYzZQNzFiVklmY3NubW02SVE9PSIsInZhbHVlIjoidFlLeC9iRGM4WFpJMjR0N3I0dmdKUT09IiwibWFjIjoiMjBjMzA2MzFkZDZlMzczYzNmODY1MGQyNWM3YzJkM2UyYzdlZGE3NmEwM2NiNjFmYTk3ZjZkZjUzYzliZWVmNCIsInRhZyI6IiJ9'),
                \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6ImR4NWFTVml1NEQ0b3l0cGg2VUNGQkE9PSIsInZhbHVlIjoidG92NUdTSTVwVnJxY2hKaTRmVGdZZz09IiwibWFjIjoiYjU0MTE0ZDhlZjhhNDUxYWViNzJmYTNiMDMyZjVhZTI1NTRiNWEwZDkwY2YzNDA5N2RmYmU5OGUzNGY4M2VlYyIsInRhZyI6IiJ9') =>\Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6IkZtczdUT1NKRDZoZnZrazNoc1lSb0E9PSIsInZhbHVlIjoiYWlBb3VXaVpkcVlJMjJCSXF5N0dJQT09IiwibWFjIjoiZTU1NjMzMmVjYjAxMDIyMWY5YzdhNzk3NjM3Yzg4ODgyMmRkNTkxNjViNTI2MzZjNjJmZGYxY2I2OTljODI1YSIsInRhZyI6IiJ9'),
            ]
        ]);

        $obj = json_decode($res->getBody());
        if ($obj->status == '1') {
            return Redirect::to('/admin')->with('success', 'Success');
        } else {
            return Redirect::back()->with('error', $obj->message);
        }

    } 
}
