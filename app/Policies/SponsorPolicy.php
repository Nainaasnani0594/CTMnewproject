<?php

namespace App\Policies;
use App\Models\Overview;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SponsorPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }
    public function view(User $user, Sponsor $sponsor): bool
    {
        return true;
    }
    public function create(User $user): bool
    {
        return true;
    }
    public function update(User $user, Sponsor $sponsor): bool
    {
        return true;
    }
    public function delete(User $user, Sponsor $sponsor): bool
    {
        return true;
    }
    public function restore(User $user, Sponsor $sponsor): bool
    {
        return true;
    }
    public function forceDelete(User $user, Sponsor $sponsor): bool
    {
        return true;
    }
}
