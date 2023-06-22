<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonNextOfKin extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'person_next_of_kin';
    protected $fillable = [
        'name',
        'relationship',
        'residence',
        'contact_id',
    ];

    public function personContact()
    {
        return $this->belongsTo(PersonContacts::class);
    }

}
