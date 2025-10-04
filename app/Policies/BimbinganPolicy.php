<?php

namespace App\Policies;

use App\Models\Bimbingan;
use App\Models\User;

class BimbinganPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) return true; // admin bebas
        return null;
    }

    public function view(User $user, Bimbingan $bimbingan): bool
    {
        return $user->isGuruWali() && $bimbingan->guru_id === $user->guruWali?->id;
    }

    public function create(User $user): bool
    {
        return $user->isGuruWali();
    }
}
