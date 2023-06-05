<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseholdType extends Model
{
    use HasFactory;


  
    protected $fillable = [
        'household_type_id',
        'household_type_name',
    ];

    public function household()
    {
        return $this->hasMany(Household::class, 'household_type_id');
    }
}
