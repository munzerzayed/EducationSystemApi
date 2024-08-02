<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use GeneralTrait;

    public function login(Request $request)
	{
        $rules = [
            "email" => "required|exists:users,email",
            "password" => "required"
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->returnError('401',__('auth.fieldAllInput'));
        }

        $credentials = $request-> only(['email' , 'password']);
        $token = Auth::guard('user-api')->attempt($credentials);

        if(!$token){
            return $this-> returnError('401',__('auth.fieldAllInput'));
        }

        $user = Auth::guard('user-api')->user();
        $user['apiToken'] = $token;
        return $this-> returnData('data',$user);
	}

    public function logout(Request $request){
        $token = $request->bearerToken();
        if ($token){
            try{
                auth()->logout();
                JWTAuth::setToken($token)->invalidate();
                return $this->returnSuccessMassage('Logged Out Successfully');
            }
            catch(\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError(404,'Some Thing Went Wrong');
            }
        } else {
            return $this->returnError(404,'Token not provided');
        }
    }

	public function userProfile()
	{
		$user = Auth::guard('user-api')->user();
		$roles = $user->getRoleNames(); // Get the roles of the user
		return $this->returnData('user', ['user' => $user, 'roles' => $roles], 'User profile fetched successfully');
	}
}
