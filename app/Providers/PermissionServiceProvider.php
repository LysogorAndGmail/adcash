<?php

namespace App\Providers;

use App\Permission;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    public function boot(GateContract $gate)
    {
        if (Schema::hasTable('permissions')) {
            Permission::get()->map(function ($permission) use ($gate) {
                $gate->define($permission->name, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission);
                });
            });
        }
    }

    public function register()
    {
        //
    }
}
