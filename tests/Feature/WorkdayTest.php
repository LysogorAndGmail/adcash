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
use App\Workforce;
use App\Organization;
use App\Company;
use App\Country;
use App\CompanyStatus;
use App\Workday;
use App\JobTitle;
use App\JobTitleCategory;

class WorkdayTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected $workday;
    protected $workschedule;
    protected $workforce;
    protected $user;
    protected $org;
    protected $company;
    protected $companyStatus;
    protected $country;
    protected $jobTitle;
    protected $jobTitleCategory;

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
        $this->jobTitleCategory = factory(JobTitleCategory::class)->create();
        $this->jobTitle         = factory(JobTitle::class)->create(['category_id' => $this->jobTitleCategory->id]);
        $this->company       = factory(Company::class)->create([
            'org_id'     => $this->org->id,
            'country_id' => $this->country->id,
            'status_id'  => $this->companyStatus->id,
            'created_by' => $this->user->id
        ]);
        $this->workschedule = factory(WorkSchedule::class)->create([
            'org_id'     => $this->org->id,
            'company_id' => $this->company->id,
            'created_by' => $this->user->id
        ]);
        $this->workforce = factory(Workforce::class)->create([
            'org_id'       => $this->org->id,
            'job_title_id' => $this->jobTitle->id,
            'user_id'      => $this->user->id,
            'recruited_by' => $this->user->id,
            'created_by'   => $this->user->id
        ]);
        $this->workday        = factory(Workday::class)->create([
            'work_schedule_id'  => $this->workschedule->id,
            'workforce_id'      => $this->workforce->id,
            'created_by'        => $this->user->id
        ]);

    }

    public function testIndexWorkday()
    {
        $response = $this->get("/workdays/{$this->workschedule->id}");
        $response->assertOk()
                 ->assertSee('id')
                 ->assertSee('work_schedule_id')
                 ->assertSee('workforce_id')
                 ->assertSee('start_date')
                 ->assertSee('end_date')
                 ->assertSee('created_by');
    }

    public function testShowWorkday()
    {
        $response = $this->get("/workday/{$this->workday->id}/show");
        $response->assertOk()
                 ->assertSee('id')
                 ->assertSee('work_schedule_id')
                 ->assertSee('workforce_id')
                 ->assertSee('start_date')
                 ->assertSee('end_date')
                 ->assertSee('created_by');
    }

    public function testStoreWorkday()
    {
        $response = $this->post("/workday/store", [
            'work_schedule_id'  => $this->workschedule->id,
            'workforce_id'      => $this->workforce->id,
            'start_date'        => date('Y-m-d H:i:s'),
            'end_date'          => date('Y-m-d H:i:s'),
            'created_by'        => $this->user->id
        ]);
        $response->assertOk();
    }

    public function testUpdateWorkday()
    {
        $response = $this->put("/workday/{$this->workday->id}/update", [
            'start_date'        => date('Y-m-d H:i:s'),
            'end_date'          => date('Y-m-d H:i:s'),
        ]);
        $response->assertOk();
    }

    public function testDestroyWorkday()
    {
        $response = $this->delete("/workday/{$this->workday->id}/destroy");

        $response->assertOk();
    }
}
