<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Project $project)
    {
        Excel::import(new \App\Imports\ProjectsImport, $request->file('file'));

        return response()->json([
            'project' => $project->load('groups.tasks.activities', 'locks', 'teams', 'users'),
            'users' => User::all(),
            'teams' => Team::all(),
        ]);
    }
}
