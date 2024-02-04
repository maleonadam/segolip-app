<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'cost', 'price'];

    // relate with orders
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_services');
    }

    // relate with order_services
    public function order_services()
    {
        return $this->hasMany(OrderService::class);
    }
}
