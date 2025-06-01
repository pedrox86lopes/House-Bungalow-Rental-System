<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bungalow_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
        'guest_name',
        'guest_email',
        'check_in',
        'check_out',
    ];

    public function bungalow()
    {
        return $this->belongsTo(Bungalow::class);
    }

    // --- ADD OR CORRECT THIS RELATIONSHIP METHOD ---
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // --- END RELATIONSHIP METHOD ---
}
