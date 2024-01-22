<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YachtImages extends Model
{
    use HasFactory;
    protected $table = 'yacht_images';
    protected $guarded = [];
    
    public function yacht()
    {
        return $this->belongsTo(Yacht::class);
    }
}
