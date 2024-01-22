<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrewMember extends Model
{
    use HasFactory;
    protected $table = 'crew_members';
    protected $guarded = [];

    public function bookings()
    {
        return $this->belongsTo(Booking::class);
    }
}
