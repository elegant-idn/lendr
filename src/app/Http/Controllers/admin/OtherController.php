<?php

namespace App\Http\Controllers\admin;



use App\helper\helper;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Contact;

use App\Models\Faq;
use App\Models\Subscriber;
use App\Models\Settings;
use App\Models\Country;
use App\Models\City;

use Illuminate\Support\Facades\Auth;

class OtherController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::where('vendor_id',Auth::user()->id)->orderByDesc('id')->get();
        return view('admin.contact.index',compact('contacts'));
    }

    public function delete(Request $request)

    {

        $deletecontact =Contact::where('id',$request->id)->first();

        $deletecontact->delete();

        return redirect()->back()->with('success', trans('messages.success'));

    }

    public function privacypolicy(Request $request)

    {

        $getprivacypolicy = helper::appdata(Auth::user()->id)->privacy_content;

        return view('admin.other.privacypolicy',compact('getprivacypolicy'));

    }

    public function update_privacypolicy(Request $request)

    {

        $request->validate([

            'privacypolicy' => 'required',

        ], [

            'privacypolicy.required' => trans('messages.content_required'),

        ]);

        $checkprivacy = Settings::where('vendor_id',Auth::user()->id)->first();

        if(!empty($checkprivacy))

        {

            $checkprivacy->privacy_content = $request->privacypolicy;

            $checkprivacy->update();

        }

        else

        {

            $privacy = new Settings();

            $privacy->privacy_content = $request->privacypolicy;

            $privacy->save();

        }

        return redirect()->back()->with('success', trans('messages.success'));

    }

    public function termscondition()

    {

        $getterms = helper::appdata(Auth::user()->id)->terms_content;

        return view('admin.other.termscondition',compact('getterms'));

    }

    public function update_terms(Request $request)

    {

        $request->validate([

            'termscondition' => 'required',

        ], [

            'termscondition.required' => trans('messages.content_required'),

        ]);

        $checkterms = Settings::where('vendor_id',Auth::user()->id)->first();

        if(!empty($checkterms))

        {

            $checkterms->terms_content = $request->termscondition;

            $checkterms->update();

        }

        else

        {

            $terms = new Settings();

            $terms->terms_content = $request->termscondition;

            $terms->save();

        }

        return redirect()->back()->with('success', trans('messages.success'));

    }

   

    public function aboutus()

    {

        $getaboutus = helper::appdata(Auth::user()->id)->about_content;

        return view('admin.other.aboutus',compact('getaboutus'));

    }

    public function update_aboutus(Request $request)

    {

        $request->validate([

            'aboutus' => 'required',

        ], [

            'aboutus.required' => trans('messages.content_required'),

        ]);

        $checkaboutus = Settings::where('vendor_id',Auth::user()->id)->first();

        if(!empty($checkaboutus))

        {

            $checkaboutus->about_content = $request->aboutus;

            $checkaboutus->update();

        }

        else

        {

            $about = new Settings();

            $about->about_content = $request->aboutus;

            $about->save();

        }

        return redirect()->back()->with('success', trans('messages.success'));

    }





    public function faq_index(Request $request)

    {
        $content = Settings::where('vendor_id',Auth::user()->id)->first();
        $faqs = Faq::orderByDesc('id')->get();

        return view('admin.faqs.index',compact('faqs','content'));

    }

    public function faq_add(Request $request)

    {

        return view('admin.faqs.add');

    }

    public function faq_save(Request $request)
    {

        $request->validate([

            'question' => 'required',

            'answer' => 'required'

        ], [

            'question.required' => trans('messages.question_required'),

            'answer.required' => trans('messages.answer_required'),



        ]);

        $faqs = new Faq();

        $faqs->question = $request->question;

        $faqs->answer = $request->answer;

        $faqs->save();

        return redirect('/admin/faqs')->with('success', trans('messages.success'));

    }

    public function faq_edit(Request $request)
    {

        $getfaq = Faq::where('id', $request->id)->first();

        return view('admin.faqs.edit', compact('getfaq'));

    }
    public function faq_update(Request $request)
    {

        $request->validate([

            'question' => 'required',

            'answer' => 'required'

        ], [

            'question.required' => trans('messages.question_required'),

            'answer.required' => trans('messages.answer_required'),



        ]);

        $getfaq = Faq::where('id', $request->id)->first();

        $getfaq->question = $request->question;

        $getfaq->answer = $request->answer;

        $getfaq->update();

        return redirect('/admin/faqs')->with('success', trans('messages.success'));

    }
    public function faq_delete(Request $request)
    {

        $deletefaq = Faq::where('id',$request->id)->first();

        $deletefaq->delete();

        return redirect('/admin/faqs')->with('success', trans('messages.success'));

       

    }
    public function savecontent(Request $request)
    {
        $newcontent = Settings::where('vendor_id',Auth::user()->id)->first();
        if ($request->has('image')) {
            $image = 'faq-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(storage_path('app/public/admin-assets/images/index/'), $image);
            $newcontent->faq_image = $image;
        }
        $newcontent->save();
        return redirect('admin/faqs')->with('success', trans('messages.success'));
    }
    public function countries(Request $request)
    {
       
        $allcontries = Country::where('is_deleted',2)->get();
        return view('admin.country.index',compact('allcontries'));
    }
    public function add_country(Request $request)
    {
        return view('admin.country.add');
    }
    public function save_country(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => trans('messages.name_required'),
        ]);

        $country = new Country();
        $country->name = $request->name;
        $country->save();
        return redirect('/admin/countries')->with('success', trans('messages.success'));
    }
    public function edit_country(Request $request)
    {
        $editcountry = Country::where('id',$request->id)->first();
        return view('admin.country.edit',compact('editcountry'));
    }
    public function update_country(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [

            'name.required' => trans('messages.name_required'),
        ]);

        $editcountry = Country::where('id',$request->id)->first();
        $editcountry->name = $request->name;
        $editcountry->update();
        return redirect('/admin/countries')->with('success', trans('messages.success'));
    }
    public function delete_country(Request $request)
    {
        $country = Country::where('id',$request->id)->first();
        $country->is_deleted = 1;
        $country->update();
        return redirect('/admin/countries')->with('success', trans('messages.success'));
    }
    public function statuschange_country(Request $request)
    {
        $country = Country::where('id',$request->id)->first();
        $country->is_available = $request->status;
        $country->update();
        return redirect('/admin/countries')->with('success', trans('messages.success'));
    }
    public function cities(Request $request)
    {
        $allcities = City::with('country_info')->where('is_deleted',2)->get();
        return view('admin.city.index',compact('allcities'));
    }
    public function add_city(Request $request)
    {
        $allcountry = Country::where('is_deleted',2)->get();
        return view('admin.city.add',compact('allcountry'));
    }
    public function save_city(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => trans('messages.name_required'),
        ]);

        $city = new City();
        $city->country_id = $request->country;
        $city->city = $request->name;
        $city->save();
        return redirect('/admin/cities')->with('success', trans('messages.success'));
    }
    public function edit_city(Request $request)
    {
        $allcountry = Country::where('is_deleted',2)->get();
        $editcity = City::where('id',$request->id)->first();
        return view('admin.city.edit',compact('editcity','allcountry'));
    }
    public function update_city(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [

            'name.required' => trans('messages.name_required'),
        ]);

        $editcity = City::where('id',$request->id)->first();
        $editcity->country_id = $request->country;
        $editcity->city = $request->name;
        $editcity->update();
        return redirect('/admin/cities')->with('success', trans('messages.success'));
    }
    public function delete_city(Request $request)
    {
        $city = City::where('id',$request->id)->first();
        $city->is_deleted = 1;
        $city->update();
        return redirect('/admin/cities')->with('success', trans('messages.success'));
    }
    public function statuschange_city(Request $request)
    {
        $city = City::where('id',$request->id)->first();
        $city->is_available = $request->status;
        $city->update();
        return redirect('/admin/cities')->with('success', trans('messages.success'));
    }
    public function subscribers(Request $request)

    {

        $getsubscribers = Subscriber::where('vendor_id', Auth::user()->id)->orderByDesc('id')->get();

        return view('admin.subscriber.index', compact('getsubscribers'));
    }

    public function subscribers_delete(Request $request)

    {

        $subscriber = Subscriber::find($request->id);

        if (!empty($subscriber)) {

            $subscriber->delete();

            return redirect('/admin/subscribers')->with('success', trans('messages.success'));
        }

        return redirect('/admin/subscribers')->with('error', trans('messages.wrong'));
    }
    public function share(){
        return view('admin.other.share');
    }
}

