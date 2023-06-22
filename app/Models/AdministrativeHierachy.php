<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdministrativeHierachy extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'administrative_hierachy';
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
