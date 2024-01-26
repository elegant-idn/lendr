<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Features;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FeaturesController extends Controller
{
    public function index(Request $request)
    {
        $features = Features::where('vendor_id', Auth::user()->id)->orderByDesc('id')->get();
        return view('admin.features.index', compact('features'));
    }
    public function add(Request $request)
    {
        return view('admin.features.add');
    }
    public function save(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
        ], [
            'title.required' => trans('messages.title_required'),
            'description.required' => trans('messages.description_required'),
            'image.required' => trans('messages.image_required'),
        ]);

        $features = new Features();
        $features->vendor_id = Auth::user()->id;
        $features->title = $request->title;
        $features->description = $request->description;
        if ($request->has('image')) {
            $featureimage = 'feature-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(storage_path('app/public/admin-assets/images/feature/'), $featureimage);
            $features->image = $featureimage;
        }
        $features->save();
        return redirect('admin/features')->with('success', trans('messages.success'));
    }
    public function edit(Request $request)
    {
        $editfeature = Features::where('id', $request->id)->first();
        return view('admin.features.edit', compact('editfeature'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'image',
        ], [
            'title.required' => trans('messages.title_required'),
            'description.required' => trans('messages.description_required'),
        ]);
        $editfeature = Features::where('id', $request->id)->first();
        $editfeature->vendor_id = Auth::user()->id;
        $editfeature->title = $request->title;
        $editfeature->description = $request->description;
        if ($request->has('image')) {
            if (file_exists(storage_path('app/public/admin-assets/images/feature/' . $editfeature->image))) {
                unlink(storage_path('app/public/admin-assets/images/feature/' . $editfeature->image));
            }
            $featureimage = 'feature-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(storage_path('app/public/admin-assets/images/feature/'), $featureimage);
            $editfeature->image = $featureimage;
        }
        $editfeature->update();
        return redirect('admin/features')->with('success', trans('messages.success'));
    }
    public function delete(Request $request)
    {
        $feature = Features::where('id', $request->id)->first();
        if (file_exists(storage_path('app/public/admin-assets/images/feature/' . $feature->image))) {
            unlink(storage_path('app/public/admin-assets/images/feature/' . $feature->image));
        }
        $feature->delete();
        return redirect()->back()->with('success', trans('messages.success'));
    }
}
