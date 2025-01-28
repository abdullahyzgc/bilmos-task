<?php

namespace App\Services;

class ResponseService
{
    public static function success($data = null, $message = 'İşlem başarılı', $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function error($message = 'Bir hata oluştu', $code = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $code);
    }

    public static function validation($errors)
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Validation error',
            'errors' => $errors
        ], 422);
    }
} 