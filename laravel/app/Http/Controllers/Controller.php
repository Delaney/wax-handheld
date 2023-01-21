<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function response($data, $success = true)
    {
        $response = [
            'success' => $success,
            'data' => $data,
        ];

        return response()->json($response);
    }

    public function errorResponse($data, $code)
    {
        $response = [
            'error' => $data,
        ];

        return response()->json($response, $code);
    }
}
