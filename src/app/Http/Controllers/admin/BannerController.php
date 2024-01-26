<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotionalbanner;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class BannerController extends Controller

{

    public function index(){

        $getbanner = Banner::orderByDesc('id')->where('vendor_id',Auth::user()->id)->get();
        return view('admin.banner.index',compact('getbanner'));

    }

    public function add()

    {

        $category = Category::where('is_deleted', "2")->where('vendor_id',Auth::user()->id)->get();

        $product = Product::where('is_deleted', "2")->where('vendor_id',Auth::user()->id)->get();
        return view('admin.banner.add',compact('category','product'));

    }

    public function edit($id)

    {

        $category = Category::where('is_deleted', "2")->where('vendor_id',Auth::user()->id)->get();

        $product = Product::where('is_deleted', "2")->where('vendor_id',Auth::user()->id)->get();
       
        $banner = Banner::where('id',$id)->first();

        return view('admin.banner.edit',compact('category','product','banner'));

    }

    public function save_banner(Request $request)

    {

         $request->validate([

                'category'=>'required_if:type,1',

                'service' => 'required_if:type,2',

                'image' => 'required|image',

            ], [

                'category.required_if' => trans('messages.category_required'),

                'service.required_if' => trans('messages.service_required'),

                'image.required' => trans('messages.image_required'),

            ]);

        $banner = new Banner();

        $banner->vendor_id = Auth::user()->id;

        if($request->type == "1")

        {

            $banner->category_id = $request->category;

            $banner->product_id =null;

        }

        if($request->type == "2")

        {

            $banner->product_id = $request->service;

            $banner->category_id = null;

        }

        $banner->type = $request->type;

        $banner->section = $request->section;
        if($request->section == 1)
        {
            $banner->title = $request->title; 
            $banner->sub_title = $request->subtitle; 
            $banner->link_text = $request->link_text; 
        }
        if ($request->has('image')) {

            $reimage = 'banner-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();

            $request->file('image')->move(storage_path('app/public/admin-assets/images/banner/'), $reimage);

            $banner->image = $reimage;

        }
        $banner->save();
        return redirect('admin/bannersection-'.$request->section)->with('success', trans('messages.success'));

    }

    public function edit_banner(Request $request,$id)

    {

        $request->validate([

            'category'=>'required_if:type,1',

            'service' => 'required_if:type,2',

            'image' => 'image',

        ], [

            'category.required_if' => trans('messages.category_required'),

            'service.required_if' => trans('messages.service_required'),

        ]);

        $banner = Banner::where('id',$id)->first();

        $banner->vendor_id = Auth::user()->id;

        if($request->type == "1")

        {

            $banner->category_id = $request->category;

            $banner->product_id =null;

        }

        if($request->type == "2")

        {

            $banner->product_id = $request->service;

            $banner->category_id = null;

        }

        $banner->type = $request->type;

        $banner->section = $request->section;
        if($request->section == 1)
        {
            $banner->title = $request->title; 
            $banner->sub_title = $request->subtitle; 
            $banner->link_text = $request->link_text; 
        }
        if ($request->has('image')) {

            if (file_exists(storage_path('app/public/admin-assets/images/banner/' .$banner->image))) {

                unlink(storage_path('app/public/admin-assets/images/banner/' . $banner->image));

            }

            $reimage = 'banner-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();

            $request->file('image')->move(storage_path('app/public/admin-assets/images/banner/'), $reimage);

            $banner->image = $reimage;

        }

        $banner->update();

        return redirect('/admin/bannersection-'.$request->section)->with('success', trans('messages.success'));

    }

    public function status_update($id,$status)

    {

        Banner::where('id',$id)->update(['is_available'=>$status]);

        return redirect()->back()->with('success',trans('messages.success'));

    }

    public function delete($id)

    {

        $banner = Banner::where('id', $id)->first();

        if (file_exists(storage_path('app/public/admin-assets/images/banner/' .$banner->image))) {

            unlink(storage_path('app/public/admin-assets/images/banner/' . $banner->image));

        }

        $banner->delete();

        return redirect()->back()->with('success',trans('messages.success'));

    }
    public function promotional_banner()
    {
        $getbannerlist = Promotionalbanner::with('vendor_info')->get();
        return view('admin.promotionalbanners.index',compact('getbannerlist'));
    }
    public function promotional_banneradd()
    {
        $vendors = User::where('is_available',1)->where('is_verified',1)->where('type',2)->get();
        return view('admin.promotionalbanners.add',compact('vendors'));
    }
    public function promotional_bannersave_banner(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
        ], [
            'image.required' => trans('messages.image_required'),
        ]);
        $banner = new Promotionalbanner();
        if ($request->has('image')) {
            $image = 'promotion-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(storage_path('app/public/admin-assets/images/banner/'), $image);
            $banner->image = $image;
        }
        $banner->vendor_id = $request->vendor;
        $banner->save();
        return redirect('admin/promotionalbanners')->with('success', trans('messages.success'));
    }
    public function promotional_banneredit(Request $request)
    {
        $vendors = User::where('is_available',1)->where('is_verified',1)->where('type',2)->get();
        $banner = Promotionalbanner::where('id',$request->id)->first();
        return view('admin.promotionalbanners.edit',compact('vendors','banner'));
    }
    public function promotional_bannerupdate(Request $request)
    {
        $request->validate([
            'image' => 'image',
        ]);
        $banner = Promotionalbanner::where('id',$request->id)->first();
        if ($request->has('image')) {
            if (file_exists(storage_path('app/public/admin-assets/images/banner/' .$banner->image))) {
                unlink(storage_path('app/public/admin-assets/images/banner/' . $banner->image));
            }
            $image = 'promotion-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(storage_path('app/public/admin-assets/images/banner/'), $image);
            $banner->image = $image;
        }
        $banner->vendor_id = $request->vendor;
        $banner->update();
        return redirect('admin/promotionalbanners')->with('success', trans('messages.success'));
    }
    public function promotional_bannerdelete(Request $request)
    {
        $banner = Promotionalbanner::where('id', $request->id)->first();
        if (file_exists(storage_path('app/public/admin-assets/images/banner/' .$banner->image))) {
            unlink(storage_path('app/public/admin-assets/images/banner/' . $banner->image));
        }
        $banner->delete();
        return redirect()->back()->with('success',trans('messages.success'));
    }

}

