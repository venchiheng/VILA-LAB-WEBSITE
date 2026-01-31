<?php

namespace App\Policies;

use App\Models\Equipment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EquipmentPolicy
{
    public function viewAny($user)
{

    return in_array($user->role, ['admin', 'member']);
}

public function view($user, $equipment)
{
    return in_array($user->role, ['admin', 'member']);
}

public function create($user)
{
    return $user->role === 'admin';
}

public function update($user, $equipment)
{
    return $user->role === 'admin';
}

public function delete($user, $equipment)
{
    return $user->role === 'admin';
}

}
