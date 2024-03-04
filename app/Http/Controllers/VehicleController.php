<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Vehicle;

class VehicleController extends Controller

{
    //add category
    public function addCategory(Request $request){
        //validate
        $request->validate([
            'name' => 'required|unique:categories',
            'description' => 'required',
            'price' => 'required|numeric'
        ]);
        //create
        return Category::create($request->all());
    }
    //get all categories
    public function getCategories(){
        return Category::all();
    }
    //add vehicle
    public function addVehicle(Request $request){
        //validate
        try{


            $request->validate([
                'reg_no' => 'required|unique:vehicles',
                'category' => 'required',
                'milage' => 'required|numeric',
                'description' => 'required',
                'make' => 'required',
                'model' => 'required',
                'yom' => 'required|numeric',
                'yor' => 'required|numeric',
                'image' => 'required',
                'type' => 'required'
            ]);
            //create
            return Vehicle::create($request->all());
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }

    }
    //get all vehicles
    public function getVehicles(){
        return Vehicle::all();
    }
    //delete vehicles
    public function deleteVehicle(Request $request){
        $reg_no = $request->reg_no;
        $vehicle = Vehicle::findOrFail($reg_no);
        $vehicle->delete();
        return 204;
    }
    //update vehicles
    public function updateVehicle(Request $request){
        $reg_no = $request->reg_no;
        $vehicle = Vehicle::findOrFail($reg_no);
        $vehicle->update($request->all());
        return $vehicle;
    }


}
