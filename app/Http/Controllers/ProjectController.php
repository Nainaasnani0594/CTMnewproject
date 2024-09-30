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
    public function index()
{
    $projects = Project::all(); 
    $user = auth()->user();
    if ($user->hasRole(['Super Admin', 'Admin'])) {
        $projects = Project::with(['createdBy', 'groups'])->get();
    } elseif ($user->hasRole(['Manager', 'Executive'])) {
        $projects = Project::with(['createdBy', 'groups'])
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
        $validated = $request->validate([
            'phase' => 'integer|min:1|max:4',
        ]);
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
    }
    public function update(UpdateProjectRequest $request, Project $project)
    {
   $this->authorize('update', $project);
   $validatedData = $request->validated();
    $project->update($validatedData);
    return response()->json([
        'message' => 'Project updated successfully',
        'project' => $project
    ]);
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






