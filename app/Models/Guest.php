<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $table = 'guests';

    protected $fillable = [
        'name',
        'phone',
        'destination',
        'purpose',
        'checkin',
        'checkout',
        'image',
        'status',
    ];


    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
