<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lock;
use Illuminate\Http\Request;

class LockController extends Controller
{
    public function update(Request $request, Lock $lock)
    {
        $lock->update($request->all());

        return response()->json($lock);
    }
}
