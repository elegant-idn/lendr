<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Works;
use Illuminate\Support\Facades\Auth;
class WorksController extends Controller
{
    public function index(Request $request)
    {
        $content = Settings::where('vendor_id',Auth::user()->id)->first();
        $allworkcontent = Works::where('vendor_id',Auth::user()->id)->get();
        return view('admin.how_work.index',compact('content','allworkcontent'));
    }
    public function savecontent(Request $request)
    {
        $newcontent = Settings::where('vendor_id',Auth::user()->id)->first();
        $newcontent->work_title = $request->title;
        $newcontent->work_subtitle = $request->subtitle;
        $newcontent->save();
        return redirect('admin/how_works')->with('success', trans('messages.success'));
    }
    public function add(Request $request)
    {
        return view('admin.how_work.add');
    }
    public function save(Request $request)
    {
        $newwork = new Works();
        $newwork->vendor_id = Auth::user()->id;
        $newwork->title = $request->title;
        $newwork->sub_title = $request->subtitle;
        $newwork->save();
        return redirect('admin/how_works')->with('success', trans('messages.success'));
    }
    public function edit(Request $request)
    {
        $editwork = Works::where('id',$request->id)->where('vendor_id',Auth::user()->id)->first();
        return view('admin.how_work.edit',compact('editwork'));
    }
    public function update(Request $request)
    {
        $editwork = Works::where('id',$request->id)->where('vendor_id',Auth::user()->id)->first();
        $editwork->title = $request->title;
        $editwork->sub_title = $request->subtitle;
        $editwork->update();
        return redirect('admin/how_works')->with('success', trans('messages.success'));
    }
    public function delete(Request $request)
    {
        $deletework = Works::where('id',$request->id)->where('vendor_id',Auth::user()->id)->first();
        $deletework->delete();
        return redirect('admin/how_works')->with('success', trans('messages.success'));
    }
}
