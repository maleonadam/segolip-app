<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderService extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'service_id', 'quantity', 'price'];

    // relate to services
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // public function getCreatedAtDateAttribute($value) {
    //     return $value->format('Y-m-d');
    // }
}
