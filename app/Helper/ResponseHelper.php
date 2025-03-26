<?php

namespace App\Helper;
class ResponseHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public static function success($status='success',$message=null,$data=[], $statusCode=200){
        return response()->json([
            "status" => $status,
            "message" => $message?? "Success",
            "data" => $data
        ],$statusCode);
    }
    public static function error($message=null,$data=null, $statusCode=400){
        return response()->json([
            "status" => 'error',
            "message" => $message?? "error in program",
            "data" => $data?? null
        ],$statusCode);
    }
}
