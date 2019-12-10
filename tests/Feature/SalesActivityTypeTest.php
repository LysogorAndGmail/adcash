<?php

namespace Tests\Feature;

use App\Organization;
use App\Role;
use App\SalesActivityType;
use Tests\TestCase;
use function factory;

class SalesActivityTypeTest extends TestCase
{
    protected $type;
    protected $org;
    protected $role;

    public function setUp(): void
    {
        parent::setUp();
        $this->authenticate();
        $this->org  = factory(Organization::class)->create();
        $this->role = factory(Role::class)->create([
            'org_id' => $this->org->id
        ]);
        $this->type = factory(SalesActivityType::class)->create([
            'org_id' => $this->org->id,
            'roles'  => $this->role->id
        ]);
    }

    public function testIndex()
    {
        $response = $this->get("/sales-activity-types");
        $response->assertOk();
    }

    public function testStore()
    {
        $response = $this->post("/sales-activity-type/store", [
            'org_id'       => $this->org->id,
            'name'         => $this->type->name,
            'roles'        => $this->type->roles,
            'show_address' => $this->type->show_address
        ]);
        $response->assertOk();
    }

    public function testShow()
    {
        $response = $this->get("/sales-activity-type/{$this->type->id}/show");
        $response->assertOk();
    }

    public function testUpdate()
    {
        $response = $this->put("/sales-activity-type/{$this->type->id}/update", [
            'org_id'       => $this->type->org_id,
            'name'         => $this->type->name,
            'roles'        => $this->type->roles,
            'show_address' => $this->type->show_address
        ]);
        $response->assertOk();
    }

    public function testDestroy()
    {
        $response = $this->delete("/sales-activity-type/{$this->type->id}/destroy");
        $response->assertOk();
    }
}
