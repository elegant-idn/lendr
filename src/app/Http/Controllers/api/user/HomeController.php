<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Testimonials;
use App\Models\Blog;
use App\Models\SystemAddons;
use App\helper\helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 400);
        }

        $getbannersection1 = Banner::select("vendor_id","product_id","category_id",DB::raw("CONCAT('".url(env('ASSETPATHURL').'admin-assets/images/banner')."/', image) AS image"),"type")->where('section', '1')->where('is_available',1)->where('vendor_id', $request->vendor_id)->orderByDesc('id')->get();

        $getbannersection2 = Banner::select("vendor_id","product_id","category_id",DB::raw("CONCAT('".url(env('ASSETPATHURL').'admin-assets/images/banner')."/', image) AS image"),"type")->where('section', '2')->where('is_available',1)->where('vendor_id', $request->vendor_id)->orderByDesc('id')->get();

        $getcategories = Category::select("id","vendor_id","name",DB::raw("CONCAT('".url(env('ASSETPATHURL').'admin-assets/images/categories')."/', image) AS image"))->where('is_available', "1")->where('is_deleted', "2")->where('vendor_id', $request->vendor_id)->take(12)->get();

        $getproducts = Product::with('product_image_api', 'category_info', 'fetures_info')->where('is_available', "1")->where('is_deleted', "2")->where('vendor_id', $request->vendor_id)->orderByDesc('id')->take(12)->get();

        $testimonials = Testimonials::select("star","description","name",DB::raw("CONCAT('".url(env('ASSETPATHURL').'admin-assets/images/testimonials/')."/', image) AS image"),"position")->where('vendor_id', $request->vendor_id)->get();

        $blogs = Blog::select("id","title","description",DB::raw("CONCAT('".url(env('ASSETPATHURL').'admin-assets/images/blog/')."/', image) AS image"),"created_at")->where('vendor_id', $request->vendor_id)->get();
        return response()->json(["status" => 1, "message" => trans('messages.success'), 'getbannersection1' =>  $getbannersection1, 'getbannersection2' => $getbannersection2, 'getcategories' => $getcategories, 'getproducts' => $getproducts, 'testimonials' => $testimonials, 'blogs' => $blogs], 200);
    }

    public function category(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 400);
        }

        $getcategories = Category::select("id","vendor_id","name",DB::raw("CONCAT('".url(env('ASSETPATHURL').'admin-assets/images/categories')."/', image) AS image"))->where('is_available', "1")->where('is_deleted', "2")->where('vendor_id', $request->vendor_id)->get();
        return response()->json(["status" => 1, "message" => trans('messages.success'), 'data' =>  $getcategories], 200);
    }

    public function categorywise_product(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 400);
        }

        if ($request->category_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.category_id_required')], 400);
        }

        $product = Product::with('category_info', 'fetures_info', 'product_image_api')->where('vendor_id', $request->vendor_id)->where('is_available', 1)->where('is_deleted', 2)->where('category_id', $request->category_id)->get();
        
        if (empty($product)) {
            return response()->json(["status" => 0, "message" => trans('messages.no_data')], 200);
        }
        return response()->json(["status" => 1, "message" => trans('messages.success'), 'product' =>  $product], 200);
    }

    public function systemaddon(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 400);
        }
        $addons = SystemAddons::select('unique_identifier', 'activated')->get();
        $checkcustomerlogin = helper::appdata($request->vendor_id)->checkout_login_required;
        return response()->json(["status" => 1, "message" => trans('messages.success'), 'addons' =>  $addons, 'checkout_login_required' => $checkcustomerlogin, 'session_id'=>session()->getId()], 200);
    }

    public function bloglist(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 400);
        }
        $bloglist = Blog::select("*",DB::raw("CONCAT('".url(env('ASSETPATHURL').'admin-assets/images/blog/')."/', image) AS image"),"created_at")->where('vendor_id', $request->vendor_id)->get();
        return response()->json(["status" => 1, "message" => trans('messages.success'), 'blogs' =>  $bloglist], 200);
    }
}
