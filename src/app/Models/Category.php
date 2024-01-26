<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;
    
    protected $appends = ['image_url'];
    
    public function total_service()
    {
        return $this->hasMany('App\Models\Service','category_id','id')->count();
    }

    public function getImageUrlAttribute()
    {
        return url('storage/admin-assets/images/categories/' . $this->attributes['image']);
    }
}
