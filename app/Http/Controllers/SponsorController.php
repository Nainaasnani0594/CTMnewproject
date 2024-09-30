<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Sponsor; 
use Carbon\Carbon;
use Inertia\Inertia;
use Log;
class SponsorController extends Controller
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
    $sponsorNames = Project::select('sponsor_name')
        ->distinct()
        ->get()
        ->pluck('sponsor_name'); 
    $sponsors = Project::with(['groups.tasks.activities', 'locks'])
        ->get()
        ->map(function ($project) {
            $contract_value = $project->contract_value;
            $task_done = $project->groups->flatMap->tasks->sum(function ($task) use ($project) {
                $locks = $project->locks->toArray();
                $completed_units = $this->sumActual($task->activities, $locks);
                return $completed_units * $task->price; 
            });
            $monthlyTotals = [];
                $project->groups->flatMap->tasks->each(function ($task) use ($project, &$monthlyTotals) {
                    $task->activities->each(function ($activity) use ($task, &$monthlyTotals) {
                        $activityDate = Carbon::parse($activity->date);
                        $monthKey = $activityDate->format('F Y'); 

                        if (!isset($monthlyTotals[$monthKey])) {
                            $monthlyTotals[$monthKey] = 0;
                        }

                        $monthlyTotals[$monthKey] += $activity->value * $task->price;
                    });
                });
            $task_remain = $contract_value - $task_done;
            $status = $task_done >= $contract_value ? 'Done' : 'Work in Progress';
            return [
                'id' => $project->id,
                'project_name' => $project->project_name,
                'project_manager' => $project->project_manager,
                'contract_value' => $contract_value,
                'task_done' => $task_done,
                'task_remain' => $task_remain,
                'contract_holder_country' => $project->contract_holder_country,
                'status' => $status,
                'monthly_task_done' => $monthlyTotals, 
            ];
        });
    Log::info('Sponsors data:', $sponsors->toArray());
    return Inertia::render('Sponsor', [
        'sponsors' => $sponsors,
        'allSponsors' => $sponsorNames, 
    ]);
}
public function getSponsors()
{
    $sponsorNames = Project::select('sponsor_name')->distinct()->get()->pluck('sponsor_name');
    return response()->json($sponsorNames); 
}
public function getSponsorDetails($sponsorName)
{
    Log::info('Fetching details for sponsor: ' . $sponsorName);

    $projects = Project::where('sponsor_name', $sponsorName)
        ->with(['groups.tasks.activities', 'locks'])
        ->get()
        ->map(function ($project) {
            Log::info('Processing project: ' . $project->id);

            $contract_value = $project->contract_value;

            $task_done = $project->groups->flatMap->tasks->sum(function ($task) use ($project) {
                $locks = $project->locks->toArray();
                $completed_units = $this->sumActual($task->activities, $locks);
                return $completed_units * $task->price; 
            });
            $task_remain = $contract_value - $task_done;
           $startDate = Carbon::parse($project->activity_start_date);

           $monthlyTotals = [];
           $project->groups->flatMap->tasks->each(function ($task) use ($project, &$monthlyTotals) {
               $task->activities->each(function ($activity) use ($task, &$monthlyTotals) {
                   $activityDate = Carbon::parse($activity->date);
                   $monthKey = $activityDate->format('F Y'); 

                   if (!isset($monthlyTotals[$monthKey])) {
                       $monthlyTotals[$monthKey] = 0;
                   }

                   $monthlyTotals[$monthKey] += $activity->value * $task->price;
               });
           });
            return [
                'id' => $project->id,
                'project_name' => $project->project_name,
                'project_manager' => $project->project_manager,
                'contract_value' => $contract_value,
                'task_done' => $task_done,
                'task_remain' => $task_remain,
                'contract_holder_country' => $project->contract_holder_country,
                'status' => $task_done >= $contract_value ? 'Done' : 'Work in Progress',
                'monthly_task_done' => $monthlyTotals,
            ];
        });
    return response()->json($projects);
}
public function getSponsorMonths($sponsorName)
{
    $projects = Project::where('sponsor_name', $sponsorName)
        ->get()
        ->map(function ($project) {
            $startDate = Carbon::parse($project->activity_start_date);
            $months = [];
            for ($i = 0; $i < $project->study_duration; $i++) {
                $months[] = $startDate->copy()->addMonths($i)->format('F Y'); 
            }
            return $months; 
        });
    return response()->json($projects);
}
}
