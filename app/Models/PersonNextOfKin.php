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
        'residence_id',
        'contact_id',
    ];

    public function personContact()
    {
        return $this->belongsTo(PersonContacts::class);
    }


}
