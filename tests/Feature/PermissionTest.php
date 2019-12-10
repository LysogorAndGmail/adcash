<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Illuminate\Support\Facades\Auth;

use App\Permission;

class PermissionTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected $permission;

    protected function setUp(): void
    {
        parent::setup();
        $this->authenticate();
        $this->permission = factory(Permission::class)->create();
    }

    public function testIndexPermission()
    {
        $response = $this->get("/permissions");
        $response->assertOk()
                 ->assertSee('id')
                 ->assertSee('name')
                 ->assertSee('display_name');
    }
}
