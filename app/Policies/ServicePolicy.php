<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ServicePolicy
{
    // ... (kode lain biarkan saja)

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Service $service): bool
    {
        // Izinkan jika user_id di profil mitra sama dengan id user yang login
        return $user->id === $service->mitraProfile->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Service $service): bool
    {
        // Izinkan jika user_id di profil mitra sama dengan id user yang login
        return $user->id === $service->mitraProfile->user_id;
    }

    // ... (kode lain biarkan saja)
}
