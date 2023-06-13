<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseHoldPersonDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstName',
        'middleName',
        'lastName',
        'dateOfBirth',
        'gender',
        'country',
        'countyOfBirth',
        'is_alive',
        'residence_id',
        'person_contact_id',
        'person_next_of_kin_id',
        'person_identifications_id',
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
        return $this->belongsTo(Household::class, 'household_id');
    }
}
