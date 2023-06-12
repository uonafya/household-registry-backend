<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseHoldAdress extends Model
{
    use HasFactory;

    //table name
    protected $table = 'house_hold_addresses';

    protected $fillable = [
        'household_type_id',
        'area_type_id',
        'area_name',
        'area_code',
        'parent_area_id',
    ];
}
