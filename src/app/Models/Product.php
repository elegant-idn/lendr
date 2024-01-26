<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    public $appends = ['raw_per_day_price', 'per_day_commission'];
    public $fillable = ['title','slug' ,'category_id', 'description', 'per_day_price', 'contact_name', 'contact_mobile', 'contact_location', 'is_available', 'is_deleted'];

    public function product_image()
    {
        return $this->hasOne('App\Models\ProductImage','product_id','id')->orderBy('id', 'DESC');
    }
    public function multi_image()
    {
        return $this->hasMany('App\Models\ProductImage','product_id','id')->orderBy('id', 'DESC');
    }
    public function category_info()
    {
        return $this->hasOne('App\Models\Category','id','category_id');
    }
    public function fetures_info()
    {
        return $this->hasMany('App\Models\ProductFeatures','product_id','id')->select('*',DB::raw("CONCAT('".url(env('ASSETPATHURL').'admin-assets/images/product/')."/', image) AS feature_image"));
    }

    public function product_image_api(){
        return $this->hasMany('App\Models\ProductImage','product_id','id')->select('product_image.id','product_image.product_id','product_image.image as image_name',DB::raw("CONCAT('".url(env('ASSETPATHURL').'storage/admin-assets/images/product')."/', image) AS image"));
    }

    public function multi_image_api(){
        return $this->hasMany('App\Models\ProductImage','product_id','id')->select('product_image.id','product_image.product_id','product_image.image as image_name',DB::raw("CONCAT('".url(env('ASSETPATHURL').'admin-assets/images/product')."/', image) AS image"));
    }

    public function favored_by_users()
    {
        return $this->belongsToMany(User::class, 'user_favorite_products')->withTimestamps();
    }

    public function viewed_by_users()
    {
        return $this->belongsToMany(User::class, 'user_viewed_products')->withTimestamps();
    }

    public function requested_by_users()
    {
        return $this->belongsToMany(User::class, 'user_lent_products')->withPivot('start_date', 'end_date', 'accepted')->withTimestamps();
    }
    
    public function getRawPerDayPriceAttribute()
    {
        return sprintf("%.2f", $this->attributes['per_day_price']);
    }
    
    public function getPerDayCommissionAttribute()
    {
        $settings = Settings::first();
        $commissionType = $settings->commission_type;
        $commissionValue = $settings->commission_value;
    
        if ($commissionType == 1) {
            $commissionAmount = $this->attributes['per_day_price'] * ($commissionValue / 100);
        } elseif ($commissionType == 2) {
            $commissionAmount = $commissionValue;
        } else {
            return null;
        }
    
        $finalPrice = $commissionAmount;
    
        return sprintf("%.2f", $finalPrice);
    }
    
    public function getPerDayPriceAttribute()
    {
        $settings = Settings::first();
        $commissionType = $settings->commission_type;
        $commissionValue = $settings->commission_value;
    
        if ($commissionType == 1) {
            $commissionAmount = $this->attributes['per_day_price'] * ($commissionValue / 100);
        } elseif ($commissionType == 2) {
            $commissionAmount = $commissionValue;
        } else {
            return null;
        }
    
        $finalPrice = $this->attributes['per_day_price'] + $commissionAmount;
    
        return sprintf("%.2f", $finalPrice);
    }
}
