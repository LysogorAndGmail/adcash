<?php

namespace App\Traits;

use App\Permission;
use App\Role;

trait HasPermissionsTrait
{
    public function hasPermissionTo($permission)
    {
        $role = Role::find(session('selected_role_id'));
        if ($role->permissions->contains($permission)) {
            return true;
        }

        return false;
    }

    private function hasPermissionThroughRole($permission)
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }

        return false;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles')->withTimestamps();
    }
}