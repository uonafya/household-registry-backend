<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseholdMemberType extends Model
{
    use HasFactory;

    protected $fillable = [
        'household_membership_name',
    ];

}
