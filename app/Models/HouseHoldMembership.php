<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseHoldMembership extends Model
{
    use HasFactory;
    protected $fillable = [
        'household_person_details_id',
        'household_member_type_id',
        'household_id',
    ];


    public function householdPersonDetails()
    {
        return $this->belongsTo(HouseHoldPersonDetails::class);
    }


    public function householdMemberType()
    {
        return $this->belongsTo(HouseholdMemberType::class);
    }

    public function household()
    {
        return $this->belongsTo(HouseHold::class);
    }

}
