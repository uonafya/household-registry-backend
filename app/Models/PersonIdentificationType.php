<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonIdentificationType extends Model
{
    use HasFactory;


    protected $fillable = [
        'identification_type',
        'identification_number',
    ];

    public function houseHoldPersonDetails()
    {
        return $this->hasMany(HouseHoldPersonDetails::class, 'identification_id');
    }
}
