<?php
namespace App\Imports;
use App\Models\Project;
use App\Models\Group;
use App\Models\Task;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class ProjectsImport implements ToCollection, WithHeadingRow
{
    protected $duplicates = [];

    public function collection(Collection $rows)
    {
        $tasks = [];
        foreach ($rows as $row) {
            try {
            if (isset($row['project_id'], $row['group_name'], $row['task_name'])) {
                $taskKey = $row['project_id'] . '-' . $row['group_name'] . '-' . $row['task_name'];

                if (in_array($taskKey, $tasks)) {
                    $this->duplicates[] = $row['task_name'];
                    continue;
                }
                $tasks[] = $taskKey;
                $project = Project::find($row['project_id']);

                if ($project) {
                    // Create or find group by name
                    $group = $project->groups()->firstOrCreate(['name' => $row['group_name']]);

                    $existingTask = $group->tasks()->where('name', $row['task_name'])->first();

                    if (!$existingTask) {

                    // Create task associated with the group
                    $group->tasks()->create([
                        'name' => $row['task_name'],
                        'unit' => $row['unit'] ?? null,
                        'quantity' => $row['quantity'] ?? null,
                        'price' => $row['price'] ?? null,
                    ]);
                }
            } else {
                Log::warning("Project with ID {$row['project_id']} not found.");
            }
        } else {
            Log::warning("Missing required fields in row: " . json_encode($row));
        }
    } catch (\Exception $e) {
        Log::error("Error processing row: " . json_encode($row) . " - " . $e->getMessage());
    }
}
    }
public function getDuplicates()
{
    return array_unique($this->duplicates);
}
}

