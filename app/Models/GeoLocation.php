<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeoLocation extends Model
{
    protected $table = 'geo_location';
    protected $primaryKey = 'area_id';
    public $timestamps = false;

    protected $fillable = [
        'area_type_id',
        'area_name',
        'area_code',
        'parent_area_id',
        'area_name_abbr',
        'timestamp_created',
        'timestamp_updated',
        'is_void',
    ];

    protected $casts = [
        'is_void' => 'boolean',
    ];

    public function children()
    {
        return $this->hasMany(Geolocation::class, 'parent_area_id', 'area_id');
    }

    public function getDescendants()
    {
        $descendants = [];

        if ($this->children->isNotEmpty()) {
            foreach ($this->children as $child) {
                $descendants[] = [
                    'geolocation' => $child,
                    'children' => $child->getDescendants(),
                ];
            }
        }

        return $descendants;
    }

}
