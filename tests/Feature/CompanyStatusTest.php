<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Illuminate\Support\Facades\Auth;

use App\CompanyStatus;
use App\Organization;
use App\User;

class CompanyStatusTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected $status;
    protected $org;

    protected function setUp(): void
    {
        parent::setup();

        $this->authenticate();
        $this->org    = factory(Organization::class)->create();
        $this->status = factory(CompanyStatus::class)->create([
            'org_id' => $this->org->id
        ]);

        session(['selected_org_id' => $this->org->id]);
    }

    public function testIndexCompanyStatus()
    {
        $response = $this->get("/company-statuses");
        $response->assertOk()
                 ->assertSee('name');
    }

    public function testShowCompanyStatus()
    {
        $response = $this->get("/company-status/{$this->status->id}/show");
        $response->assertOk()
                 ->assertSee('name');
    }

    public function testStoreCompanyStatus()
    {
//        $this->session(['selected_org_id' => $this->org->id]);

        $response = $this->post("/company-status/store", [
            'name'   => 'Active',
            'color'  => '#dfdfdf',
            'reason' => 'just because',
        ]);
        $response->assertOk();
    }

    public function testUpdateCompanyStatus()
    {
        $response = $this->put("/company-status/{$this->status->id}/update", [
            'name'   => $this->status->name,
            'color'  => $this->status->color,
            'reason' => $this->status->reason,
        ]);
        $response->assertOk();
    }

    public function testDestroyCompanyStatus()
    {
        $response = $this->delete("/company-status/{$this->status->id}/destroy");
        $response->assertOk();
    }
}
