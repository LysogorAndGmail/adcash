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

use Carbon\Carbon;

use App\Workforce;
use App\Organization;
use App\JobTitleCategory;
use App\JobTitle;


class WorkforceTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected $workforce;
    protected $user;
    protected $org;
    protected $jobTitleCategory;
    protected $jobTitle;

    protected function setUp(): void
    {
        parent::setup();
        $this->authenticate();
        $this->user             = Auth::user();
        $this->org              = factory(Organization::class)->create();
        $this->jobTitleCategory = factory(JobTitleCategory::class)->create();
        $this->jobTitle         = factory(JobTitle::class)->create(['category_id' => $this->jobTitleCategory->id]);
        $this->workforce        = factory(Workforce::class)->create([
            'org_id'       => $this->org->id,
            'job_title_id' => $this->jobTitle->id,
            'user_id'      => $this->user->id,
            'recruited_by' => $this->user->id,
            'created_by'   => $this->user->id
        ]);
        session(['selected_org_id' => $this->org->id]);
    }

    public function testIndexWorkforce()
    {
        $response = $this->get("/workforces");
        $response->assertOk()
                 ->assertSee('org_id')
                 ->assertSee('job_title_id')
                 ->assertSee('user_id')
                 ->assertSee('fname')
                 ->assertSee('lname')
                 ->assertSee('recruited_by')
                 ->assertSee('created_by');
    }

    public function testShowWorkforce()
    {
        $response = $this->get("/workforce/{$this->workforce->id}/show");
        $response->assertOk()
                 ->assertSee('org_id')
                 ->assertSee('job_title_id')
                 ->assertSee('user_id')
                 ->assertSee('fname')
                 ->assertSee('lname')
                 ->assertSee('recruited_by')
                 ->assertSee('created_by');
    }


    public function testStoreWorkforce()
    {
        $response = $this->post("/workforce/store", [
            'job_title_id' => $this->jobTitle->id,
            'user_id'      => $this->user->id,
            'fname'        => 'test',
            'lname'        => 'test',
            'gender'       => ($this->workforce->gender) ? 1 : 0,
            'dob'          => Carbon::parse($this->workforce->dob),
            'is_personnel' => ($this->workforce->is_personnel) ? 1 : 0,
            'phone'        => $this->workforce->phone,
            'email'        => $this->workforce->email,
            'recruited_by' => $this->user->id,
            'created_by'   => $this->user->id
        ]);

        $response->assertOk();
    }

    public function testUpdateWorkforce()
    {
        $response = $this->put("/workforce/{$this->workforce->id}/update", [
            'job_title_id' => $this->jobTitle->id,
            'user_id'      => $this->user->id,
            'fname'        => 'test',
            'lname'        => 'test',
            'gender'       => $this->workforce->gender,
            'dob'          => $this->workforce->dob,
            'is_personnel' => $this->workforce->is_personnel,
            'phone'        => $this->workforce->phone,
            'email'        => $this->workforce->email,
            'recruited_by' => $this->user->id
        ]);
        $response->assertOk();
    }

    public function testDestroyWorkforce()
    {
        $response = $this->delete("/workforce/{$this->workforce->id}/destroy");
        $response->assertOk();
    }
}
