<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseHoldMembership extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'house_hold_membership';

    protected $fillable = [
        'household_person_details_id',
        'household_member_type_id',
        'house_hold_id',
    ];


    public function householdPersonDetails()
    {
        return $this->belongsTo(HouseHoldPersonDetails::class, 'household_person_details_id');
    }


    public function householdMemberType()
    {
        return $this->belongsTo(HouseholdMemberType::class, 'household_member_type_id');
    }

    public function household()
    {
        return $this->belongsTo(HouseHold::class, 'house_hold_id');
    }

    public function household_persons()
    {
        return $this->hasMany(HouseHoldPersonDetails::class);
    }

}
