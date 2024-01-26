<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonials;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
   public function index(Request $request)
   { 
    $testimonials = Testimonials::where('vendor_id',Auth::user()->id)->orderByDesc('id')->get();
      return view('admin.testimonial.index',compact('testimonials'));
   }
   public function add(Request $request)
   { 
      return view('admin.testimonial.add');
   }
   public function save(Request $request)
   {
       $request->validate([
           'name'=>'required',
           'position'=>'required',
           'description' => 'required',
           'image' => 'required',
       ], [
           'name.required' => trans('messages.name_required'),
           'position.required' => trans('messages.position_required'),
           'description.required' => trans('messages.description_required'),
           'image.required' => trans('messages.image_required'),
       ]);
       
       $testimonial= new Testimonials();
       $testimonial->vendor_id = Auth::user()->id;
       $testimonial->name = $request->name;
       $testimonial->position = $request->position;
       $testimonial->description = $request->description;
       $testimonial->star = $request->rating;
       if ($request->has('image')) {
           $testimonialimage = 'testimonial-' . uniqid() . "." .$request->file('image')->getClientOriginalExtension();
           $request->file('image')->move(storage_path('app/public/admin-assets/images/testimonials/'), $testimonialimage);
           $testimonial->image = $testimonialimage;
       }
       $testimonial->save();
       return redirect('admin/testimonials')->with('success', trans('messages.success'));
   }
   public function edit(Request $request)
   { 
      $edittestimonial = Testimonials::where('id',$request->id)->first();
      return view('admin.testimonial.edit',compact('edittestimonial'));
   }
   public function update(Request $request)
   {
    $request->validate([
        'name'=>'required',
        'position'=>'required',
        'description' => 'required',
       
    ], [
        'name.required' => trans('messages.name_required'),
        'position.required' => trans('messages.position_required'),
        'description.required' => trans('messages.description_required'),
       
    ]);
       $edittestimonial = Testimonials::where('id', $request->id)->first();
       $edittestimonial->vendor_id = Auth::user()->id;
       $edittestimonial->name = $request->name;
       $edittestimonial->position = $request->position;
       $edittestimonial->star = $request->rating;
       $edittestimonial->description = $request->description;
       if ($request->has('image')) {
           if (file_exists(storage_path('app/public/admin-assets/images/testimonials/' . $edittestimonial->image))) {
               unlink(storage_path('app/public/admin-assets/images/testimonials/' . $edittestimonial->image));
           }
           $testimonialimage = 'testimonial-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
           $request->file('image')->move(storage_path('app/public/admin-assets/images/testimonials/'), $testimonialimage);
           $edittestimonial->image = $testimonialimage;
       }
       $edittestimonial->update();
       return redirect('admin/testimonials')->with('success', trans('messages.success'));
   }
   public function delete(Request $request)
    {
        $delete = Testimonials::where('id', $request->id)->first();
        if (file_exists(storage_path('app/public/admin-assets/images/testimonials/' . $delete->image))) {
            unlink(storage_path('app/public/admin-assets/images/testimonials/' . $delete->image));
        }
        $delete->delete();
        return redirect()->back()->with('success', trans('messages.success'));
    }
}
