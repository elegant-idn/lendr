<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Contact;
use App\helper\helper;
use App\Models\Faq;

class OtherPagesController extends Controller
{
    public function cmspages(Request $request)
    {
        if($request->vendor_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.vendor_id_required')],200);
        }
        
        $privecypolicy = Settings::select('privacy_content')->first();
        $termscondition = Settings::select('terms_content')->first();
        $aboutus = Settings::select('about_content')->where('vendor_id',$request->vendor_id)->first();
        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'privecypolicy' => $privecypolicy->privacy_content,'termscondition'=>$termscondition->terms_content,'aboutus'=>$aboutus->about_content], 200);
    }
    
    public function save_contact(Request $request)
    {
        if($request->vendor_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.vendor_id_required')],200);
        }
        if($request->fname == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.first_name_required')],200);
        }
        if($request->lname == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.last_name_required')],200);
        }
        if($request->email == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.email_required')],200);
        }
        if($request->mobile == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.mobile_required')],200);
        }
        if($request->message == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.message_required')],200);
        }
        
        $newcontact = new Contact();
        $newcontact->vendor_id = $request->vendor_id;
        $newcontact->name = $request->fname . $request->lname;
        $newcontact->email = $request->email;
        $newcontact->mobile = $request->mobile;
        $newcontact->message = $request->message;
        $newcontact->save();
        return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
    }
    
    public function contactdata(Request $request)
    {
        if($request->vendor_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.vendor_id_required')],200);
        }
        $vdata = Settings::select('address','contact','email')->where('vendor_id',$request->vendor_id)->first();
        $day = date('l', time());
        
        $vendordata = array(
            'email' => $vdata->email, 
            'mobile' => $vdata->contact, 
            'address' => helper::appdata($request->vendor_id)->address
        );
        
        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'vendordata' => $vendordata], 200);
    }

    public function faq(Request $request)
    {
        if($request->vendor_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.vendor_id_required')],200);
        }
        
        $faqs = Faq::select('question','answer')->where('vendor_id', $request->vendor_id)->get();
        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'faqs' => $faqs], 200);
    }
  
}
