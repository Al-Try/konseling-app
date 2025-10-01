<?php

namespace App\Policies;

use App\Models\Bimbingan;
use App\Models\User;

class BimbinganPolicy
{
    public function view(User $user, Bimbingan $b): bool
    {
        return $user->isAdmin() || $user->guruWali?->id === $b->guru_id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isGuruWali();
    }

    public function update(User $user, Bimbingan $b): bool
    {
        return $this->view($user, $b);
    }

    public function delete(User $user, Bimbingan $b): bool
    {
        return $user->isAdmin();
    }
}
