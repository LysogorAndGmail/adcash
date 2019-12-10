<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Illuminate\Support\Facades\Auth;

use App\JobTitleCategory;

class JobTitleCategoryTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected $jobTitleCategory;

    protected function setUp(): void
    {
        parent::setup();
        $this->authenticate();
        $this->jobTitleCategory = factory(JobTitleCategory::class)->create();
    }

    public function testIndexJobTitleCategory()
    {
        $response = $this->get("/admin/job-title-categories");
        $response->assertOk()
                 ->assertSee('name');
    }

    public function testShowJobTitleCategory()
    {
        $response = $this->get("/admin/job-title-category/{$this->jobTitleCategory->id}/show");
        $response->assertOk()
                 ->assertSee('name');
    }

    public function testStoreJobTitleCategory()
    {
        $response = $this->post("/admin/job-title-category/store", [
            'name' => 'test',
        ]);
        $response->assertOk();
    }

    public function testUpdateJobTitleCategory()
    {
        $response = $this->put("/admin/job-title-category/{$this->jobTitleCategory->id}/update", [
            'name' => 'test',
        ]);
        $response->assertOk();
    }

    public function testDestroyJobTitleCategory()
    {
        $response = $this->delete("/admin/job-title-category/{$this->jobTitleCategory->id}/destroy");
        $response->assertOk();
    }
}
