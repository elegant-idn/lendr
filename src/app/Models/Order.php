<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    public $fillable = ['product_id','user_id' ,'start_date', 'end_date', 'status', 'delivery_preference', 'state', 'city', 'address', 'zip', 'contact_name', 'contact_mobile', 'contact_email', 'accepted_at', 'total_amount', 'total_product_amount', 'total_commission_amount'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
