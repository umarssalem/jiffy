<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /** @use HasFactory<\Database\Factories\RoomFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'property_id',
        'max',
        'price',
    ];
    
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
    
}
