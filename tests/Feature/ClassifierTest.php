<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Illuminate\Support\Facades\Auth;

use App\Country;
use App\JobTitle;
use App\JobTitleCategory;
use App\Operation;
use App\SubOperation;

class ClassifierTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected $operation;
    protected $subOperation;
    protected $country;
    protected $jobTitle;
    protected $jobTitleCategory;

    protected function setUp(): void
    {
        parent::setup();
        $this->authenticate();
        $this->operation        = factory(Operation::class)->create();
        $this->subOperation     = factory(SubOperation::class)->create(['operation_id' => $this->operation->id]);
        $this->country          = factory(Country::class)->create();
        $this->jobTitleCategory = factory(JobTitleCategory::class)->create();
        $this->jobTitle         = factory(JobTitle::class)->create(['category_id' => $this->jobTitleCategory->id]);
    }

    public function testOperations()
    {
        $response = $this->get("/classifier/operations");
        $response->assertOk()
                 ->assertSee('id')
                 ->assertSee('name')
                 ->assertSee('sub_operations');
    }

    public function testCountries()
    {
        $response = $this->get("/classifier/countries");
        $response->assertOk()
                 ->assertSee('id')
                 ->assertSee('name')
                 ->assertSee('code');
    }

    public function testJobTitles()
    {
        $response = $this->get("/classifier/job-titles");
        $response->assertOk()
                 ->assertSee('id')
                 ->assertSee('name')
                 ->assertSee('category_id');

    }
}
