<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YachtFeedback extends Model
{
    use HasFactory;
    protected $table = 'yacht_feedbacks';
    protected $guarded = [];

    public function yacht()
    {
        return $this->belongsTo(Yacht::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
