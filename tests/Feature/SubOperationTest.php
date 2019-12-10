<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Illuminate\Support\Facades\Auth;

use App\Operation;
use App\SubOperation;

class SubOperationTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected $operation;
    protected $subOperation;

    protected function setUp(): void
    {
        parent::setup();
        $this->authenticate();
        $this->operation    = factory(Operation::class)->create();
        $this->subOperation = factory(SubOperation::class)->create(['operation_id' => $this->operation->id]);
    }

    public function testIndexSubOperation()
    {
        $response = $this->get("/admin/sub-operations");
        $response->assertOk()
                 ->assertSee('name');
    }

    public function testShowSubOperation()
    {
        $response = $this->get("/admin/sub-operation/{$this->subOperation->id}/show");
        $response->assertOk();
    }

    public function testStoreSubOperation()
    {
        $response = $this->post("/admin/sub-operation/store", [
            'name'         => 'test',
            'operation_id' => $this->operation->id,

        ]);
        $response->assertOk();
    }

    public function testUpdateSubOperation()
    {
        $response = $this->put("/admin/sub-operation/{$this->subOperation->id}/update", [
            'name'         => 'test',
            'operation_id' => $this->operation->id,
        ]);
        $response->assertOk();
    }

    public function testDestroySubOperation()
    {
        $response = $this->delete("/admin/sub-operation/{$this->subOperation->id}/destroy");
        $response->assertOk();
    }
}
