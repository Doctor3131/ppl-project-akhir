<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SellerVerification;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Get cities by province ID
     */
    public function getCities($provinceId)
    {
        try {
            $cities = \Indonesia::findProvince($provinceId, ['cities'])->cities;
            return response()->json($cities);
        } catch (\Exception $e) {
            return response()->json([], 404);
        }
    }

    /**
     * Get districts by city ID
     */
    public function getDistricts($cityId)
    {
        try {
            $districts = \Indonesia::findCity($cityId, ['districts'])->districts;
            return response()->json($districts);
        } catch (\Exception $e) {
            return response()->json([], 404);
        }
    }

    /**
     * Get villages by district ID
     */
    public function getVillages($districtId)
    {
        try {
            $villages = \Indonesia::findDistrict($districtId, ['villages'])->villages;
            return response()->json($villages);
        } catch (\Exception $e) {
            return response()->json([], 404);
        }
    }

    /**
     * Get cities by province name from approved sellers
     */
    public function getCitiesByProvinceName(Request $request)
    {
        $provinceName = $request->query('province');
        
        if (!$provinceName) {
            // Return all cities from approved sellers
            $cities = SellerVerification::where("status", "approved")
                ->distinct()
                ->pluck("kota_kabupaten")
                ->sort()
                ->values();
        } else {
            // Return cities from approved sellers in specific province
            $cities = SellerVerification::where("status", "approved")
                ->where("province", $provinceName)
                ->distinct()
                ->pluck("kota_kabupaten")
                ->sort()
                ->values();
        }

        return response()->json($cities);
    }
}
