<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class HelloDbController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $result = DB::select('select hello_world() as message', []);

        return response()->json([
            'message' => $result[0]->message,
        ]);
    }
}
