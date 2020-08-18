<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $user = User::get();
        $response = [
            'data' => $user
        ];

        return response()->json($response, 200);
    }

    public function show($id){
        $user = User::find($id);
        if(is_null($user)){
            $status = 404;
            $response = [
                'message' => 'Data User Tidak Ditemukan',
            ];
        }
            
        else   {
            $status = 200;
            $response = [
                'message' => 'Data User Ditemukan',
                'data' => $user,
            ];
        }

        return response()->json($response, $status);
    }

    public function store(Request $request){
        $rules = [
            'nama' => 'required',
            'nim' => 'required',
            'prodi' => 'required',
            'fakultas' => 'required',
            'jenis_kelamin' => 'required',
            'username' => 'required',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $status = 400;
            $response = [
                'message' => $validator->errors(),
            ]; 
        }else{
            try{
                $user = User::create($request->all());
                $user->password = Hash::make($request->password);
                $user->save(); 
                $status = 200;
                $response = [
                    'message' => 'Tambah data berhasil',
                    'data' => $user
                ]; 
            }
            catch(\Illuminate\Database\QueryException $e){
                $status = 500;
                $response = [
                    'message' => $e,
                ];
            }
        }
        
        return response()->json($response, $status);
    }

    public function update(Request $request, $id){
        $user = User::find($id);

        if(is_null($user)){
            $status=404;
            $response = [
                'message' => 'Data Tidak Ditemukan'
            ];
        }
        else{
            try{
                $user->update($request->all());
                $user->password = Hash::make($request->password);
                $user->save(); 
                $status = 200;
                $response = [
                    'message' => 'Edit data berhasil.',
                    'data' => $user,
                ];  
            }
            catch(\Illuminate\Database\QueryException $e){
                $status = 500;
                $response = [
                    'message' => $e
                ];
            }
        }
        return response()->json($response, $status); 
    }

    public function destroy($id){
        $user = User::find($id);

        if(is_null($user)){
            $status=404;
            $response = [
                'message' => 'Data Tidak Ditemukan'
            ];
        }else{
            $user->delete();
            $status=200;
            $response = [
                'message' => 'Hapus data berhasil.',
                'data' => $user,
            ];
        }
        return response()->json($response, $status);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 400);
        }

        $user = User::where('username', $request->username)->first();

        if(is_null($user)){
            $status=404;
            $response = [
                'message' => 'Username tidak ditemukan'
            ];
        }else{
            if(Hash::check($request->password, $user->password)){
                $status=200;
                $response = [
                    'message' => 'Berhasil login',
                    'data' => $user,
                ];
            }else{
                $status=404;
                $response = [
                    'message' => 'Password salah'
                ];
            }
        }

        return response()->json($response, $status);
    }
}
