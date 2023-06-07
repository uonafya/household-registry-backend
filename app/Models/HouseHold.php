<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseHold extends Model
{
    use HasFactory;


    protected $fillable = [
        'household_name',
        'household_identifier',
        'household_type_id',
        'household_address_id',
    ];

    public function householdType()
    {
        return $this->belongsTo(HouseHoldType::class, 'household_type_id');
    }

    public function householdAddress()
    {
        return $this->belongsTo(HouseHoldAddress::class, 'household_address_id');
    }

    public function houseHoldPersonDetails()
    {
        return $this->hasMany(HouseHoldPersonDetails::class, 'household_id');
    }

}
