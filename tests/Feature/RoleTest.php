<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Illuminate\Support\Facades\Auth;

use App\Role;
use App\Permission;
use App\Organization;

class RoleTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected $role;
    protected $permission;
    protected $org;

    protected function setUp(): void
    {
        parent::setup();
        $this->authenticate();
        $this->org        = factory(Organization::class)->create();
        $this->role       = factory(Role::class)->create([
            'org_id' => $this->org->id
        ]);
        $this->permission = factory(Permission::class)->create();

        session(['selected_org_id' => $this->org->id]);
    }

    public function testIndexRole()
    {
        $response = $this->get("/roles");
        $response->assertOk()
                 ->assertSee('id')
                 ->assertSee('org_id')
                 ->assertSee('name')
                 ->assertSee('display_name');
    }

    public function testShowRole()
    {
        $response = $this->get("/role/{$this->role->id}/show");
        $response->assertOk()
                 ->assertSee('id')
                 ->assertSee('org_id')
                 ->assertSee('name')
                 ->assertSee('display_name');
    }

    public function testStoreRole()
    {
        $response = $this->post("/role/store", [
            'name' => 'test',
        ]);
        $response->assertOk();
    }

    public function testUpdateRole()
    {
        $response = $this->put("/role/{$this->role->id}/update", [
            'name' => 'test',
        ]);
        $response->assertOk();
    }

    public function testDestroyRole()
    {
        $response = $this->delete("/role/{$this->role->id}/destroy");
        $response->assertOk();
    }

    public function testCannotDeleteRoleTest()
    {
        $org  = factory(Organization::class)->create();
        $user = factory(User::class)->create()->makeVisible('id');
        $org->users()->attach($user->id);
        $role = factory(Role::class)->create(['org_id' => $org->id]);
        $user->roles()->attach($role->id, ['org_id' => $org->id]);

        session(['selected_org_id' => $org->id]);

        $response = $this->delete("/role/{$role->id}/destroy");
        $response->assertStatus(Response::HTTP_CONFLICT);
    }

    public function testAddPermission()
    {
        $response = $this->get("/role/{$this->role->id}/permission/{$this->permission->id}/toggle-permission");
        $response->assertOk()
                 ->assertSee('permission_added');
    }

    public function testRemovePermission()
    {
        $this->role->permissions()->attach($this->permission->id);

        $response = $this->get("/role/{$this->role->id}/permission/{$this->permission->id}/toggle-permission");
        $response->assertOk()
                 ->assertSee('permission_removed');
    }

    public function testCannotRemovePermission()
    {
        $permission = Permission::where('name', 'role_update')->first();
        session(['selected_role_id' => $this->role->id]);
        $this->role->permissions()->attach($permission->id);

        $response = $this->get("/role/{$this->role->id}/permission/{$permission->id}/toggle-permission");
        $response->assertStatus(Response::HTTP_CONFLICT);
    }
}
