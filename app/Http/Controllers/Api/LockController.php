<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Lock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LockController extends Controller
{
    public function update(Request $request, Lock $lock)
    {
        if (!Auth::user()->hasRole(['Admin', 'Super Admin', 'Manager'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $lock->is_locked = $request->input('is_locked');
        $lock->save();

        return response()->json($lock);
    }
    public function getLocks(Request $request)
    {
        $lockableId = $request->input('lockable_id'); 
        $lockableType = $request->input('lockable_type');

        // Fetch all locks for the given project or entity
        $locks = Lock::where('lockable_id', $lockableId)
                     ->where('lockable_type', $lockableType)
                     ->get();

        return response()->json($locks);
    }
}
