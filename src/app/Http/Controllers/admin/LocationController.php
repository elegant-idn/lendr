<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $locations = Location::where('vendor_id',Auth::user()->id)->get();
        return view('admin.location.index',compact('locations'));
    }
    public function add(Request $request)
    {
        return view('admin.location.add');
    }
    public function edit(Request $request)
    {
        $editlocation = Location::where('id',$request->id)->where('vendor_id',Auth::user()->id)->first();
        return view('admin.location.edit',compact('editlocation'));
    }
    public function save(Request $request)
    {
      
       $location = new Location();
       $location->vendor_id = Auth::user()->id;
       $location->type = $request->section;
       $location->is_available = 1;
        if($request->section == 1)
        {
            $location->pickup_location = $request->pickup_location;
          
        }
        if($request->section == 2)
        {
            $location->drop_location = $request->drop_location;
        }
        $location->save();
        if($request->section == 1)
        {
            return redirect('/admin/pickup_location/')->with('success', trans('messages.success'));
        }
        else
        {
            return redirect('/admin/drop_location/')->with('success', trans('messages.success'));
        }
    }
    public function update(Request $request)
    {
        try {
        $editlocation = Location::where('id',$request->id)->where('vendor_id',Auth::user()->id)->first();
        $redirect ="";
        if($request->type == 1)
        {
            $redirect = "pickup_location";
            $editlocation->pickup_location = $request->pickup_location;
          
        }
        elseif($request->type == 2)
        {
            $redirect = "drop_location";
            $editlocation->drop_location = $request->drop_location;
           
        }
       
        $editlocation->update();
        return redirect('/admin/'.$redirect)->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
            return redirect('/admin/'.$redirect)->with('error', trans('messages.wrong'));
        }
       
    }
    public function status_change(Request $request)
    {
        Location::where('id',$request->id)->update(['is_available'=>$request->status]);
        return redirect()->back()->with('success',trans('messages.success'));
    }
    public function delete(Request $request)
    {
        $location = Location::where('id',$request->id)->first();
       
        $location->delete();
        if($request->type == 1)
        {
            return redirect('/admin/pickup_location')->with('success', trans('messages.success'));
        }
        else
        {
            return redirect('/admin/drop_location')->with('success', trans('messages.success'));
        }
        
    }
}
