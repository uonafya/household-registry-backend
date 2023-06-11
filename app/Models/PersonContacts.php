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
}
