<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Illuminate\Support\Facades\Auth;

use App\JobTitle;
use App\JobTitleCategory;

class JobTitleTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected $jobTitle;
    protected $jobTitleCategory;

    protected function setUp(): void
    {
        parent::setup();
        $this->authenticate();
        $this->jobTitleCategory = factory(JobTitleCategory::class)->create();
        $this->jobTitle         = factory(JobTitle::class)->create(['category_id' => $this->jobTitleCategory->id]);
    }

    public function testIndexJobTitle()
    {
        $response = $this->get("/admin/job-titles");
        $response->assertOk()
                 ->assertSee('name');
    }

    public function testShowJobTitle()
    {
        $response = $this->get("/admin/job-title/{$this->jobTitle->id}/show");
        $response->assertOk();
    }

    public function testStoreJobTitle()
    {
        $response = $this->post("/admin/job-title/store", [
            'name'        => 'test',
            'category_id' => $this->jobTitleCategory->id,

        ]);
        $response->assertOk();
    }

    public function testUpdateJobTitle()
    {
        $response = $this->put("/admin/job-title/{$this->jobTitle->id}/update", [
            'name'        => 'test',
            'category_id' => $this->jobTitleCategory->id,
        ]);

        $response->assertOk();
    }

    public function testDestroyJobTitle()
    {
        $response = $this->delete("/admin/job-title/{$this->jobTitle->id}/destroy");

        $response->assertOk();
    }
}
