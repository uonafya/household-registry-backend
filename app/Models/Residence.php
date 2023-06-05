<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Residence extends Model
{
    use HasFactory;

    protected $fillable = [
        'county',
        'subCounty',
        'ward',
        'village',
    ];

    public function houseHoldPersonDetails()
    {
        return $this->hasMany(HouseHoldPersonDetails::class, 'residence_id');
    }
}
