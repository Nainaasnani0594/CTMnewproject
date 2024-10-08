<?php

namespace App\Policies;
use App\Models\Overview;
use App\Models\User;
use Illuminate\Auth\Access\Response;
class OverviewPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }
    public function view(User $user, Overview $overview): bool
    {
        return true;
    }
    public function create(User $user): bool
    {
        return true;
    }
    public function update(User $user, Overview $overview): bool
    {
        return true;
    }
    public function delete(User $user, Overview $overview): bool
    {
        return true;
    }
    public function restore(User $user, Overview $overview): bool
    {
        return true;
    }
    public function forceDelete(User $user, Overview $overview): bool
    {
        return true;
    }
}

//app>Policies>overviewPolicy.php
