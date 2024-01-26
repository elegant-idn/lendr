<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\WhyChooseUs;
use Illuminate\Support\Facades\Auth;
class WhyChooseUsController extends Controller
{
    public function index(Request $request)
    {
        $content = Settings::where('vendor_id',Auth::user()->id)->first();
        $allworkcontent = WhyChooseUs::where('vendor_id',Auth::user()->id)->get();
        return view('admin.why_choose_us.index',compact('content','allworkcontent'));
    }
    public function savecontent(Request $request)
    {
        $request->validate([
            'image' => 'image',
        ]);
        $newcontent = Settings::where('vendor_id',Auth::user()->id)->first();
        $newcontent->why_choose_title = $request->title;
        $newcontent->why_choose_subtitle = $request->subtitle;
        if ($request->has('image')) {
            $image = 'choose-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(storage_path('app/public/admin-assets/images/index/'), $image);
            $newcontent->why_choose_image = $image;
        }
        $newcontent->save();
        return redirect('admin/choose_us')->with('success', trans('messages.success'));
    }
    public function add(Request $request)
    {
        return view('admin.why_choose_us.add');
    }
    public function save(Request $request)
    {
        $newwork = new WhyChooseUs();
        $newwork->vendor_id = Auth::user()->id;
        $newwork->title = $request->title;
        $newwork->description = $request->description;
        $newwork->save();
        return redirect('admin/choose_us')->with('success', trans('messages.success'));
    }
    public function edit(Request $request)
    {
        $editwork = WhyChooseUs::where('id',$request->id)->where('vendor_id',Auth::user()->id)->first();
        return view('admin.why_choose_us.edit',compact('editwork'));
    }
    public function update(Request $request)
    {
        $editwork = WhyChooseUs::where('id',$request->id)->where('vendor_id',Auth::user()->id)->first();
        $editwork->title = $request->title;
        $editwork->description = $request->description;
        $editwork->update();
        return redirect('admin/choose_us')->with('success', trans('messages.success'));
    }
    public function delete(Request $request)
    {
        $deletework = WhyChooseUs::where('id',$request->id)->where('vendor_id',Auth::user()->id)->first();
        $deletework->delete();
        return redirect('admin/choose_us')->with('success', trans('messages.success'));
    }
}
