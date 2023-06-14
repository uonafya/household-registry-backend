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
        'household_registered_by_id'
    ];


    public function householdType()
    {
        return $this->belongsTo(HouseHoldType::class);
    }

    public function householdAddress()
    {
        return $this->belongsTo(HouseHoldAdress::class);
    }

    public function householdPersonDetails()
    {
        return $this->hasMany(HouseHoldPersonDetails::class);
    }

    public function household_persons()
    {
        return $this->hasMany(HouseHoldPersonDetails::class);
    }
}
