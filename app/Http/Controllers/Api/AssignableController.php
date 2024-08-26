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
    public function assign(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'assignable_type' => 'required|in:project,group',
            'assignable_id' => 'required|integer',
            'assigned_type' => 'required|in:user,team',
            'assigned_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $assignableType = $request->input('assignable_type') === 'project' ? Project::class : Group::class;
        $assignedType = $request->input('assigned_type') === 'user' ? User::class : Team::class;

        $assignable = $assignableType::findOrFail($request->input('assignable_id'));
        $assigned = $assignedType::findOrFail($request->input('assigned_id'));

        $relationMethod = 'assigned' . ucfirst($request->input('assigned_type')) . 's';

        $assignable->$relationMethod()->attach($assigned);

        return response()->json(['message' => 'Successfully assigned'], 200);
    }

    public function unassign(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'assignable_type' => 'required|in:project,group',
            'assignable_id' => 'required|integer',
            'assigned_type' => 'required|in:user,team',
            'assigned_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $assignableType = $request->input('assignable_type') === 'project' ? Project::class : Group::class;
        $assignedType = $request->input('assigned_type') === 'user' ? User::class : Team::class;

        $assignable = $assignableType::findOrFail($request->input('assignable_id'));
        $assigned = $assignedType::findOrFail($request->input('assigned_id'));

        $relationMethod = 'assigned' . ucfirst($request->input('assigned_type')) . 's';

        $assignable->$relationMethod()->detach($assigned);

        return response()->json(['message' => 'Successfully unassigned'], 200);
    }

    public function getAssignments(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'assignable_type' => 'required|in:project,group',
            'assignable_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $assignableType = $request->input('assignable_type') === 'project' ? Project::class : Group::class;
        $assignable = $assignableType::findOrFail($request->input('assignable_id'));

        $users = $assignable->assignedUsers()->get();
        $teams = $assignable->assignedTeams()->get();

        return response()->json([
            'users' => $users,
            'teams' => $teams,
        ], 200);
    }
}
