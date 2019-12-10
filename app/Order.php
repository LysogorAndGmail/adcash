<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    public function orderUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderProduct()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
