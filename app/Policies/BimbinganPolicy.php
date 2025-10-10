<?php
namespace App\Policies;

use App\Models\Bimbingan;
use App\Models\User;

class BimbinganPolicy
{
    public function view(User $user, Bimbingan $b): bool {
        return $user->isAdmin() || $b->guru_id === $user->guruWali?->id;
    }
    public function update(User $user, Bimbingan $b): bool {
        return $b->guru_id === $user->guruWali?->id;
    }
    public function delete(User $user, Bimbingan $b): bool {
        return $b->guru_id === $user->guruWali?->id;
    }
}