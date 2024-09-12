<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Manager;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Team;
use App\Models\User;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects based on user role and permissions.
     *
     * This function retrieves and returns a list of projects based on the authenticated user's role:
     * - Super Admin and Admin roles can see all projects.
     * - Manager and Executive roles can see projects they are assigned to directly or through their team.
     * - Other roles (e.g., regular users) will see an empty list.
     *
     * The function uses the Spatie Roles and Permissions package for role checking.
     * It also utilizes Laravel's Eloquent polymorphic relationships for efficient querying.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole(['Super Admin', 'Admin'])) {
            // Super Admin and Admin can see all projects
            $projects = Project::with('createdBy')->get();
        } elseif ($user->hasRole(['Manager', 'Executive'])) {
            // Manager and Executive can see projects they are assigned to directly or through their team
            $projects = Project::with('createdBy')
                ->where(function ($query) use ($user) {
                    $query->whereHas('users', function ($q) use ($user) {
                        $q->where('project_assignments.assignable_id', $user->id)
                            ->where('project_assignments.assignable_type', User::class);
                    })
                        ->orWhereHas('teams', function ($q) use ($user) {
                            $q->whereHas('users', function ($u) use ($user) {
                                $u->where('users.id', $user->id);
                            });
                        });
                })
                ->get();
        } else {
            // Other roles see an empty list
            $projects = collect();
        }

        return Inertia::render('Projects/Index', [
            'projects' => $projects,
        ]);
    }

    public function create()
    {
        return Inertia::render('Projects/Create');
    }

    public function store(StoreProjectRequest $request)
    {
        $validatedData = $request->validated();

        $project = Project::make($request->validated());
        $project->created_by = auth()->id();
        $project->save();
    if ($request->has('project_manager')) {
        $manager = User::find($request->project_manager);
        $project->users()->attach($manager);
    }
        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);
        return Inertia::render('Projects/Show', [
            'project' => $project->load('groups.tasks.activities', 'locks', 'users', 'teams'),
            'users' => User::all(),
            'teams' => Team::all(),
        ]);
    }

    public function edit(Project $project)
    {
        //
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        //
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index');
    }
    public function import_excel()
    {
        return view('import_excel');
    }
    public function import_excel_post(Request $request)
    {
        dd($request->all());
    }
}
