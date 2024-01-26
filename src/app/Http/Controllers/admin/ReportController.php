<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $getbookings = Booking::where('vendor_id', Auth::user()->id);
        if ($request->has('type') && $request->type != "") {
            if ($request->type == "bookings") {
                $getbookings = $getbookings;
             }
            if ($request->type == "processing") {
                $getbookings = $getbookings->whereIn('status', array(1,2,3));
            }
            if ($request->type == "canceled") {
                $getbookings = $getbookings->whereIn('status', array(4,5));
            }
           
            if ($request->type == "completed") {
                $getbookings = $getbookings->where('status', 6);
            }
        }
        $totalbooking = Booking::where('vendor_id', Auth::user()->id)->count();
        $totalprocessing = Booking::whereIn('status', [1, 2, 3])->where('vendor_id', Auth::user()->id)->count();
        $totalcompleted = Booking::where('status', 6)->where('vendor_id', Auth::user()->id)->count();
        $totalcanceled = Booking::whereIn('status', [4, 5])->where('vendor_id', Auth::user()->id)->count();
        if (!empty($request->startdate) && !empty($request->enddate)) {
            $getbookings = $getbookings->whereBetween('checkin_date', [$request->startdate, $request->enddate])->orwhereBetween('checkout_date',[$request->startdate, $request->enddate]);
            $totalbooking = Booking::where('vendor_id', Auth::user()->id)->whereBetween('checkin_date', [$request->startdate, $request->enddate])->orwhereBetween('checkout_date',[$request->startdate, $request->enddate])->count();
            $totalprocessing = Booking::whereIn('status', [1, 2, 3])->where('vendor_id', Auth::user()->id)->whereBetween('checkin_date', [$request->startdate, $request->enddate])->orwhereBetween('checkout_date',[$request->startdate, $request->enddate])->count();
            $totalcompleted = Booking::where('status', 6)->where('vendor_id', Auth::user()->id)->whereBetween('checkin_date', [$request->startdate, $request->enddate])->orwhereBetween('checkout_date',[$request->startdate, $request->enddate])->count();
            $totalcanceled = Booking::whereIn('status', [4,5])->where('vendor_id', Auth::user()->id)->whereBetween('checkin_date', [$request->startdate, $request->enddate])->orwhereBetween('checkout_date',[$request->startdate, $request->enddate])->count();
        }
        $getbookings = $getbookings->orderByDesc('id')->get();
        return view('admin.booking.report', compact('getbookings','totalprocessing','totalcanceled', 'totalcompleted','totalbooking'));
    }
    public function status_change(Request $request)
    {
        Booking::where('booking_number', $request->booking_number)->update(['status' => $request->status]);
        return redirect('admin/reports?startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate'))->with('success', trans('messages.success'));
    }
}
