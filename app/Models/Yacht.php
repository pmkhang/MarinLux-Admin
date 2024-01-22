<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yacht extends Model
{
    use HasFactory;
    protected $table = 'yachts';
    public $incrementing = false;
    protected $guarded = [];

    public function yacht_feedbacks()
    {
        return $this->hasMany(YachtFeedback::class, 'yacht_id');
    }

    public function yacht_images()
    {
        return $this->hasMany(YachtImages::class, 'yacht_id');
    }

    public function yacht_specifications()
    {
        return $this->hasOne(YachtSpecifications::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
