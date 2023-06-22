<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseHoldVoiding extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'household_voiding';

    protected $fillable = [
        'house_hold_id',
        'reason_for_voiding',
        'date_voided',
        'voided_by_id',
        'is_voided_approval_status',
    ];

    public function household()
    {
        return $this->belongsTo(HouseHold::class);
    }

    public function voidedBy()
    {
        return $this->belongsTo(HouseHoldPersonDetail::class);
    }

    public function voidingApprovedBy()
    {
        return $this->belongsTo(HouseHoldPersonDetail::class);
    }
}
