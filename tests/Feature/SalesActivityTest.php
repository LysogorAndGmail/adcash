<?php

namespace Tests\Feature;

use App\Company;
use App\CompanyStatus;
use App\Country;
use App\Organization;
use App\Role;
use App\SalesActivity;
use App\SalesActivityType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use function factory;


class SalesActivityTest extends TestCase
{
    use WithoutMiddleware;
    use RefreshDatabase;
    
    protected $user;
    protected $org;
    protected $country;
    protected $companyStatus;
    protected $company;
    protected $salesActivityType;
    protected $salesActivity;
    protected $role;
    
    public function setUp(): void
    {
        parent::setUp();
        $this->authenticate();
        
        $this->user = Auth::user();
        $this->org  = factory(Organization::class)->create();
        $this->org->users()->attach($this->user->id);
        $this->role = factory(Role::class)->create(['org_id' => $this->org->id]);
        $this->user->roles()->attach($this->role->id, [
            'org_id' => $this->org->id
        ]);
        
        $this->country       = factory(Country::class)->create();
        $this->companyStatus = factory(CompanyStatus::class)->create([
            'org_id' => $this->org->id
        ]);
        
        $this->company = factory(Company::class)->create([
            'org_id' => $this->org->id,
            'country_id' => $this->country->id,
            'status_id' => $this->companyStatus->id,
            'created_by' => Auth::id()
        ]);
        
        $this->salesActivityType = factory(SalesActivityType::class)->create([
            'org_id' => $this->company->org_id
        ]);
        
        $this->salesActivity = factory(SalesActivity::class)->create([
            'type_id' => $this->salesActivityType->id,
            'company_id' => $this->company->id,
            'created_by' => Auth::id()
        ]);
    }
    
    public function testIndex()
    {
        $response = $this->get("/sales-activity/{$this->company->id}/all");
        $response->assertOk();
    }
    
    public function testStore()
    {
        $response = $this->post("/sales-activity/{$this->company->id}/store", [
            'company_id' => $this->company->id,
            'type' => $this->salesActivityType->id,
            'start_date' => $this->salesActivity->start_date,
            'end_date' => $this->salesActivity->end_date,
            'address' => $this->salesActivity->address,
            'info' => $this->salesActivity->info,
            'result' => $this->salesActivity->result,
            'outcome' => $this->salesActivity->outcome,
            'created_by' => Auth::id(),
        ]);
        
        $response->json();
        $response->assertOk();
    }
    
    public function testShow()
    {
        $response = $this->get("/sales-activity/{$this->salesActivity->id}/show");
        $response->assertOk();
    }
    
    public function testUpdate()
    {
        $response = $this->put("/sales-activity/{$this->salesActivity->id}/update", [
            $this->salesActivity,
            'type_id' => $this->salesActivity->type_id,
            'start_date' => $this->salesActivity->start_date,
            'end_date' => $this->salesActivity->end_date,
            'address' => $this->salesActivity->address,
            'info' => $this->salesActivity->info,
            'result' => $this->salesActivity->result,
            'outcome' => $this->salesActivity->outcome,
            'created_by' => $this->salesActivity->created_by
        ]);
        $response->json();
        $response->assertOk();
    }
    
    public function testDestroy()
    {
        $response = $this->delete("/sales-activity/{$this->salesActivity->id}/destroy");
        $response->json();
        $response->assertOk();
    }
}
