<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\SystemAddons;
use Illuminate\Support\Facades\Auth;
class PaymentController extends Controller
{
    public function index(){
        if (SystemAddons::where('unique_identifier', 'subscription')->first() == null && Auth::user()->type == 1) {
            return redirect()->back()->with(['error' => 'You can not charge your end customers in regular license. Please purchase extended license to charge your end customers']);
        } else {
            if (Auth::user()->type == 2) {
                $getpayment = Payment::where('vendor_id',Auth::user()->id)->where('is_activate','1')->get();
            } else {
                $getpayment = Payment::where('vendor_id','1')->where('is_activate','1')->get();
            }
            return view('admin.payment.payment',compact("getpayment"));
        }
    }
    public function update(Request $request)
    {
        foreach($request->transaction_type as $key => $no){
            $data = Payment::find($no);
            if(!empty($request->is_available)){
                if(isset($request->is_available[strtolower($data->payment_name)])){
                    $data->is_available = $request->is_available[strtolower($data->payment_name)];
                }else{
                    $data->is_available = 2;
                }
            }else{
                $data->is_available = 2;
            }
            if(in_array(strtolower($data->payment_name),['razorpay','stripe','flutterwave','paystack','mercadopago','paypal','myfatoorah','toyyibpay'])){
                $data->environment = @$request->environment[strtolower($data->payment_name)] != "" ? $request->environment[strtolower($data->payment_name)] : "";
                $data->public_key = @$request->public_key[strtolower($data->payment_name)] != "" ? $request->public_key[strtolower($data->payment_name)] : "";
                $data->secret_key = @$request->secret_key[strtolower($data->payment_name)] != "" ? $request->secret_key[strtolower($data->payment_name)] : "";
                $data->currency = @$request->currency[strtolower($data->payment_name)] != "" ? $request->currency[strtolower($data->payment_name)] : "";
            }
            if(strtolower($data->payment_name) == 'flutterwave'){
                $data->encryption_key = $request->encryption_key;
            }else{
                $data->encryption_key = "";
            }
            if(strtolower($data->payment_name) == "banktransfer")
            {
                if (Auth::user()->type == 1) {
                    $data->bank_name = $request->bank_name;
                    $data->account_holder_name = $request->account_holder_name;
                    $data->account_number = $request->account_number;
                    $data->bank_ifsc_code = $request->bank_ifsc_code;
                }
            }
            $data->save();
        }
        if($request->hasFile('cod_image')){
            
            if (Auth::user()->type == 2) {
                $pay_data = Payment::where('payment_name', 'cod')->where('vendor_id',Auth::user()->id)->first();
            } else {
                $pay_data = Payment::where('payment_name', 'cod')->where('vendor_id',1)->first();
            }
            if($pay_data->image != "cod.png" && file_exists('storage/app/public/admin-assets/images/about/payment/'.$pay_data->image)){
                unlink('storage/app/public/admin-assets/images/about/payment/'.$pay_data->image);
            }
            $image = 'payment-' . uniqid() . '.' . $request->file('cod_image')->getClientOriginalExtension();
            $request->file('cod_image')->move('storage/app/public/admin-assets/images/about/payment/', $image);
            $pay_data->image = $image;
            $pay_data->save();
        }
        if($request->hasFile('wallet_image')){
            if (Auth::user()->type == 2) {
                $pay_data = Payment::where('payment_name', 'wallet')->where('vendor_id',Auth::user()->id)->first();
            } else {
                $pay_data = Payment::where('payment_name', 'wallet')->where('vendor_id',1)->first();
            }
            if($pay_data->image != "wallet.png" && file_exists('storage/app/public/admin-assets/images/about/payment/'.$pay_data->image)){
                unlink('storage/app/public/admin-assets/images/about/payment/'.$pay_data->image);
            }
            $image = 'payment-' . uniqid() . '.' . $request->file('wallet_image')->getClientOriginalExtension();
            $request->file('wallet_image')->move('storage/app/public/admin-assets/images/about/payment/', $image);
            $pay_data->image = $image;
            $pay_data->save();
        }
        if($request->hasFile('razorpay_image')){
            if (Auth::user()->type == 2) {
                $pay_data = Payment::where('payment_name', 'razorpay')->where('vendor_id',Auth::user()->id)->first();
            } else {
                $pay_data = Payment::where('payment_name', 'razorpay')->where('vendor_id',1)->first();
            }
            if($pay_data->image != "razorpay.png" && file_exists('storage/app/public/admin-assets/images/about/payment/'.$pay_data->image)){
                unlink('storage/app/public/admin-assets/images/about/payment/'.$pay_data->image);
            }
            $image = 'payment-' . uniqid() . '.' . $request->file('razorpay_image')->getClientOriginalExtension();
            $request->file('razorpay_image')->move('storage/app/public/admin-assets/images/about/payment/', $image);
            $pay_data->image = $image;
            $pay_data->save();
        }
        if($request->hasFile('stripe_image')){
            if (Auth::user()->type == 2) {
                $pay_data = Payment::where('payment_name', 'stripe')->where('vendor_id',Auth::user()->id)->first();
            } else {
                $pay_data = Payment::where('payment_name', 'stripe')->where('vendor_id',1)->first();
            }
            if($pay_data->image != "stripe.png" && file_exists('storage/app/public/admin-assets/images/about/payment/'.$pay_data->image)){
                unlink('storage/app/public/admin-assets/images/about/payment/'.$pay_data->image);
            }
            $image = 'payment-' . uniqid() . '.' . $request->file('stripe_image')->getClientOriginalExtension();
            $request->file('stripe_image')->move('storage/app/public/admin-assets/images/about/payment/', $image);
            $pay_data->image = $image;
            $pay_data->save();
        }
        if($request->hasFile('flutterwave_image')){
            if (Auth::user()->type == 2) {
                $pay_data = Payment::where('payment_name', 'flutterwave')->where('vendor_id',Auth::user()->id)->first();
            } else {
                $pay_data = Payment::where('payment_name', 'flutterwave')->where('vendor_id',1)->first();
            }
            if($pay_data->image != "flutterwave.png" && file_exists('storage/app/public/admin-assets/images/about/payment/'.$pay_data->image)){
                unlink('storage/app/public/admin-assets/images/about/payment/'.$pay_data->image);
            }
            $image = 'payment-' . uniqid() . '.' . $request->file('flutterwave_image')->getClientOriginalExtension();
            $request->file('flutterwave_image')->move('storage/app/public/admin-assets/images/about/payment/', $image);
            $pay_data->image = $image;
            $pay_data->save();
        }
        if($request->hasFile('paystack_image')){
            if (Auth::user()->type == 2) {
                $pay_data = Payment::where('payment_name', 'paystack')->where('vendor_id',Auth::user()->id)->first();
            } else {
                $pay_data = Payment::where('payment_name', 'paystack')->where('vendor_id',1)->first();
            }
            if($pay_data->image != "paystck.png" && file_exists('storage/app/public/admin-assets/images/about/payment/'.$pay_data->image)){
                unlink('storage/app/public/admin-assets/images/about/payment/'.$pay_data->image);
            }
            $image = 'payment-' . uniqid() . '.' . $request->file('paystack_image')->getClientOriginalExtension();
            $request->file('paystack_image')->move('storage/app/public/admin-assets/images/about/payment/', $image);
            $pay_data->image = $image;
            $pay_data->save();
        }
        if($request->hasFile('bank_image')){
            if (Auth::user()->type == 2) {
                $pay_data = Payment::where('payment_name', 'banktransfer')->where('vendor_id',Auth::user()->id)->first();
            } else {
                $pay_data = Payment::where('payment_name', 'banktransfer')->where('vendor_id',1)->first();
            }
            if($pay_data->image != "bank.png" && file_exists('storage/app/public/admin-assets/images/about/payment/'.$pay_data->image)){
                unlink('storage/app/public/admin-assets/images/about/payment/'.$pay_data->image);
            }
            $image = 'payment-' . uniqid() . '.' . $request->file('bank_image')->getClientOriginalExtension();
            $request->file('bank_image')->move('storage/app/public/admin-assets/images/about/payment/', $image);
            $pay_data->image = $image;
            $pay_data->save();
        }
        if($request->hasFile('mercadopago_image')){
            if (Auth::user()->type == 2) {
                $pay_data = Payment::where('payment_name', 'mercadopago')->where('vendor_id',Auth::user()->id)->first();
            } else {
                $pay_data = Payment::where('payment_name', 'mercadopago')->where('vendor_id',1)->first();
            }
            if($pay_data->image != "mercadopago.png" && file_exists('storage/app/public/admin-assets/images/about/payment/'.$pay_data->image)){
                unlink('storage/app/public/admin-assets/images/about/payment/'.$pay_data->image);
            }
            $image = 'payment-' . uniqid() . '.' . $request->file('mercadopago_image')->getClientOriginalExtension();
            $request->file('mercadopago_image')->move('storage/app/public/admin-assets/images/about/payment/', $image);
            $pay_data->image = $image;
            $pay_data->save();
        }
        if($request->hasFile('paypal_image')){
            if (Auth::user()->type == 2) {
                $pay_data = Payment::where('payment_name', 'paypal')->where('vendor_id',Auth::user()->id)->first();
            } else {
                $pay_data = Payment::where('payment_name', 'paypal')->where('vendor_id',1)->first();
            }
            if($pay_data->image != "paypal.png" && file_exists('storage/app/public/admin-assets/images/about/payment/'.$pay_data->image)){
                unlink('storage/app/public/admin-assets/images/about/payment/'.$pay_data->image);
            }
            $image = 'payment-' . uniqid() . '.' . $request->file('paypal_image')->getClientOriginalExtension();
            $request->file('paypal_image')->move('storage/app/public/admin-assets/images/about/payment/', $image);
            $pay_data->image = $image;
            $pay_data->save();
        }
        if($request->hasFile('myfatoorah_image')){
            if (Auth::user()->type == 2) {
                $pay_data = Payment::where('payment_name', 'myfatoorah')->where('vendor_id',Auth::user()->id)->first();
            } else {
                $pay_data = Payment::where('payment_name', 'myfatoorah')->where('vendor_id',1)->first();
            }
            if($pay_data->image != "myfatoorah.png" && file_exists('storage/app/public/admin-assets/images/about/payment/'.$pay_data->image)){
                unlink('storage/app/public/admin-assets/images/about/payment/'.$pay_data->image);
            }
            $image = 'payment-' . uniqid() . '.' . $request->file('myfatoorah_image')->getClientOriginalExtension();
            $request->file('myfatoorah_image')->move('storage/app/public/admin-assets/images/about/payment/', $image);
            $pay_data->image = $image;
            $pay_data->save();
        }
        if($request->hasFile('toyyibpay_image')){
            if (Auth::user()->type == 2) {
                $pay_data = Payment::where('payment_name', 'toyyibpay')->where('vendor_id',Auth::user()->id)->first();
            } else {
                $pay_data = Payment::where('payment_name', 'toyyibpay')->where('vendor_id',1)->first();
            }
            if($pay_data->image != "toyyibpay.png" && file_exists('storage/app/public/admin-assets/images/about/payment/'.$pay_data->image)){
                unlink('storage/app/public/admin-assets/images/about/payment/'.$pay_data->image);
            }
            $image = 'payment-' . uniqid() . '.' . $request->file('toyyibpay_image')->getClientOriginalExtension();
            $request->file('toyyibpay_image')->move('storage/app/public/admin-assets/images/about/payment/', $image);
            $pay_data->image = $image;
            $pay_data->save();
        }
        return redirect()->back()->with('success', trans('messages.success'));
    }
}
