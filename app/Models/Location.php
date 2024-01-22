<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $table = 'locations';
    public $incrementing = false;
    protected $guarded = [];

    public function yachts()
    {
        return $this->hasMany(Yacht::class);
    }

}
