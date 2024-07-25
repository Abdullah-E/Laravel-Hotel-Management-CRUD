<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'Hotel Name',
        'Country',
        'City',
        'Price'
    ];

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'facility_hotel');
    }
}
