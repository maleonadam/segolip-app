<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'order_total',
        'date',
        'researcher',
        'investigator',
        'department',
        'institution',
        'billing',
        'address',
        'city',
        'country',
        'zipcode',
        'phone',
        'fax_number',
        'email',
        'alter_email',
        'form',
        'image',
        'service_speci',
        'signed_service_speci',
        'invoice',
        'payment',
        'receipt',
        'data',
        'status'
    ];

    // relationship with users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relationship with services
    public function services()
    {
        return $this->belongsToMany(Service::class, 'order_services')->withPivot(['quantity']);
    }
}
