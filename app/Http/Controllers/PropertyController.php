<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    public function index(Request $request){
        try {
            $query = Property::query();
            // Check Parameter
            $name = $request->input('name');
            if ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            }
            $capacity = $request->input('capacity');
            if ($capacity) {
                $query->where('capacity','=', $capacity );
            }
            $price = $request->input('price');
            if ($price) {
                $query->where('price', '<=',$price);
            }
            $data = $query->orderBy('name', 'asc')->get();
    
            if ($data->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data property tidak ditemukan',
                    'data' => []
                ], 404); 
            }
    
            return response()->json([
                'status' => true,
                'message' => 'Data property ditemukan',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 400); 
        }
    }
    

    public function show($id,Request $request)
    {
        $user = $request->user();
        try {
            $property = Property::where('id',$id)->where('user_id',$user->id)->first();
            if ($property->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data property tidak ditemukan',
                    'data' => []
                ], 404); 
            }
            
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => $property
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 400); 
        }
    }
    public function store(Request $request)
    {
        $user = $request->user();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'building_name' => 'required',
                'domicile' => 'required',
                'address' => 'required',
                'price' => 'required',
                'capacity' => 'required',
                'description' => 'required',
                'status' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Semua input harus diisi',
                    'data' => $validator->errors()
                ]);
            }

            $property = new Property;
            $property->user_id = $user->id;
            $property->name = $request->name;
            $property->building_name = $request->building_name;
            $property->domicile = $request->domicile;
            $property->address = $request->address;
            $property->price = $request->price;
            $property->capacity = $request->capacity;
            $property->description = $request->description;
            $property->status = $request->status;

            $property->save();

            return response()->json([
                'status' => true,
                'message' => 'Data property berhasil disimpan',
                'data' => $property
            ], 201); 
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 400); 
        }
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        try {
            $property = Property::where('id',$id)->where('user_id',$user->id)->first();

            if (empty($property)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'address' => 'required',
                'price' => 'required',
                'capacity' => 'required',
                'description' => 'required',
                'status' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal Memasukkan data',
                    'data' => $validator->errors()
                ], 400);
            }

            $property->user_id = $user->id;
            $property->name = $request->name;
            $property->address = $request->address;
            $property->price = $request->price;
            $property->capacity = $request->capacity;
            $property->description = $request->description;
            $property->status = $request->status;

            $property->save();

            return response()->json([
                'status' => true,
                'message' => 'Data property berhasil diupdate',
                'data' => $property
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 400);
        }
    }

    public function destroy($id,Request $request)
    {
        $user = $request->user();
        try {
            $property = Property::where('id',$id)->where('user_id',$user->id)->first();

            if ($property->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data property tidak ditemukan'
                ], 404);
            }

            $property->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data property berhasil dihapus',
                'data' => $property
            ], 201); 
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 400); 
        }
    }
}
