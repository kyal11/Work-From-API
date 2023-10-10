<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

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
                ], 404); // Respon 404 jika data tidak ditemukan
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
            ], 400); // Respon 400 untuk kesalahan umum
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
                ], 404); // Respon 404 jika data tidak ditemukan
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
            ], 400); // Respon 400 untuk kesalahan umum
        }
    }

}
