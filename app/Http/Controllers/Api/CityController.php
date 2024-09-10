<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function getCitiesByState($state_id)
    {
        $cities = City::where('stateId', $state_id)->get();
        return response()->json($cities);
    }
}
