<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Illuminate\Support\Facades\Auth;

use App\Operation;

class OperationTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected $operation;

    protected function setUp(): void
    {
        parent::setup();
        $this->authenticate();
        $this->operation = factory(Operation::class)->create();
    }

    public function testIndexOperation()
    {
        $response = $this->get("/admin/operations");
        $response->assertOk()
                 ->assertSee('name');
    }

    public function testShowOperation()
    {
        $response = $this->get("/admin/operation/{$this->operation->id}/show");
        $response->assertOk()
                 ->assertSee('name');
    }

    public function testStoreOperation()
    {
        $response = $this->post("/admin/operation/store", [
            'name' => 'test',

        ]);
        $response->assertOk();
    }

    public function testUpdateOperation()
    {
        $response = $this->put("/admin/operation/{$this->operation->id}/update", [
            'name' => 'test'
        ]);
        $response->assertOk();
    }

    public function testDestroyOperation()
    {
        $response = $this->delete("/admin/operation/{$this->operation->id}/destroy");
        $response->assertOk();
    }
}
