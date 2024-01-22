<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YachtSpecifications extends Model
{
    use HasFactory;
    protected $table = 'yacht_specifications';
    protected $guarded = [];

    public function yacht()
    {
        return $this->belongsTo(Yacht::class);
    }
}
