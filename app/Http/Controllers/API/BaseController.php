<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * Send success response
     */
    public function sendResponse($data = [], $message = 'Success', $status = 200)
    {
        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'data'    => $data
        ], $status);
    }

    /**
     * Send error response
     */
    public function sendError($message = 'Error', $errors = [], $status = 400)
    {
        return response()->json([
            'status'  => 'error',
            'message' => $message,
            'errors'  => $errors
        ], $status);
    }
}
