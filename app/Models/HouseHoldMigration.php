<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseHoldMigration extends Model
{
    use HasFactory;
    use SoftDeletes;

    //table name
    protected $table = 'household_migration';

    protected $fillable = [
        'house_hold_id',
        'old_residence_id',
        'new_residence_id',
        'reason_for_migration',
        'initiated_by_chv_id',
        'date_of_migration',
    ];

    public function fromLocation()
    {
        return $this->belongsTo(HouseHoldAdress::class);
    }

    public function toLocation()
    {
        return $this->belongsTo(HouseHoldAdress::class);
    }


    public function household()
    {
        return $this->belongsTo(HouseHold::class);
    }

    public function initiatedByChv()
    {
        return $this->belongsTo(HouseHoldPersonDetails::class);
    }

    public function approvedByChv()
    {
        return $this->belongsTo(HouseHoldPersonDetails::class);
    }

    public function household_persons()
    {
        return $this->hasMany(HouseHoldPersonDetails::class);
    }
}
