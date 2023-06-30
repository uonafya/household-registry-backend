<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseHold extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'house_hold';


    protected $fillable = [
        'household_name',
        'household_identifier',
        'household_type_id',
        'household_address_id',
        'household_registered_by_id',
        'household_approved_by_id',
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

    // $household->household_memberships()->save($householdMembership);
    public function household_memberships()
    {
        return $this->hasMany(HouseHoldMembership::class);
    }

    
}
