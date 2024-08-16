<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

class HolidayController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Hello World',
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'message' => 'Hello World',
        ]);
    }

    public function store()
    {
        return response()->json([
            'message' => 'Hello World',
        ]);
    }

    public function update($id)
    {
        return response()->json([
            'message' => 'Hello World',
        ]);
    }

    public function destroy($id)
    {
        return response()->json([
            'message' => 'Hello World',
        ]);
    }
}
