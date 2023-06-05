<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonIdentificationType extends Model
{

    protected $fillable = [
        'identification_type',
        'identification_number',
    ];

    public function houseHoldPersonDetails()
    {
        return $this->hasMany(HouseHoldPersonDetails::class);
    }
}
