<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationTarget extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

}
