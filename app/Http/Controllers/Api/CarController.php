<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::where('available', true)->get();
        
        return response()->json([
            'success' => true,
            'data' => $cars->map(function ($car) {
                return [
                    'id' => $car->id,
                    'name' => $car->name,
                    'type' => $car->type,
                    'description' => $car->description,
                    'price_per_day' => $car->price_per_day,
                    'seats' => $car->seats,
                    'transmission' => $car->transmission,
                    'fuel_type' => $car->fuel_type,
                    'image_url' => $car->image_url,
                    'available' => $car->available
                ];
            })
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:Brio,Jazz,Civic,HR-V,CR-V',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'seats' => 'required|integer|min:1',
            'transmission' => 'required|string',
            'fuel_type' => 'required|string'
        ]);

        $car = Car::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Car created successfully!',
            'data' => $car
        ], 201);
    }

    public function show(Car $car)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $car->id,
                'name' => $car->name,
                'type' => $car->type,
                'description' => $car->description,
                'price_per_day' => $car->price_per_day,
                'seats' => $car->seats,
                'transmission' => $car->transmission,
                'fuel_type' => $car->fuel_type,
                'image_url' => $car->image_url,
                'available' => $car->available
            ]
        ]);
    }

    public function update(Request $request, Car $car)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|in:Brio,Jazz,Civic,HR-V,CR-V',
            'description' => 'sometimes|required|string',
            'price_per_day' => 'sometimes|required|numeric|min:0',
            'seats' => 'sometimes|required|integer|min:1',
            'transmission' => 'sometimes|required|string',
            'fuel_type' => 'sometimes|required|string',
            'available' => 'sometimes|required|boolean'
        ]);

        $car->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Car updated successfully!',
            'data' => $car
        ]);
    }

    public function destroy(Car $car)
    {
        $car->delete();

        return response()->json([
            'success' => true,
            'message' => 'Car deleted successfully!'
        ]);
    }
}