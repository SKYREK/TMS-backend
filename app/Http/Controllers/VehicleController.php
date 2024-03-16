<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Vehicle;
use App\Models\VehicleRepair;

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
    //delete category
    public function deleteCategory(Request $request){
        $name = $request->name;
        $category = Category::findOrFail($name);
        $category->delete();
        return 204;
    }
    //update category
    public function updateCategory(Request $request){
        $name = $request->name;
        $category = Category::findOrFail($name);
        $category->update($request->all());
        return $category;
    }
    //add a vehicle repair
    public function addVehicleRepair(Request $request){
        //validate
        try{
            $request->validate([
                'vehicle_reg_no' => 'required',
                'monitored_by' => 'required',
                'title' => 'required',
                'description' => 'required',
                'cost' => 'required|numeric',
                'date' => 'required',
                'bill_image' => 'required'
            ]);
            //create
            return VehicleRepair::create($request->all());
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    //get vehicle reapairs by vehicle reg no
    public function getVehicleRepairs(Request $request){
        //validate
        try{
            $request->validate([
                'vehicle_reg_no' => 'required'
            ]);
            $vehicle_reg_no = $request->vehicle_reg_no;
            return VehicleRepair::where('vehicle_reg_no', $vehicle_reg_no)->get();
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }

    }
    //update vehicle repair
    public function updateVehicleRepair(Request $request){
        //validate
        try{
            $request->validate([
                'id' => 'required',
                'vehicle_reg_no' => 'required',
                'monitored_by' => 'required',
                'title' => 'required',
                'description' => 'required',
                'cost' => 'required|numeric',
                'date' => 'required',
                'bill_image' => 'required'
            ]);
            $id = $request->id;
            $vehicleRepair = VehicleRepair::findOrFail($id);
            $vehicleRepair->update($request->all());
            return $vehicleRepair;
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }



}
