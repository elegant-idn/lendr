<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $allgallery = Gallery::where('vendor_id',Auth::user()->id)->orderBydesc('id')->get();
        return view('admin.gallery.index',compact('allgallery'));
    }
    public function add(Request $request)
    {
        return view('admin.gallery.add');
    }
    public function edit(Request $request)
    {
        $editgallery = Gallery::where('id',$request->id)->where('vendor_id',Auth::user()->id)->first();
        return view('admin.gallery.edit',compact('editgallery'));
    }
    public function save(Request $request)
    {
        $request->validate([
            'image' => 'image',
        ]);
        $newgallery = new Gallery();
        $newgallery->vendor_id = Auth::user()->id;
        if ($request->has('image')) {
            $reimage = 'gallery-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(storage_path('app/public/admin-assets/images/gallery/'), $reimage);
            $newgallery->image = $reimage;
        }
        $newgallery->save();
        return redirect('/admin/gallery/')->with('success', trans('messages.success'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'image' => 'image',
        ]);
        $editgallery = Gallery::where('id',$request->id)->where('vendor_id',Auth::user()->id)->first();
       
        if ($request->has('image')) {
         
            if (file_exists(storage_path('app/public/admin-assets/images/gallery/' .$editgallery->image))) {
                unlink(storage_path('app/public/admin-assets/images/gallery/' . $editgallery->image));
            }
            $reimage = 'gallery-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(storage_path('app/public/admin-assets/images/gallery/'), $reimage);
            $editgallery->image = $reimage;
        }
        $editgallery->update();
        return redirect('/admin/gallery/')->with('success', trans('messages.success'));
    }
    public function delete(Request $request)
    {
        $gallery = Gallery::where('id',$request->id)->first();
       
            if (file_exists(storage_path('app/public/admin-assets/images/gallery/' .$gallery->image))) {
                unlink(storage_path('app/public/admin-assets/images/gallery/' . $gallery->image));
            }
           
        $gallery->delete();
        return redirect('/admin/gallery/')->with('success', trans('messages.success'));
    }
}
