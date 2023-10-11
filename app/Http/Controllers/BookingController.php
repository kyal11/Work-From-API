<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index(){
        try{
            $booking = Booking::orderBy('id', 'asc')->get();
        
            if ($booking->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data booking tidak ditemukan',
                    'data' => []
                ], 404); 
            }

            return response()->json([
                'status' => true,
                'message' => 'Data booking ditemukan',
                'data' => $booking
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 400);
        }
    }
    public function store(Request $request){
        try {
            $user = $request->user();
            $propertyId = $request->property_id;
        
            $property = Property::find($propertyId);
            if ($property === null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data property tidak ditemukan',
                    'data' => []
                ], 404); 
            }
    
            $validator = Validator::make($request->all(), [
                'start_date' => 'required',
                'end_date' => 'required',
                'status' => 'required'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal memasukkan data',
                    'data' => $validator->errors()
                ], 400);
            }
    
            $booking= new Booking();
            $booking->user_id = $user->id;
            $booking->property_id = $propertyId;
            $booking->booking_date = now();
            $booking->start_date = $request->start_date;
            $booking->end_date = $request->end_date;
            $booking->status = $request->status;
    
            $booking->save();
    
            return response()->json([
                'status' => true,
                'message' => 'Data booking berhasil disimpan',
                'data' => $booking
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 400);
        }
    }
    public function show($id){
        try{
            $booking = Booking::find($id);
        
            if ($booking === null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data booking tidak ditemukan',
                    'data' => []
                ], 404); 
            }

            return response()->json([
                'status' => true,
                'message' => 'Data booking ditemukan',
                'data' => $booking
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 400);
        }
    }
    public function update(Request $request, $id){
        try {
            $booking = Booking::find($id);
        
            if ($booking === null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data booking tidak ditemukan',
                    'data' => []
                ], 404); 
            }
    
            $validator = Validator::make($request->all(), [
                'start_date' => 'required',
                'end_date' => 'required',
                'status' => 'required'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal mengupdate data',
                    'data' => $validator->errors()
                ], 400);
            }
    
            // Update data booking sesuai request
            $booking->start_date = $request->start_date;
            $booking->end_date = $request->end_date;
            $booking->status = $request->status;
        
            $booking->save();
    
            return response()->json([
                'status' => true,
                'message' => 'Data booking berhasil diupdate',
                'data' => $booking
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 400);
        }
    }
    
    public function destroy($id){
        try {
            $booking = Booking::find($id);
        
            if ($booking === null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data booking tidak ditemukan',
                    'data' => []
                ], 404); 
            }
    
            // Hapus data booking
            $booking->delete();
    
            return response()->json([
                'status' => true,
                'message' => 'Data booking berhasil dihapus',
                'data' => $booking
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 400);
        }
    }
    
}
