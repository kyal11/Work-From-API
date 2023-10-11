<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FasilityController extends Controller
{
    public function list(Request $request, $idProperty){
        try{
            $user = $request->user();
            $property = Property::where('id', $idProperty)->where('user_id', $user->id)->first();
        
            if ($property->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                    'data' => []
                ], 404); 
            }

            $facility = Facility::where('property_id', $property->id)->get();

            if ($facility->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data facility tidak ditemukan',
                    'data' => []
                ], 404); 
            }
            return response()->json([
                'status' => true,
                'message' => 'Data facility ditemukan',
                'data' => $facility
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 400);
        }
    }   
    public function store(Request $request, $idProperty){
        try {
            $user = $request->user();
            $property = Property::where('id', $idProperty)->where('user_id', $user->id)->first();
    
            if ($property->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                    'data' => []
                ], 404); 
            }
    
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'qty' => 'required'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal memasukkan data',
                    'data' => $validator->errors()
                ], 400);
            }
    
            $facility = new Facility();
            $facility->property_id = $idProperty;
            $facility->name = $request->name;
            $facility->qty = $request->qty;
            $facility->description = $request->description;
    
            $facility->save();
    
            return response()->json([
                'status' => true,
                'message' => 'Data facility berhasil disimpan',
                'data' => $facility
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 400);
        }
    }
    public function show(Request $request, $idProperty,$idFacility){
        try{
            $user = $request->user();
            $property = Property::where('id', $idProperty)->where('user_id', $user->id)->first();

            if ($property->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Property tidak ditemukan',
                    'data' => []
                ], 404); 
            }

            $facility = Facility::where('property_id', $property->id)->where('id',$idFacility)->first();

            if ($facility->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data facility tidak ditemukan',
                    'data' => []
                ], 404); 
            }

            return response()->json([
                'status' => true,
                'message' => 'Data facility ditemukan',
                'data' => $facility
            ], 200);

        }catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 400);
        }
     }
     public function update(Request $request,$idProperty,$idFacility){
        try {
            $user = $request->user();
            $property = Property::where('id', $idProperty)->where('user_id', $user->id)->first();
    
            if ($property->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                    'data' => []
                ], 404); 
            }
    
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'qty' => 'required'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal mengupdate data',
                    'data' => $validator->errors()
                ], 400);
            }
    
            $facility = Facility::where('property_id', $property->id)->where('id',$idFacility)->first();
            
            if ($facility->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data facility tidak ditemukan',
                    'data' => []
                ], 404); 
            }
            $facility->property_id = $idProperty;
            $facility->name = $request->name;
            $facility->qty = $request->qty;
            $facility->description = $request->description;
    
            $facility->save();
    
            return response()->json([
                'status' => true,
                'message' => 'Data facility berhasil diupdate',
                'data' => $facility
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 400);
        }
     }
     public function delete(Request $request,$idProperty,$idFacility){
        try {
            $user = $request->user();
            $property = Property::where('id', $idProperty)->where('user_id', $user->id)->first();
    
            if ($property->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                    'data' => []
                ], 404); 
            }
    
            $facility = Facility::where('property_id', $property->id)->where('id',$idFacility)->first();
            
            if ($facility->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data facility tidak ditemukan',
                    'data' => []
                ], 404); 
            }
            $facility->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data facility berhasil dihapus',
                'data' => $facility
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 400);
        }
     }
}
