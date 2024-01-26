<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Footerfeatures;

class SettingsController extends Controller
{
    public function index()
    {
        $settingdata = Settings::first();
        $commissionTypes = ['percentage' => 1, 'fixed' => 2];
        $getfooterfeatures = Footerfeatures::where('vendor_id', Auth::user()->id)->get();
        $theme = Transaction::select('themes_id')->where('vendor_id', Auth::user()->id)->orderByDesc('id')->first();
        $countries = Country::where('Is_deleted',2)->where('is_available',1)->get();
        return view('admin.settings.settings', compact('settingdata', 'getfooterfeatures', 'theme','countries', 'commissionTypes'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'currency' => 'required',
            'timezone' => 'required',
            'web_title' => 'required_if:Auth::user()->type(),2',
            'copyright' => 'required',
            'footer_description' => 'required_if:Auth::user()->type(),2',
            'address' => 'required_if:Auth::user()->type(),2',
            'slug' => 'required_if:Auth::user()->type(),2|unique:users,slug,' . Auth::user()->id,
            
        ], [
            "currency.required" => trans('messages.currency_required'),
            "timezone.required" => trans('messages.timezone_required'),
            "web_title.required_if" => trans('messages.web_title_required'),
            "copyright.required" => trans('messages.copyright_required'),
            "footer_description.required_if" => trans('messages.footer_description_required'),
            "address.required_if" => trans('messages.address_required'),
            'slug.required_if' => trans('messages.slug_required'),
            'slug.unique' => trans('messages.unique_slug'),
            
        ]);
        $settingsdata = Settings::where('vendor_id', Auth::user()->id)->first();
        $userslug = User::where('id', Auth::user()->id)->first();
        if ($request->hasfile('logo')) {
            $request->validate([
                'logo' => 'image',
            ], [
                'logo.image' => trans('messages.enter_image_file'),
            ]);
            if ($settingsdata->logo != "defaultlogo.png" && file_exists(storage_path('app/public/admin-assets/images/about/logo/' . $settingsdata->logo))) {
                @unlink(storage_path('app/public/admin-assets/images/about/logo/' . $settingsdata->logo));
            }
            $logo_name = 'logo-' . uniqid() . '.' . $request->logo->getClientOriginalExtension();
            $request->file('logo')->move(storage_path('app/public/admin-assets/images/about/logo/'), $logo_name);
            $settingsdata->logo = $logo_name;
        }
        if ($request->hasfile('favicon')) {
            $request->validate([
                'favicon' => 'image',
            ], [
                'favicon.image' => trans('messages.enter_image_file'),
            ]);
            if ($settingsdata->favicon != "defaultfavicon.png" && file_exists(storage_path('app/public/admin-assets/images/about/favicon/' . $settingsdata->favicon))) {
                @unlink(storage_path('app/public/admin-assets/images/about/favicon/' . $settingsdata->favicon));
            }
            $favicon_name = 'favicon-' . uniqid() . '.' . $request->favicon->getClientOriginalExtension();
            $request->favicon->move(storage_path('app/public/admin-assets/images/about/favicon/'), $favicon_name);
            $settingsdata->favicon = $favicon_name;
        }
       
        if ($request->hasfile('notification_sound')) {
            $request->validate([
                'notification_sound' => 'mimes:mp3',
                
            ]);
            if (file_exists(storage_path('app/public/admin-assets/notification/' . $settingsdata->notification_sound))) {
                @unlink(storage_path('app/public/admin-assets/notification/' . $settingsdata->notification_sound));
            }
            $sound = 'audio-' . uniqid() . '.' . $request->notification_sound->getClientOriginalExtension();
            $request->notification_sound->move(storage_path('app/public/admin-assets/notification/'), $sound);
            $settingsdata->notification_sound = $sound;
        }
        if ($request->hasfile('landin_page_cover_image')) {
            $request->validate([
                'landin_page_cover_image' => 'image',
            ], [
                "landin_page_cover_image.image" => trans('messages.enter_image_file'),
            ]);
            if ($settingsdata->cover_image != "cover.png" && file_exists(storage_path('app/public/admin-assets/images/coverimage/' . $settingsdata->cover_image))) {
                @unlink(storage_path('app/public/admin-assets/images/coverimage/' . $settingsdata->cover_image));
            }
            $coverimage = 'cover-' . uniqid() . '.' . $request->landin_page_cover_image->getClientOriginalExtension();
            $request->landin_page_cover_image->move(storage_path('app/public/admin-assets/images/coverimage/'), $coverimage);
            $settingsdata->cover_image = $coverimage;
        }
        if ($request->hasfile('auth_page_image')) {
            $request->validate([
                'auth_page_image' => 'image',
            ], [
                "auth_page_image.image" => trans('messages.enter_image_file'),
            ]);
            if ($settingsdata->auth_image != "auth_image.png" && file_exists(storage_path('app/public/admin-assets/images/authimage/' . $settingsdata->auth_image))) {
                @unlink(storage_path('app/public/admin-assets/images/authimage/' . $settingsdata->auth_image));
            }
            $authimage = 'auth-' . uniqid() . '.' . $request->auth_page_image->getClientOriginalExtension();
            $request->auth_page_image->move(storage_path('app/public/admin-assets/images/authimage/'), $authimage);
            $settingsdata->auth_image = $authimage;
        }
        if ($request->hasfile('listing_page_image')) {
            $request->validate([
                'listing_page_image' => 'image',
            ]);
            if (file_exists(storage_path('app/public/admin-assets/images/banner/' . $settingsdata->listing_page_image))) {
                @unlink(storage_path('app/public/admin-assets/images/banner/' . $settingsdata->auth_image));
            }
            $listingimage = 'listing-' . uniqid() . '.' . $request->listing_page_image->getClientOriginalExtension();
            $request->listing_page_image->move(storage_path('app/public/admin-assets/images/banner/'), $listingimage);
            $settingsdata->listing_page_image = $listingimage;
        }
        $settingsdata->currency = $request->currency;
        $settingsdata->currency_position = $request->currency_position;
        if(Auth::user()->type == 2)
        {
           
            $settingsdata->footer_description = $request->footer_description;
            $settingsdata->email = $request->contact_email;
            $settingsdata->mobile = $request->contact_mobile;
            $settingsdata->address = $request->address;
            $settingsdata->facebook_link = $request->facebook_link;
            $settingsdata->twitter_link = $request->twitter_link;
            $settingsdata->instagram_link = $request->instagram_link;
            $settingsdata->linkedin_link = $request->linkedin_link;
           
        }
        $settingsdata->timezone = $request->timezone;
        $settingsdata->web_title = $request->web_title;
        $settingsdata->copyright = $request->copyright;
        $settingsdata->maintenance_mode = isset($request->maintenance_mode) ? 1 : 2;
        $settingsdata->checkout_login_required = isset($request->checkout_login_required) ? 1 : 2;
        $settingsdata->firebase = $request->firebase_server_key;
        $settingsdata->time_format = $request->time_format;
        $settingsdata->save();
        if(!empty($request->slug))
        {
            $userslug->slug = $request->slug;
            $userslug->save();
        }
     
        if (!empty($request->feature_icon)) {

            foreach ($request->feature_icon as $key => $icon) {

                if (!empty($icon) && !empty($request->feature_title[$key]) && !empty($request->feature_description[$key])) {

                    $feature = new Footerfeatures;

                    $feature->vendor_id = Auth::user()->id;

                    $feature->icon = $icon;

                    $feature->title = $request->feature_title[$key];

                    $feature->description = $request->feature_description[$key];

                    $feature->save();
                }
            }
        }

        if (!empty($request->edit_icon_key)) {

            foreach ($request->edit_icon_key as $key => $id) {

                $feature = Footerfeatures::find($id);

                $feature->icon = $request->edi_feature_icon[$id];

                $feature->title = $request->edi_feature_title[$id];

                $feature->description = $request->edi_feature_description[$id];

                $feature->save();
            }
        }
       
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function save_seo(Request $request)
    {
        $request->validate([
            'meta_title' => 'required',
            'meta_description' => 'required',
        ], [
            "meta_title.required" => trans('messages.meta_title_required'),
            "meta_description.required" => trans('messages.meta_description_required'),
        ]);
        $settingsdata = Settings::where('vendor_id', Auth::user()->id)->first();
        $settingsdata->meta_title = $request->meta_title;
        $settingsdata->meta_description = $request->meta_description;
        if ($request->hasfile('og_image')) {
            $image = 'og_image-' . uniqid() . '.' . $request->og_image->getClientOriginalExtension();
            $request->og_image->move(storage_path('app/public/admin-assets/images/about/og_image/'), $image);
            $settingsdata->og_image = $image;
        }
        $settingsdata->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
 
    public function themeupdate(Request $request)
    {
       
        $settingsdata = Settings::where('vendor_id', Auth::user()->id)->first();
        $settingsdata->primary_color = $request->primary_color;
        $settingsdata->secondary_color = $request->secondary_color;
        $settingsdata->theme = !empty($request->template) ? $request->template : 1;
        $settingsdata->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function delete_feature(Request $request)

    {

        Footerfeatures::where('id', $request->id)->delete();

        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function landingsettings(Request $request)
    {
        $settingsdata = Settings::where('vendor_id', Auth::user()->id)->first();
        $settingsdata->primary_color = $request->landing_primary_color;
        $settingsdata->secondary_color = $request->landing_secondary_color;
        $settingsdata->email = $request->landing_email;
        $settingsdata->address = $request->landing_address;
        $settingsdata->contact = $request->landing_mobile;
        $settingsdata->facebook_link = $request->landing_facebook_link;
        $settingsdata->twitter_link = $request->landing_twitter_link;
        $settingsdata->instagram_link = $request->landing_instagram_link;
        $settingsdata->linkedin_link = $request->landing_linkedin_link;
        $settingsdata->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function save_product(Request $request)
    {
        $request->validate([
            'commission_type' => 'required|numeric|in:1,2',
            'commission_value' => 'required|numeric|min:0',
        ]);
        $settingsData = Settings::first()->update([
            'commission_type' => $request->commission_type,
            'commission_value' => $request->commission_value
        ]);
        return redirect()->back()->with('success', trans('messages.success'));
    }

}
