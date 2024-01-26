<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\helper\helper;

class BookingsController extends Controller
{
   public function index(Request $request)
   {
      $getbookings = Booking::where('vendor_id', Auth::user()->id);
      if (!empty($request->type)) {
         if ($request->type == "bookings") {
            $getbookings = $getbookings;
         }
         if ($request->type == "canceled") {
            $getbookings = $getbookings->whereIn('status', [4, 5]);
         }
         if ($request->type == "processing") {
            $getbookings = $getbookings->whereIn('status', [1, 2, 3]);
         }
         if ($request->type == "completed") {
            $getbookings = $getbookings->where('status', 6);
         }
      }
      $getbookings = $getbookings->orderByDesc('id')->get();

      $totalbooking = Booking::where('vendor_id', Auth::user()->id)->count();
      $totalprocessing = Booking::where('vendor_id', Auth::user()->id)->whereIn('status', [1, 2, 3])->count();
      $totalcanceled = Booking::where('vendor_id', Auth::user()->id)->whereIn('status', [4, 5])->count();
      $totalcompleted = Booking::where('vendor_id', Auth::user()->id)->where('status', 6)->count();
      return view('admin.booking.bookings', compact('getbookings', 'totalprocessing', 'totalcompleted', 'totalbooking', 'totalcanceled'));
   }
   public function booking_invoice(Request $request)
   {

      $invoice = Booking::where('booking_number', $request->booking_number)->first();
      session()->put('redirecturl', url()->previous());
      return view('admin.booking.booking_tracking', compact('invoice'));
   }
   public function status_change(Request $request)
   {
      try {
         $bookingdata = Booking::where('booking_number', $request->booking_number)->first();
         $title = "";
         $message_text = "";
         if ($request->status == "2") {
            $title = trans('labels.accepted');
            $message_text = 'Your Booking ' . $bookingdata->booking_number . ' has been accepted by Admin';
         }
         if ($request->status == "3") {
            $title = trans('labels.rejected');
            $message_text = 'Your Booking ' . $bookingdata->booking_number . ' has been in progress.';
         }
         if ($request->status == "4") {
            $title = trans('labels.rejected');
            $message_text = 'Your Booking ' . $bookingdata->booking_number . ' has been cancelled by Admin.';
         }
         if ($request->status == "6") {
            $title = trans('labels.completed');
            $message_text = 'Your Booking ' . $bookingdata->booking_number . ' has been Completed.';
         }

         $vendor = User::select('id', 'name')->where('id', $bookingdata->vendor_id)->first();
         helper::booking_status_email($bookingdata->email, $bookingdata->customer_name, $title, $message_text, $vendor);
         $bookingdata->status = $request->status;
         $bookingdata->update();
         return redirect(session()->get('redirecturl'))->with('success', trans('messages.success'));
      } catch (\Throwable $th) {
         return $th;
      }
   }
}
