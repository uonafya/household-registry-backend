<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonContacts extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'person_contact';

    protected $fillable = [
        'primary_phone',
        'secondary_phone',
        'email',
    ];
}
