<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Helper\ResponseHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function test(){
        return response()->json([
           'message' => 'Hello World'
        ], 200);
    }
    
    public function register(RegisterRequest $request)
    {
        try{
            $user=User::create([
                'email' => $request->email,
                'password' =>  Hash::make($request->password),
                'user_type_id' => $request->user_type_id,
                'employee_id' => $request->employee_id,

            ]);



            if($user){
                // Optionally, generate an authentication token for the user
                $token = $user->createToken('auth_token')->plainTextToken;
                return ResponseHelper::success(array('user'=>$user,'token'=>$token), 'User registered successfully',201);
            }else{
                return ResponseHelper::error('Failed to register user');
            }
        }catch(Exception $e){
            return ResponseHelper::error($e->getMessage());
        }

    }

    public function login(LoginRequest $request){
        //to check database connection is active or not
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(),null,503);;
        }

        try{
            // Attempt to authenticate the user
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            // Get the authenticated user
            $user = Auth::user();

            // Generate a new token for API authentication (Using Laravel Sanctum)
            $token = $user->createToken('auth_token')->plainTextToken;
            $userResource = new UserResource($user);
            // return ResponseHelper::success('success','login successfully',array('user'=>$userResource,'token'=>$token),200);
            return ResponseHelper::success('success','login successfully',array('user'=>new UserResource($user),'token'=>$token),200);
        }catch(Exception $e){
            return ResponseHelper::error($e->getMessage(),null);
        }
    }

    function getCurrentUser(){

        $user=auth()->user();
        if(!$user){
                return ResponseHelper::error('token expired',401);
        }else{
                return ResponseHelper::success('success','User fetched',new UserResource($user),200);
        }
    }
    public function logout()
    {
        $user=auth()->user();
        $user->tokens()->delete();
        return ResponseHelper::success(null, 'Logged out successfully', 200);
    }
    public function revoke_all(){
        //revoke all tokens from current user
        $result = auth()->user()->tokens()->delete();
        return ResponseHelper::success(null, 'Revoke all',$result, 200);
    }


}
