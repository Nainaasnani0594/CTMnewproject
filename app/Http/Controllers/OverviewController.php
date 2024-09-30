<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Overview; 
use Carbon\Carbon;
use Inertia\Inertia;
use Log;
class OverviewController extends Controller
{
    private function isLocked($date, $locks)
    {
        $lockEntry = collect($locks)->first(function ($lock) use ($date) {
            return Carbon::parse($lock['date'])->isSameMonth($date);
        });
        return $lockEntry ? $lockEntry['is_locked'] : false;
    }
    private function sumActual($activities, $locks)
    {
        return $activities->sum(function ($activity) use ($locks) {
            return $this->isLocked($activity->date, $locks) ? $activity->value : 0;
        });
    }
    private function calculateTotalTaskValue($task)
    {
        return $task->quantity * $task->price;
    }
    public function index()
    {
        $overviews = Project::with(['groups.tasks.activities', 'locks'])
    ->get()
    ->map(function ($project) {
        $contract_value = $project->groups->flatMap->tasks->sum(function ($task) {
            return $this->calculateTotalTaskValue($task);

        });
        $work_done = $project->groups->flatMap->tasks->sum(function ($task) use ($project) {
            $locks = $project->locks->toArray();
            $completed_units = $this->sumActual($task->activities, $locks);
            return $completed_units * $task->price;
        });
        $task_done = $project->groups->flatMap->tasks->sum(function ($task) {
            return $this->calculateTotalTaskValue($task); 
        });
        $status = $work_done >= $contract_value ? 'Done' : 'Work in Progress';
            return [
            'id' => $project->id,
            'project_name' => $project->project_name,
            'contract_value' => $project->contract_value,
            'work_done' => $work_done,
            'task_done' => $task_done,
            'country' => $project->contract_holder_country,
            'phase' => $project->phase,
            'therapeutic_area' => $project->therapeutic_area,
            'status' => $status,
        ];
    });
Log::info('Overviews data:', $overviews->toArray());
return Inertia::render('Overview', [
    'overviews' => $overviews
]);
}
}


//app>Http>Controller>overviewcontroller.php
