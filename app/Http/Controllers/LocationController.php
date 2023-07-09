<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getCities()
    {
        $cities = City::select(['id', 'city'])->get();
        return response()->json($cities);
    }

    public function getDistrictsByCity($cityId)
    {
        $city = City::findOrFail($cityId);
        
        $districts = $city->districts()->select(['id', 'district'])->get();
        return response()->json(['success' => true, 'data' => $districts]);
    }
}
