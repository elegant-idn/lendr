<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class City extends Model
{
    use HasFactory;
    protected $table = 'city';
    public function country_info()
    {
        return $this->hasOne('App\Models\Country','id','country_id');
    }
}

