<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseHoldMigration extends Model
{
    use HasFactory;

    //table name
    protected $table = 'household_migrations';

    protected $fillable = [
        'house_hold_id',
        'from_location_id',
        'to_location_id',
        'reason_for_migration',
        'initiated_by_chv_id',
        'approved_by_cha_id',
        'date_of_migration',
        'is_approved',
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
