<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyFactory> */
    use HasFactory;

    protected $fillable = [
        'id',           // allow manually setting the ID
        'name'
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
