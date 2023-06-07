<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseHoldAdress extends Model
{
    use HasFactory;

    // $table->id();
    // $table->unsignedBigInteger('householdTypeId');
    // $table->unsignedBigInteger('areaTypeId');
    // $table->string('areaName');
    // $table->string('areaCode');
    // $table->unsignedBigInteger('parentAreaId')->nullable();
    // $table->timestamps();


    protected $fillable = [
        'household_type_id',
        'area_type_id',
        'area_name',
        'area_code',
        'parent_area_id',
    ];

    public function houseHold()
    {
        return $this->hasOne(HouseHold::class, 'household_address_id');
    }
}
