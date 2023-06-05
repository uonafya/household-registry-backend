<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdministrativeHierachy extends Model
{
    use HasFactory;
    protected $fillable = [
        'hierarchy_name',
        'code',
        'facility',
        'status',
        'house_holds',
        'date_established',
        'location',
        'isClosed',
        'isRejected',
        'number_of_chvs',
    ];

}
