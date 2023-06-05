<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonContacts extends Model
{
    use HasFactory;

    protected $fillable = [
        'primary_phone',
        'secondary_phone',
        'email',
    ];

    public function houseHoldPersonDetails()
    {
        return $this->hasOne(HouseHoldPersonDetails::class, 'contact_id');
    }

    public function personNextOfKin()
    {
        return $this->hasOne(PersonNextOfKin::class, 'contact_id');
    }
}
