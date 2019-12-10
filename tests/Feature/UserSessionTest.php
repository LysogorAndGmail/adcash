<?php

namespace Tests\Feature;

use App\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Illuminate\Support\Facades\Auth;

use App\Organization;
use App\User;

class UserSessionTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected $user;
    protected $org;

    protected function setUp(): void
    {
        parent::setup();
        $this->authenticate();

        $this->user = Auth::user();
        $this->org  = factory(Organization::class)->create();
        $this->org->users()->attach($this->user->id);
        $this->role = factory(Role::class)->create(['org_id' => $this->org->id]);
        $this->user->roles()->attach($this->role->id, [
            'org_id' => $this->org->id
        ]);
    }

    public function testUser()
    {
        $response = $this->get("/auth-user");
        $response->assertOk()
                 ->assertSee('fname')
                 ->assertSee('lname')
                 ->assertSee('email')
                 ->assertSee('email_verified_at');

    }

    public function testUserOrgs()
    {
        $response = $this->get("/user-organizations");
        $response->assertOk()
                 ->assertSee('id')
                 ->assertSee('name');
    }

    public function testGetUserRoles()
    {
        $response = $this->get("/user-roles");
        $response->assertOk()
                 ->assertSee('id')
                 ->assertSee('display_name');
    }

    public function testChangeOrg()
    {
        $response = $this->get("/change-org/{$this->org->id}");
        $response->assertOk();
    }

    public function testChangeRole()
    {
        $response = $this->get("/change-role/{$this->role->id}");
        $response->assertOk();
    }
}
