<?php

namespace App\Policies;

use App\Models\Bimbingan;
use App\Models\User;

    // app/Policies/BimbinganPolicy.php
    class BimbinganPolicy {
        public function viewAny(User $user): bool { return in_array($user->role,['admin','guru_wali']); }
        public function create(User $user): bool  { return in_array($user->role,['admin','guru_wali']); }
        public function update(User $user, Bimbingan $b): bool {
            if ($user->role === 'admin') return true;
            return $user->role === 'guru_wali' && $b->guruWali?->user_id === $user->id;
        }
        public function delete(User $user, Bimbingan $b): bool { return $this->update($user,$b); }
    }

