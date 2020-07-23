<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends BaseController
{
    /**
     * Login user to api
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request){
        $user_credential = 'email';
        $validation = $this->validateAPILogin($request->all(), $user_credential);
        if($validation->fails()){
            $validation_error =  BaseController::validationErrorsNormalize($validation->errors(), 'user_login');
            return $this->sendError($validation_error);
        }
        $login = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if($login){
            $user = Auth::user();
            try{
                $success['token'] =  $user->createToken('App')->accessToken;
            }catch (\Exception $e){
                $validation_error = BaseController::validationErrorsNormalize([
                    'token' => ['Passport server failure - Token cant generated']
                ], 'user_login_generate', true);
                return $this->sendError($validation_error, $e);
            }
            $success['id'] =  $user->id;
            $success['name'] =  $user->name;
            $success['email'] =  $user->email;
            return $this->sendResponse($success, 'User login successfully.', 'user_login', 'login');
        }else{
            $error_message = null;
            if( is_null(User::where('email', $request->email)->first()) ){
                $error_message = [
                    'user' => ['User is unregistered']
                ];
            }else{
                $error_message = [
                    'password' => ['Wrong password']
                ];
            }
            $validation_error = BaseController::validationErrorsNormalize($error_message, 'user_login', true);
            return $this->sendError($validation_error);
        }
    }

    /**
     * Validate the user login request.
     *
     * @param $input
     * @param $user_credential
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validateAPILogin($input, $user_credential){
        $messages = [
            'email' => 'Email address invalid.'
        ];
        return Validator::make($input, [
            'email' => 'required',
            'password' => 'required',
        ],$messages);
    }
}
