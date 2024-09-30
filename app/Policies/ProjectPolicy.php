<?php
namespace App\Policies;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;
class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['Super Admin', 'Admin', 'Manager', 'Executive']);
    }
    public function view(User $user, Project $project): bool
    {
        if ($user->hasRole(['Super Admin', 'Admin'])) {
            return true;
        }
        return $project->users->contains($user) || $project->teams->flatMap->users->contains($user);
    }
    public function create(User $user): bool
    {
        $hasPermission = $user->hasRole(['Super Admin', 'Admin']);
        \Log::info('User role check for creating project:', ['hasPermission' => $hasPermission]);
        return $hasPermission;
        }
    public function update(User $user, Project $project): bool
    {
        if ($user->hasRole(['Super Admin', 'Admin'])) {
            return true;
        }

        return $project->users->contains($user) || $project->teams->flatMap->users->contains($user);
    }
    public function delete(User $user, Project $project): bool
    {
        if ($user->hasRole(['Super Admin', 'Admin'])) {
            return true;
        }

        return $project->users->contains($user) || $project->teams->flatMap->users->contains($user);
    }
    public function restore(User $user, Project $project): bool
    {
        return $this->view($user, $project);
    }
    public function forceDelete(User $user, Project $project): bool
    {
        return $this->delete($user, $project);
    }
}
