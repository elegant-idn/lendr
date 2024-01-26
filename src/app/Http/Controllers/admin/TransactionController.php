<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\SystemAddons;
use App\Models\User;
use App\helper\helper;
use Illuminate\Support\Facades\Auth;
class TransactionController extends Controller
{
  public function index(Request $request)
  {
    if (SystemAddons::where('unique_identifier', 'subscription')->first() == null) {
      return redirect()->back()->with(['error' => 'You can not charge your end customers in regular license. Please purchase extended license to charge your end customers']);
    } else {
      $vendors = User::whereNotIn('id', [1])->get();
      if (Auth::user()->type == "1") {
        $transaction = Transaction::with('vendor_info');
        if (!empty($request->vendor)) {
          $transaction = $transaction->where('vendor_id', $request->vendor);
        }
        if (!empty($request->startdate) && !empty($request->enddate)) {
          $transaction =  $transaction->whereBetween('purchase_date', [$request->startdate, $request->enddate]);
        }
        $transaction = $transaction->get();
      }
      if (Auth::user()->type == "2") {
        $transaction = Transaction::with("plan_info")->where('vendor_id', Auth::user()->id)->orderByDesc('id');
        if (!empty($request->startdate) && !empty($request->enddate)) {
          $transaction =  $transaction->whereBetween('purchase_date', [$request->startdate, $request->enddate]);
        }
        $transaction = $transaction->get();
      }
    
      return view('admin.transaction.transaction', compact('transaction', 'vendors'));
    }
  }
  public function status(Request $request)
  {
    $transaction = Transaction::find($request->id);
    if (!empty($transaction)) {
      if ($request->status == 2) {
        $transaction->purchase_date = date("Y-m-d h:i:sa");
        $transaction->expire_date = helper::get_plan_exp_date($transaction->duration, $transaction->days);
      }
      $transaction->status = $request->status;
      $transaction->save();
      $vendorinfo = User::where('id', $transaction->vendor_id)->first();
      if ($request->status == 2) {
        helper::send_subscription_email($vendorinfo->email, $vendorinfo->name, $transaction->plan_name, helper::get_plan_exp_date('', $transaction-> days), helper::currency_formate($transaction->amount, ""), "Banktransfer", "-");   
      } else {
        helper::subscription_rejected($vendorinfo->email, $vendorinfo->name, $transaction->plan_name, "Banktransfer");
      }
      return redirect('admin/transaction')->with('success', trans('messages.success'));
    }
    abort(404);
  }
}
