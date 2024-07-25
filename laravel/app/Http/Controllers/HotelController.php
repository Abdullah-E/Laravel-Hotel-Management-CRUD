<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }
    public function index(Request $request)
    {
        $request->validate([
            'sort_by' => 'string|in:Hotel Name,Country,City,Price'
        ]);
        $sortBy = $request->input('sort_by', 'Hotel Name');
        return Hotel::with('facilities')->get()->map(function ($hotel){

            $hotel->facilities = $hotel->facilities->transform(function ($facility) {
                return $facility->{"Facility Name"};
            })->toArray();


            return $hotel;
        })->sortBy($sortBy)->values();


    }

    public function store(Request $request)
    {
        $request->validate([
            'Hotel Name' => 'required|string',
            'Country' => 'required|string',
            'City' => 'required|string',
            'Price' => 'required|numeric',
            'facilities' => 'array'
        ]);
        $hotel = DB::transaction(function () use ($request) {
            $hotel = Hotel::create($request->except('facilities'));
    
            if ($request->has('facilities')) {
                $facilities = $request->input('facilities');
                $facilityIds = [];
    
                foreach ($facilities as $facility) {
                    $facilityIds[] = Facility::firstOrCreate(['Facility Name' => $facility])->id;
                }
    
                $hotel->facilities()->sync($facilityIds);
            }
    
            return $hotel->load('facilities');
        });
    
        return response()->json($hotel, 201);

    }

    public function show($id)
    {

        $hotel = Hotel::with('facilities')->find($id);

        if (!$hotel) {
            return response()->json(['message' => 'Hotel not found'], 404);
        }

        $hotel->facilities = $hotel->facilities->transform(function ($facility) {
            return $facility->{"Facility Name"};
        })->toArray();

        return response()->json($hotel);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Hotel Name' => 'string',
            'Country' => 'string',
            'City' => 'string',
            'Price' => 'numeric',
            'facilities' => 'array'
        ]);
        $updatedHotel = DB::transaction(function () use ($request, $id) {
            $hotel = Hotel::findOrFail($id);
            $hotel->update($request->except('facilities'));

            if ($request->has('facilities')) {
                $facilities = $request->input('facilities');
                $facilityIds = [];

                foreach ($facilities as $facilityName) {
                    $facilityIds[] = Facility::firstOrCreate(['name' => $facilityName])->id;
                }

                $hotel->facilities()->sync($facilityIds);
            }

            return $hotel->load('facilities');
        });
        return response()->json($updatedHotel, 200);
        
    }

    public function destroy($id)
    {

        Hotel::findOrFail($id)->delete();
        return response()->json(['message' => 'Hotel deleted successfully'], 200);
    }
}
