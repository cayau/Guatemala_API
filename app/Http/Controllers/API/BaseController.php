<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BaseController extends Controller
{
    /**
     * Normalize the laravel validation error.
     * @param  $validation_array
     * @param $prefix
     * @param bool $code
     * @param bool $custom_validator
     * @return array
     */
    public static function validationErrorsNormalize($validation_array, $prefix, $custom_validator = false, $code = true){
        $message_error_keys = [
            'empty',
            'wrong',
            'required',
            'unregistered',
            'taken',
            'invalid',
            'weak',
            'missing',
            'failure',
            'undefined',
            'unset',
            'unchanged',
            'confirmation',
            'already'
        ];
        $validation_array = $custom_validator ? $validation_array : $validation_array->getMessages();
        $error_normalized = [];
        foreach ($validation_array as $field => $message){
            $message_array = explode(' ', $message[0]);
            $suffix = '';
            foreach ($message_array as $message_part){
                $message_part = Str::slug($message_part);
                if(in_array($message_part, $message_error_keys)){
                    $suffix = $message_part;
                }
            }
            if(is_array($message)){
                if(count($message) == 1){
                    $message = $message[0];
                }
            }else{
                $message = $message[0];
            }
            $error_normalized_content = [
                'message' => $message,
            ];
            if($code){
                $error_normalized_content['code'] = "{$prefix}_{$field}_{$suffix}";
                $error_normalized_content['field'] = $field;
            }
            array_push($error_normalized, $error_normalized_content);
        }
        return $error_normalized;
    }

    /**
     * success response method.
     *
     * @param $result
     * @param $message
     * @param $prefix
     * @param $code
     * @param $field
     * @return JsonResponse
     */
    public static function sendResponse($result, $message, $prefix, $field = null, $code = true){
        $response = [];
        $response['data'] = $result;
        $response['success'] = [
            'message' => $message
        ];
        if($code){
            $response['success']['code'] = self::successCodeNormalize($message, $prefix, $field);
        }
        $output = [
            'success' => true,
            'response' => $response,
        ];
        return response()->json($output, 200);
    }

    /**
     * return error response.
     *
     * @param array $errorMessages
     * @param array $data
     * @param bool $errorOnly
     * @param int $code
     * @return array|JsonResponse
     */
    public static function sendError($errorMessages = [], $data = [], $errorOnly = false, $code = 404){
        $response = [];
        $response['data'] = $data;
        $response['error'] = $errorMessages;
        $output = [
            'success' => false,
            'response' => $response,
        ];
        return $errorOnly ? $output : response()->json($output, $code);
    }

    
    /**
     * Normalize the success code.
     * @param $message
     * @param $prefix
     * @param $field
     * @param bool $no_suffix
     * @return string
     */
    public static function successCodeNormalize($message, $prefix, $field = null, $no_suffix = false){
        $success_keys = [
            'successfully',
            'available',
            'unavailable',
            'already',
            'unchanged'
        ];
        $message_array = explode(' ', $message);
        $suffix = '';
        foreach ($message_array as $message_part){
            $message_part = Str::slug($message_part);
            if(in_array($message_part, $success_keys)){
                $suffix = $message_part;
            }
        }
        return is_null($field) ? ($no_suffix ? "{$prefix}" : "{$prefix}_{$suffix}") : "{$prefix}_{$field}_{$suffix}";
    }
}
