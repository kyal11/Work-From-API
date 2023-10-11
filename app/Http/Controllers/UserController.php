<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request){
        $datauser = new User();

        $rules = [
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' =>'Proses validasi gagal',
                'data' =>$validator->errors()
            ],401);
        }
        $datauser->username = $request->username;
        $datauser->email = $request->email;
        $datauser->password = Hash::make($request->password);
        $datauser->phone_number = $request->phone_number; 

        $datauser->save();
        return response()->json([
            'status' => true,
            'message' => 'Sukses membuat akun',
            'data' => [
                'username' => $datauser->username,
                'email' => $datauser->email,
                'phone_number' => $datauser->phone_number
            ]
        ], 200);
    }

    public function login(Request $request){
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' =>'Proses Login gagal',
                'data' =>$validator->errors()
            ],401);
        }

        if(!Auth::attempt($request->only(['email','password']))){
            return response()->json([
                'status' => false,
                'message' =>'Email dan Password yang dimasukkan tidak sesuai'
            ],401);
        }

        $datauser = User::where('email',$request->email)->first();
        $generateToken = $datauser->createToken('api-token')->plainTextToken;
        $datauser->remember_token = $generateToken;
        $datauser->save();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil Login',
            'token' =>$generateToken
        ]);
    }

    public function currentUser(Request $request){
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $user,
        ], 200);
    }
    
    public function updateUser(Request $request)
    {
        $user = $request->user();
    
        $rules = [
            'email' => 'email|unique:users,email,' . $user->id, 
            'password' => 'min:6',
            'phone_number' => 'min:8',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Proses validasi gagal',
                'data' => $validator->errors()
            ], 400);
        }
    
        if ($request->has('email')) {
            $user->email = $request->email;
        }
    
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        if ($request->has('phone_number')) {
            $user->phone_number = $request->phone_number;
        }
    
        $user->save();
    
        return response()->json([
            'status' => true,
            'message' => 'Berhasil update akun',
        ], 200);
    }
    

    public function logout(Request $request)
    {
    $request->user()->currentAccessToken()->delete();

    $request->user()->update([
        'remember_token' => null,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Berhasil logout',
    ],200);
    }
}
