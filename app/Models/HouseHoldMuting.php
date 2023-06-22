<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseHoldMuting extends Model
{
    use HasFactory;
    use SoftDeletes;

    // table name
    protected $table = 'house_hold_muting';

    protected $fillable = [
        'house_hold_id',
        'reason_for_muting',
        'date_muted',
        'muted_by_id',
        'is_muted_approval_status',
    ];

    public function household()
    {
        return $this->belongsTo(HouseHold::class);
    }

    public function mutedBy()
    {
        return $this->belongsTo(HouseHoldPersonDetail::class);
    }

    public function mutingApprovedBy()
    {
        return $this->belongsTo(HouseHoldPersonDetail::class);
    }
}
