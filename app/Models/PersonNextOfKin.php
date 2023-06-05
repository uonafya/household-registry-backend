<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonNextOfKin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'relationship',
        'residence',
        'primary_phone',
        'secondary_phone',
        'email_address',
    ];

    public function houseHoldPersonDetails()
    {
        return $this->hasMany(HouseHoldPersonDetails::class);
    }

}
