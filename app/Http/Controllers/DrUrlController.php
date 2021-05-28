<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class DrUrlController extends Controller
{
    public function drUrl(Request $request, $broadcast_id, $key)
    {
        Log::debug($request->all());
    }
}
