<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model

{

    use HasFactory;

    protected $table = 'booking';

    public function product_info()

    {

        return $this->hasOne('App\Models\Product','id','product_id');

    }
    public function vendorinfo()
    {
        return $this->hasOne('App\Models\User', 'id', 'vendor_id')->select('id', 'name');
    }

}



