<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeoLocation;

class GeoLocationController extends Controller
{
    //
    public function getAllGeolocationsWithChildren()
    {
        $geolocations = GeoLocation::all();

        $result = [];

        foreach ($geolocations as $geolocation) {
            $children = $geolocation->getDescendants();

            $result[] = [
                'geolocation' => $geolocation,
                'children' => $children,
            ];
        }

        return $result;
    }
    public function getCounties()
    {
        $counties = GeoLocation::where('area_type_id', 'GPRV')->pluck('area_name');

        return $counties;
    }

    public function getSubCounties($parentAreaId)
    {
        $subCounties = GeoLocation::where('parent_area_id', $parentAreaId)
            ->where('area_type_id', 'GDIS')
            ->pluck('area_name');

        return $subCounties;
    }

    public function getWards($parentAreaId)
    {
        $wards = GeoLocation::where('parent_area_id', $parentAreaId)
            ->where('area_type_id', 'GWRD')
            ->pluck('area_name');

        return $wards;
    }
    function getChildUnits($areaId)
    {
        $childUnits = GeoLocation::where('is_void', false)
            ->where('parent_area_id', $areaId)
            ->orderBy('area_name')
            ->get();

        return $childUnits;
    }
}
