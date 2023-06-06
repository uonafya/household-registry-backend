<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseholdMemberType extends Model
{
    use HasFactory;

    protected $fillable = [
        'household_membership_type_id',
        'household_membership_name',
    ];

    public function householdMembership()
    {
        return $this->hasMany(HouseHoldMembership::class, 'household_member_type_id');
    }

}
