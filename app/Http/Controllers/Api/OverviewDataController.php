<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Overview;
use Illuminate\Http\Request;

class OverviewDataController extends Controller
{
    public function index()
    {
        // Fetching all overview data
        $overviews = Overview::all();

        // Formatting the data for the charts
        $pieData = $overviews->map(function ($overview) {
            return [
                'project_name' => $overview->project_name,
                'contract_value' => $overview->contract_value,
            ];
        });

        $barData = $overviews->map(function ($overview) {
            return [
                $overview->project_name,
                $overview->contract_value,
                $overview->work_done,
            ];
        });

        return response()->json([
            'pieData' => $pieData,
            'barData' => $barData,
        ]);
    }
}
