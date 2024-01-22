<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'bookings';
    public $incrementing = false;
    protected $guarded = [];

    public function yacht()
    {
        return $this->belongsTo(Yacht::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking_fee()
    {
        return $this->hasOne(BookingFee::class);
    }

    public function skipper()
    {
        return $this->belongsTo(Skipper::class);
    }

    public function crew_members()
    {
        return $this->hasMany(CrewMember::class);
    }
}
