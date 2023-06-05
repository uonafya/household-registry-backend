<?php

namespace App;

use App\Models\HouseHoldPersonDetails;
use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    protected $table = 'households';

    protected $fillable = [
        'household_id',
        'household_name',
        'household_identifier',
        'household_address',
        'household_type_id',
    ];

    public function houseHoldPersonDetails()
    {
        return $this->hasMany(HouseHoldPersonDetails::class);
    }

    public function householdType()
    {
        return $this->belongsTo(HouseholdType::class, 'household_type_id');
    }
}
