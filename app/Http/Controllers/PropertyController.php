<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    public function index(){
        try {
            $data = Property::orderBy('name', 'asc')->get();
            
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

    public function show($id)
    {
        try {
            $property = Property::find($id);

            if ($property === null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
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
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required', 
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
                    'message' => 'Semua input harus diisi',
                    'data' => $validator->errors()
                ]);
            }

            $property = new Property;
            $property->user_id = $request->user_id;
            $property->name = $request->name;
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
        try {
            $property = Property::find($id);

            if (empty($property)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'user_id' => 'required', // Sesuaikan dengan field yang sesuai di tabel properties
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

            $property->user_id = $request->user_id;
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
            ], 201); // Respon 201 untuk Created
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 400); // Respon 400 untuk kesalahan umum
        }
    }

    public function destroy($id)
    {
        try {
            $property = Property::find($id);

            if (empty($property)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $property->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data property berhasil dihapus',
                'data' => $property
            ], 201); // Respon 201 untuk Created
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 400); // Respon 400 untuk kesalahan umum
        }
    }
}
