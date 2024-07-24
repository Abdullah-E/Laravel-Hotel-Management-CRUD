<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $query = Hotel::query();

        if ($request->has('sort')) {
            $sort = $request->get('sort');
            $query->orderBy($sort);
        }

        return $query->get();
    }

    public function store(Request $request)
    {
        $hotel = Hotel::create($request->all());

        return response()->json($hotel, 201);
    }

    public function show($id)
    {
        $hotel = Hotel::find($id);

        if (!$hotel) {
            return response()->json(['message' => 'Hotel not found'], 404);
        }

        return $hotel;
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->update($request->all());
        return response()->json($hotel, 200);
    }

    public function destroy($id)
    {
        Hotel::findOrFail($id)->delete();
        return response()->json(['message' => 'Hotel deleted successfully'], 204);
    }
}
