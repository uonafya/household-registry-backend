<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseHoldPersonDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender',
        'country',
        'county_of_birth',
        'is_alive',
        'residence_id',
        'contact_id',
        'next_of_kin_id',
        'identification_id',
        'household_id',
    ];

    public function residence()
    {
        return $this->belongsTo(Residence::class);
    }

    public function personContact()
    {
        return $this->belongsTo(PersonContacts::class);
    }

    public function personNextOfKin()
    {
        return $this->belongsTo(PersonNextOfKin::class);
    }

    public function personIdentification()
    {
        return $this->belongsTo(PersonIdentificationType::class);
    }

    public function household()
    {
        return $this->belongsTo(Household::class);
    }
}
