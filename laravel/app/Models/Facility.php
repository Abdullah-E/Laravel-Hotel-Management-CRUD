<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'Facility Name',
        'hotel_id'
    ];

    public function hotel()
    {
        return $this->belongsToMany(Hotel::class, 'facility_hotel');
    }
}
