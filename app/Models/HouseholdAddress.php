<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HouseholdAddress extends Model
{
    protected $table = 'household_addresses';

    protected $fillable = [
        'household_type_name',
        'area_type_id',
        'area_name',
        'area_code',
        'parent_area_id',
    ];

    public function households()
    {
        return $this->hasMany(Household::class, 'household_address_id');
    }
}
