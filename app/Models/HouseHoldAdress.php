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
        'householdTypeId',
        'areaTypeId',
        'areaName',
        'areaCode',
        'parentAreaId',
    ];

    public function houseHold()
    {
        return $this->hasOne(HouseHold::class, 'household_address_id');
    }
}
