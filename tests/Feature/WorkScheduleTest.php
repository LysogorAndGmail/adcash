<?php

namespace Tests\Feature;

use App\Permission;
use App\Role;
use Illuminate\Support\Facades\Artisan;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Illuminate\Support\Facades\Auth;

use App\WorkSchedule;
use App\Organization;
use App\Company;
use App\Country;
use App\CompanyStatus;

class WorkScheduleTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected $workschedule;
    protected $user;
    protected $org;
    protected $company;
    protected $companyStatus;
    protected $country;

    protected function setUp(): void
    {
        parent::setup();
        $this->authenticate();

        $this->user          = Auth::user();
        $this->org           = factory(Organization::class)->create();
        $this->country       = factory(Country::class)->create();
        $this->companyStatus = factory(CompanyStatus::class)->create([
            'org_id' => $this->org->id
        ]);
        $this->company       = factory(Company::class)->create([
            'org_id'     => $this->org->id,
            'country_id' => $this->country->id,
            'status_id'  => $this->companyStatus->id,
            'created_by' => $this->user->id
        ]);
        $this->workschedule  = factory(WorkSchedule::class)->create([
            'org_id'     => $this->org->id,
            'company_id' => $this->company->id,
            'created_by' => $this->user->id
        ]);

        session(['selected_org_id' => $this->org->id]);
    }

    public function testIndexWorkSchedule()
    {
        $response = $this->get("/workschedules");
        $response->assertOk()
                 ->assertSee('id')
                 ->assertSee('org_id')
                 ->assertSee('company_id')
                 ->assertSee('name')
                 ->assertSee('created_by');
    }

    public function testShowWorkSchedule()
    {
        $response = $this->get("/workschedule/{$this->workschedule->id}/show");
        $response->assertOk()
                 ->assertSee('id')
                 ->assertSee('org_id')
                 ->assertSee('company_id')
                 ->assertSee('name')
                 ->assertSee('created_by');
    }

    public function testStoreWorkSchedule()
    {
        $response = $this->post("/workschedule/store", [
            'company_id' => $this->company->id,
            'name'       => 'test',
        ]);
        $response->assertOk();
    }

    public function testUpdateWorkSchedule()
    {
        $response = $this->put("/workschedule/{$this->workschedule->id}/update", [
            'name' => 'test',
        ]);
        $response->assertOk();
    }

    public function testDestroyWorkSchedule()
    {
        $response = $this->delete("/workschedule/{$this->workschedule->id}/destroy");

        $response->assertOk();
    }
}
