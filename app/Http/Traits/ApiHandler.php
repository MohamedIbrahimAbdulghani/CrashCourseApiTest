<?php

namespace App\Http\Traits;



trait ApiHandler {
    // this function to handle the success response in a consistent manner
    public function successMessage($message, $data, $status) {
        return response()->json([
            'success' => true,
            'Message' => $message,
            'data' => $data
        ], $status);
    }

    // this function to handle the error response in a consistent manner
    public function errorMessage($message, $data, $status) {
        return response()->json([
            'success' => false,
            'Message' => $message,
            'data' => $data
        ], $status);
    }

    // this function to handle the data response in a consistent manner
    public function returnData($message, $key, $value, $status) {
        return response()->json([
            'success' => true,
            'Message' => $message,
            $key => $value
        ], $status);
    }
}
