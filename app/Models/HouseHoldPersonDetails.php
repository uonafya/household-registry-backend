<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseHoldPersonDetails extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'house_hold_person_detail';

    protected $fillable = [
        'firstName',
        'middleName',
        'lastName',
        'nupi_no',
        'dateOfBirth',
        'gender',
        'country',
        'countyOfBirth',
        'is_alive',
        'residence_id',
        'person_contact_id',
        'person_next_of_kin_id',
        'person_identifications_id',
        'household_member_type_id',
    ];

    public function residence()
    {
        return $this->belongsTo(Residence::class, 'residence_id');
    }

    public function personContact()
    {
        return $this->belongsTo(PersonContacts::class, 'person_contact_id');
    }

    public function personNextOfKin()
    {
        return $this->belongsTo(PersonNextOfKin::class, 'person_next_of_kin_id');
    }

    public function personIdentification()
    {
        return $this->belongsTo(PersonIdentificationType::class, 'person_identifications_id');
    }

    public function householdMemberType()
    {
        return $this->belongsTo(HouseholdMemberType::class, 'household_member_type_id');
    }
}
