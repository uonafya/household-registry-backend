<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseHoldAdress extends Model
{
    use HasFactory;
    use SoftDeletes;

    //table name
    protected $table = 'house_hold_address';

    protected $fillable = [
        'household_type_id',
        'area_type_id',
        'area_name',
        'area_code',
        'parent_area_id',
    ];
}
