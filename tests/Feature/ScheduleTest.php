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
use App\Workforce;
use App\JobTitleCategory;
use App\JobTitle;

class ScheduleTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected $workschedule;
    protected $user;
    protected $org;
    protected $company;
    protected $companyStatus;
    protected $country;
    protected $jobTitleCategory;
    protected $jobTitle;
    protected $workforce;

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

        $this->jobTitleCategory = factory(JobTitleCategory::class)->create();
        $this->jobTitle         = factory(JobTitle::class)->create(['category_id' => $this->jobTitleCategory->id]);
        $this->workforce        = factory(Workforce::class)->create([
            'org_id'       => $this->org->id,
            'job_title_id' => $this->jobTitle->id,
            'user_id'      => $this->user->id,
            'recruited_by' => $this->user->id,
            'created_by'   => $this->user->id
        ]);

        $workSchedule = WorkSchedule::find($this->workschedule->id);
        $workSchedule->workforces()->attach($this->workforce->id);

        session(['selected_org_id' => $this->org->id]);
    }

    public function testIndexSchedule()
    {
        $response = $this->get("/schedule/{$this->workschedule->id}/workforces");
        $response->assertOk()
                 ->assertSee('id')
                 ->assertSee('org_id')
                 ->assertSee('company_id')
                 ->assertSee('name')
                 ->assertSee('workforces')
                 ->assertSee('created_by');
    }

    public function testAddScheduleWorkforce()
    {
        $workforceNew = factory(Workforce::class)->create([
            'org_id'       => $this->org->id,
            'job_title_id' => $this->jobTitle->id,
            'user_id'      => $this->user->id,
            'recruited_by' => $this->user->id,
            'created_by'   => $this->user->id
        ]);

        $response = $this->post("/schedule/add-workforce", [
            'work_schedule_id' => $this->workschedule->id,
            'workforces'     => [$workforceNew->id],
        ]);

        $response->assertOk();
    }

    public function testDestroyScheduleWorkforce()
    {
        $response = $this->delete("/schedule/{$this->workschedule->id}/{$this->workforce->id}/destroy-workforce");

        $response->assertOk();
    }
}
