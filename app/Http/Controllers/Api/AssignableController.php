<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Group;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\Validator;

class AssignableController extends Controller
{
    public function assignments(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'assignable_type' => 'required|in:user,team',
            'assignable_id' => 'required|array',
            'assignable_id.*' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->assignable_type === 'user') {
            $project->users()->sync($request->assignable_id);
        } else {
            $project->teams()->sync($request->assignable_id);
        }

        return response()->json([
            'project' => $project->load('groups.tasks.activities', 'locks', 'teams', 'users'),
            'users' => User::all(),
            'teams' => Team::all(),
        ]);
    }
}
