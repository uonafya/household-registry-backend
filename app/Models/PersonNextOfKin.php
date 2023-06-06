<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonNextOfKin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'relationship',
        'residence',
        'contact_id',
    ];

    public function houseHoldPersonDetails()
    {
        return $this->hasOne(HouseHoldPersonDetails::class, 'next_of_kin_id');
    }

    public function residence()
    {
        return $this->belongsTo(Residence::class, 'residence_id');
    }

    public function personContacts()
    {
        return $this->belongsTo(PersonContacts::class, 'contact_id');
    }


}
