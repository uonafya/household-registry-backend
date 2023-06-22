<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Residence extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'residence';

    protected $fillable = [
        'county',
        'sub_county',
        'ward',
        'village',
    ];
}
