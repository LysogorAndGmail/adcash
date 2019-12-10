<?php

namespace Tests;

use App\Organization;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function authenticate()
    {
        $user = factory(User::class)->create()->makeVisible('id');
        $org  = factory(Organization::class)->create();
        $org->users()->attach($user->id);
        $role = factory(Role::class)->create(['org_id' => $org->id]);
        $user->roles()->attach($role->id, ['org_id' => $org->id]);
        if (Permission::count() == 0) {
            Artisan::call('db:seed', ['--class' => 'PermissionSeeder']);
        }
        $role->permissions()->attach(Permission::all()->pluck('id'));
        session(['selected_role_id' => $role->id]);
        session(['selected_org_id' => $org->id]);
        $this->actingAs($user);
    }
}
