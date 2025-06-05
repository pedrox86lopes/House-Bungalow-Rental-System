<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Import Str facade for UUID

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bungalow_id',
        'start_date',
        'end_date',
        'total_amount',
        'status',
        'guest_name',
        'guest_email',
        'check_in',
        'check_out',
        'invoice_number',
        'total_amount_before_taxes',
        'tax_rate',
        'tax_amount',
        'paid_at',
    ];

    // Cast dates to Carbon instances
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'paid_at' => 'datetime',
        'total_amount' => 'decimal:2', // Cast to decimal for precision
        'total_amount_before_taxes' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'tax_rate' => 'decimal:2',
    ];

    public function bungalow()
    {
        return $this->belongsTo(Bungalow::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Mutator to set check_in and check_out based on start_date and end_date if they are null
    public function setCheckInAttribute($value)
    {
        $this->attributes['check_in'] = $value ?? $this->attributes['start_date'];
    }

    public function setCheckOutAttribute($value)
    {
        $this->attributes['check_out'] = $value ?? $this->attributes['end_date'];
    }

    // Accessor for number of nights
    public function getNumberOfNightsAttribute()
    {
        if ($this->start_date && $this->end_date) {
            return $this->start_date->diffInDays($this->end_date);
        }
        return 0;
    }

    // Boot method to set invoice_number and calculate tax amounts before saving
    protected static function booted()
    {
        static::creating(function ($booking) {
            if (empty($booking->invoice_number)) {
                // Generate a simple invoice number (e.g., INV-UUID)
                $booking->invoice_number = 'INV-' . Str::uuid()->toString();
            }
            // Set default tax rate if not provided
            if (empty($booking->tax_rate)) {
                $booking->tax_rate = config('app.default_tax_rate', 23.00); // Default 23% IVA for Portugal
            }
        });

        static::saving(function ($booking) {
            // Calculate total_amount_before_taxes and tax_amount if total_amount is set
            if (!is_null($booking->total_amount) && !is_null($booking->tax_rate)) {
                // Assuming total_amount includes taxes
                $booking->total_amount_before_taxes = $booking->total_amount / (1 + ($booking->tax_rate / 100));
                $booking->tax_amount = $booking->total_amount - $booking->total_amount_before_taxes;
            }

            // Set paid_at timestamp when status becomes 'paid'
            if ($booking->isDirty('status') && $booking->status === 'paid' && is_null($booking->paid_at)) {
                $booking->paid_at = now();
            }
        });
    }
}
