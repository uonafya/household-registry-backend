<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MergedHouseHold extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'merged_household';

    // Schema::create('merged_household', function (Blueprint $table) {
    //     $table->id();
    //     $table->unsignedBigInteger('household_id_1');
    //     $table->unsignedBigInteger('household_id_2');
    //     $table->unsignedBigInteger('merged_household_id')->nullable();
    //     $table->unsignedBigInteger('initiated_by')->nullable();
    //     $table->unsignedBigInteger('approved_by')->nullable();
    //     $table->boolean('is_appoved')->default(false);
    //     $table->unsignedBigInteger('updated_by')->nullable();
    //     $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
    //     $table->timestamp('updated_at')->nullable();
    //     $table->softDeletes();


    //     // Define foreign key constraints
    //     $table->foreign('household_id_1')->references('id')->on('house_hold')->onUpdate('cascade');
    //     $table->foreign('household_id_2')->references('id')->on('house_hold')->onUpdate('cascade');
    //     $table->foreign('merged_household_id')->references('id')->on('house_hold')->onUpdate('cascade');
    //     $table->foreign('initiated_by')->references('id')->on('house_hold_person_detail')->onUpdate('cascade');
    //     $table->foreign('approved_by')->references('id')->on('house_hold_person_detail')->onUpdate('cascade');
    //     $table->foreign('updated_by')->references('id')->on('house_hold_person_detail')->onUpdate('cascade');

    // });


    protected $fillable = [
        'household_id_1',
        'household_id_2',
        'merged_household_id',
        'initiated_by',
        'approved_by',
        'is_appoved',
        'updated_by',
    ];

    public function household1()
    {
        return $this->belongsTo(HouseHold::class, 'household_id_1', 'id');
    }

    public function household2()
    {
        return $this->belongsTo(HouseHold::class, 'household_id_2', 'id');
    }

    public function mergedHousehold()
    {
        return $this->belongsTo(HouseHold::class, 'merged_household_id', 'id');
    }

    public function initiatedBy()
    {
        return $this->belongsTo(HouseHoldPersonDetail::class, 'initiated_by', 'id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(HouseHoldPersonDetail::class, 'approved_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(HouseHoldPersonDetail::class, 'updated_by', 'id');
    }

    public function household1Members()
    {
        return $this->hasMany(HouseHoldPersonDetail::class, 'household_id', 'household_id_1');
    }

    public function household2Members()
    {
        return $this->hasMany(HouseHoldPersonDetail::class, 'household_id', 'household_id_2');
    }

    public function mergedHouseholdMembers()
    {
        return $this->hasMany(HouseHoldPersonDetail::class, 'household_id', 'merged_household_id');
    }

    public function household1MembersCount()
    {
        return $this->household1Members()->count();
    }

    public function household2MembersCount()
    {
        return $this->household2Members()->count();
    }

    public function mergedHouseholdMembersCount()
    {
        return $this->mergedHouseholdMembers()->count();
    }

    

}
