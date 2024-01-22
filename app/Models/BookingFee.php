<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingFee extends Model
{
    use HasFactory;
    protected $table = 'booking_fee';
    protected $guarded = [];

    public function bookings()
    {
        return $this->belongsTo(Booking::class);
    }
}
