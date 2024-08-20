<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SampleExportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Project $project)
    {
        $data = [
            [
                'project_id' => $project->id,
                'group_name' => '',
                'task_name' => '',
                'unit' => '',
                'quantity' => '',
                'price' => ''
            ],
            [
                'project_id' => $project->id,
                'group_name' => '',
                'task_name' => '',
                'unit' => '',
                'quantity' => '',
                'price' => ''
            ],

        ];

        return Excel::download(new \App\Exports\SampleExport($data), 'project_' . $project->id . '.csv');
    }
}
