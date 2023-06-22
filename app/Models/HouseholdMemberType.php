<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseholdMemberType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'household_member_type';
    protected $fillable = [
        'household_membership_name',
    ];

}
