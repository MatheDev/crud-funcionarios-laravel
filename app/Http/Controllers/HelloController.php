<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class HelloController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'message' => 'Hello World',
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
