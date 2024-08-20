<?php

namespace App\Imports;

use App\Models\Project;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProjectsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $project = Project::find($row['project_id']);
            // create or find group by name
            $group = $project->groups()->firstOrCreate(['name' => $row['group_name']]);
            $group->tasks()->create([
                'name' => $row['task_name'],
                'unit' => $row['unit'],
                'quantity' => $row['quantity'],
                'price' => $row['price'],
            ]);
        }
    }
}
