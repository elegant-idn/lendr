<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    public function view_category()
    {
        $allcategories = Category::orderByDesc('id')->whereNot('is_deleted', 1)->get();
        return view('admin.category.category', compact("allcategories"));
    }
    public function add_category(Request $request)
    {
        return view('admin.category.add_category');
    }
    public function save_category(Request $request)
    {
        $request->validate([
            'category_image' => 'image',
        ]);
        $check_slug = Category::where('slug', Str::slug($request->category_name, '-'))->first();
        if (!empty($check_slug)) {
            $last_id = Category::select('id')->orderByDesc('id')->first();
            $slug = Str::slug($request->category_name . ' ' . $last_id->id, '-');
        } else {
            $slug = Str::slug($request->category_name, '-');
        }
        $savecategory = new Category();
        $savecategory->vendor_id = Auth::user()->id;
        $savecategory->name = $request->category_name;
        $savecategory->slug = $slug;
        if ($request->has('category_image')) {
            $image = 'category-' . uniqid() . "." . $request->file('category_image')->getClientOriginalExtension();
            $request->file('category_image')->move(storage_path('app/public/admin-assets/images/categories/'), $image);
            $savecategory->image = $image;
        }
        $savecategory->save();
        return redirect('/admin/categories/')->with('success', trans('messages.success'));
    }
    public function edit_category($slug)
    {
        $editcategory = Category::where('slug', $slug)->first();
        return view('admin.category.edit_category', compact("editcategory"));
    }
    public function update_category(Request $request, $slug)
    {
        $editcategory = Category::where('slug', $slug)->first();
        $request->validate([
            'category_image' => 'image',
        ]);
        $check_slug = Category::where('slug', Str::slug($request->category_name, '-'))->first();
        if (!empty($check_slug)) {
            $last_id = Category::select('id')->orderByDesc('id')->first();
            $slug = Str::slug($request->category_name . ' ' . $last_id->id, '-');
        } else {
            $slug = Str::slug($request->category_name, '-');
        }
        $editcategory->name = $request->category_name;
        $editcategory->slug = $slug;
        if ($request->has('category_image')) {
            if (file_exists(storage_path('app/public/admin-assets/images/categories/' . Auth::user()->image))) {
                unlink(storage_path('app/public/admin-assets/images/categories/' .  Auth::user()->image));
            }
            $edit_image = $request->file('category_image');
            $profileImage = 'category-' . uniqid() . "." . $edit_image->getClientOriginalExtension();
            $edit_image->move(storage_path('app/public/admin-assets/images/categories/'), $profileImage);
            $editcategory->image = $profileImage;
        }
        $editcategory->update();
        return redirect('/admin/categories')->with('success', trans('messages.success'));
    }
    public function change_status($slug, $status)
    {
        $checkcategory = Category::where('slug', $slug)->first();
        if (!empty($checkcategory)) {
           
            Category::where('slug', $slug)->update(['is_available' => $status]);
            return redirect('/admin/categories')->with('success', trans('messages.success'));
        } else {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
    public function delete_category($slug)
    {
        $checkcategory = Category::where('slug', $slug)->first();
        if (!empty($checkcategory)) {
            $checkcategory->is_deleted = "1";
            $checkcategory->save();
            return redirect('/admin/categories')->with('success', trans('messages.success'));
        } else {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
}
