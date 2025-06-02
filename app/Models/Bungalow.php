<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bungalow extends Model
{
    use HasFactory; // Make sure this trait is used if you're using model factories

    protected $fillable = [
        'name',
        'description',
        'price_per_night',
        'image_url',
        'bedrooms',
        'beds',
        'bathrooms',
        'accommodates',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
