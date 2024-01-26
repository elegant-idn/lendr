<?php

namespace App\Http\Controllers\admin;

use App\helper\helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductFeatures;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('product_image', 'category_info')->where('vendor_id', Auth::user()->id)->where('is_deleted', "2")->orderByDesc('id')->get();
        return view('admin.product.index', compact('products'));
    }
    public function view($slug)
    {
        $product = Product::with('product_image', 'category_info', 'product_image_api')
            ->where('slug', $slug)
            ->whereNot('is_deleted', 1)
            ->first();
        
        $product->category = Category::where('id', $product->category_id)->first()->name;
            
        return view('admin.product.view', compact('product'));    
    }
    public function add()
    {
        $checkplan = helper::checkplan(Auth::user()->id, "");
        $v = json_decode(json_encode($checkplan));
        if (@$v->original->status == 2 && @$v->original->checklimit == 'service') {
            return redirect()->back()->with('error', @$v->original->message);
        }
        $category = Category::where('is_deleted', "2")->where('is_available', 1)->where('vendor_id', Auth::user()->id)->get();
        return view('admin.product.add', compact("category"));
    }
    public function save(Request $request)
    {
        $check_slug = Product::where('slug', Str::slug($request->title, '-'))->first();
        if (!empty($check_slug)) {
            $last_id = Product::select('id')->orderByDesc('id')->first();
            $slug = Str::slug($request->title . ' ' . $last_id->id, '-');
        } else {
            $slug = Str::slug($request->title, '-');
        }
        $newproduct = new Product();
        $newproduct->vendor_id = Auth::user()->id;
        $newproduct->category_id = $request->category_name;
        $newproduct->title = $request->title;
        $newproduct->slug = $slug;
        $newproduct->per_hour_price = $request->per_hour_price;
        $newproduct->per_day_price = $request->per_day_price;
        $newproduct->minimum_booking_hour = $request->minimum_booking_limit;
        $newproduct->tax = $request->tax;
        $newproduct->description = $request->description;
        $newproduct->additional_details = $request->additional_info;
        $newproduct->save();
        if ($request->has('service_image')) {
            foreach ($request->file('service_image') as $file) {
                $reimage = 'product-' . uniqid() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path('app/public/admin-assets/images/product/'), $reimage);
                $image = new ProductImage();
                $image->product_id = $newproduct->id;
                $image->image = $reimage;
                $image->save();
            }
        }
        if (!empty($request->feature_image)) {

            foreach ($request->feature_image as $key => $icon) {

                if (!empty($icon) && !empty($request->feature_title[$key]) && !empty($request->feature_description[$key])) {
                    $feature = new ProductFeatures;
                    $feature->vendor_id = Auth::user()->id;
                    $feature->product_id = $newproduct->id;

                    $reimage = 'product-' . uniqid() . "." . $icon->getClientOriginalExtension();
                    $icon->move(storage_path('app/public/admin-assets/images/product/'), $reimage);
                    $feature->image = $reimage;

                    $feature->title = $request->feature_title[$key];
                    $feature->sub_title = $request->feature_description[$key];
                    $feature->save();
                }
            }
        }
        return redirect('/admin/products/')->with('success', trans('messages.success'));
    }
    public function edit($slug)
    {
        $category = Category::where('is_deleted', "2")->where('is_available', 1)->where('vendor_id', Auth::user()->id)->get();
        $product = Product::with('multi_image', 'fetures_info')->where('slug', $slug)->first();

        return view('admin.product.edit', compact('product', 'category'));
    }
    public function update(Request $request)
    {
        try {
            $check_slug = Product::where('slug', Str::slug($request->title, '-'))->first();
            if (!empty($check_slug)) {
                $last_id = Product::select('id')->orderByDesc('id')->first();
                $slug = Str::slug($request->title . ' ' . $last_id->id, '-');
            } else {
                $slug = Str::slug($request->title, '-');
            }
            $editproduct = Product::where('slug', $request->slug)->where('vendor_id', Auth::user()->id)->first();
            $editproduct->category_id = $request->category_name;
            $editproduct->title = $request->title;
            $editproduct->slug = $slug;
            $editproduct->per_hour_price = $request->per_hour_price;
            $editproduct->per_day_price = $request->per_day_price;
            $editproduct->minimum_booking_hour = $request->minimum_booking_limit;
            $editproduct->tax = $request->tax;
            $editproduct->description = $request->description;
            $editproduct->additional_details = $request->additional_info;
            $editproduct->update();
            if (!empty($request->feature_image)) {
                foreach ($request->feature_image as $key => $icon) {
                    if (!empty($icon) && !empty($request->feature_title[$key]) && !empty($request->feature_description[$key])) {
                        $feature = new ProductFeatures;
                        $feature->vendor_id = Auth::user()->id;
                        $feature->product_id = $editproduct->id;
                        $reimage = 'product-' . uniqid() . "." . $icon->getClientOriginalExtension();
                        $icon->move(storage_path('app/public/admin-assets/images/product/'), $reimage);
                        $feature->image =  $reimage;
                        $feature->title = $request->feature_title[$key];
                        $feature->sub_title = $request->feature_description[$key];
                        $feature->save();
                    }
                }
            }

            if (!empty($request->edit_icon_key)) {
                foreach ($request->edit_icon_key as $key => $id) {
                    $feature = ProductFeatures::find($id);
                    if ($request->edi_feature_image != null) {
                        if (array_key_exists($id, $request->edi_feature_image)) {
                            if (file_exists(storage_path('app/public/admin-assets/images/product/' . $feature->image))) {
                                unlink(storage_path('app/public/admin-assets/images/product/' .  $feature->image));
                            }
                            $reimage = 'product-' . uniqid() . "." . $request->edi_feature_image[$id]->getClientOriginalExtension();
                            $request->edi_feature_image[$id]->move(storage_path('app/public/admin-assets/images/product/'), $reimage);
                            $feature->image = $reimage;
                        }
                    }
                    if (array_key_exists($id, $request->edi_feature_title)) {
                        $feature->title =   $request->edi_feature_title[$id];
                    }
                    if (array_key_exists($id, $request->edi_feature_description)) {
                        $feature->sub_title =   $request->edi_feature_description[$id];
                    }
                    $feature->update();
                }
            }
            return redirect('/admin/products/')->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
            return redirect('/admin/products/')->with('error', trans('messages.wrong'));
        }
    }
    public function update_image(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ['product_image' => 'image'],
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', trans('messages.wrong'));
        } else {
            if ($request->has('product_image')) {
                if (file_exists(storage_path('app/public/admin-assets/images/product/' . $request->image))) {
                    unlink(storage_path('app/public/admin-assets/images/product/' .  $request->image));
                }
                $productimage = 'product-' . uniqid() . "." . $request->file('product_image')->getClientOriginalExtension();
                $request->file('product_image')->move(storage_path('app/public/admin-assets/images/product/'), $productimage);
                ProductImage::where('id', $request->id)->update(['image' => $productimage]);
                return redirect()->back()->with('success', trans('messages.success'));
            } else {
                return redirect()->back()->with('error', trans('messages.wrong'));
            }
        }
    }
    public function delete($slug)
    {
        try {
            Product::where('slug', $slug)->delete();
            return redirect('admin/products/approval')->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
    public function delete_image($id, $product_id)
    {

        $count = ProductImage::where('product_id', $product_id)->count();
        if ($count > 1) {
            ProductImage::where('id', $id)->delete();
            return redirect()->back()->with('success', trans('messages.success'));
        } else {
            return redirect()->back()->with('error', trans('messages.last_image'));
        }
    }
    public function add_image(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ['image' => 'image'],
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', trans('messages.wrong'));
        } else {
            $product_image = new ProductImage();
            $product_image->product_id = $request->product_id;
            if ($request->has('image')) {
                $image = 'product-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(storage_path('app/public/admin-assets/images/product/'), $image);
                $product_image->image = $image;
            }
            $product_image->save();
            return redirect()->back()->with('success', trans('messages.success'));
        }
    }
    public function status_change($slug, $status)
    {
        Product::where('slug', $slug)->update(['is_available' => $status]);
        return redirect('admin/products/approval')->with('success', trans('messages.success'));
    }
    public function delete_feature(Request $request)
    {
        $features = ProductFeatures::where('id', $request->id)->first();
        if (file_exists(storage_path('app/public/admin-assets/images/product/' . $features->image))) {
            unlink(storage_path('app/public/admin-assets/images/product/' .  $features->image));
        }
        $features->delete();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function approval()
    {
        $products = Product::with('product_image', 'category_info', 'product_image_api')
            ->whereNot('is_deleted', 1)
            ->whereNot('is_available', 1)
            ->get();
        return view('admin.product.approval', compact('products'));
    }
    public function approval_selected(Request $request)
    {
        if(!$request->selected_products) {
            return redirect()->back();
        }
        if($request->action == 'approve') {
            foreach ($request->selected_products as $productId) {
                $product = Product::find($productId)->update(['is_available' => 1]);
            }
        } elseif($request->action == 'delete') {
            foreach ($request->selected_products as $productId) {
                $product = Product::find($productId)->delete();
            }
        }
        return redirect()->back()->with('success', trans('messages.success'));
        }
}
