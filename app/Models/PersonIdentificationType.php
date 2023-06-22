<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonIdentificationType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'person_identification_type';

    protected $fillable = [
        'identification_type',
        'identification_number',
    ];

    public function houseHoldPersonDetails()
    {
        return $this->hasMany(HouseHoldPersonDetails::class, 'identification_id');
    }
}
