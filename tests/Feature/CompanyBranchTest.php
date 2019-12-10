<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Illuminate\Support\Facades\Auth;

use App\CompanyBranch;
use App\Company;
use App\Country;
use App\Organization;
use App\CompanyStatus;

class CompanyBranchTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected $company;
    protected $companyBranch;
    protected $user;
    protected $org;
    protected $country;
    protected $companyStatus;

    protected function setUp(): void
    {
        parent::setup();
        $this->authenticate();
        $this->user          = Auth::user();
        $this->org           = factory(Organization::class)->create();
        $this->companyStatus = factory(CompanyStatus::class)->create([
            'org_id' => $this->org->id
        ]);
        $this->country       = factory(Country::class)->create();
        $this->company       = factory(Company::class)->create([
            'org_id'     => $this->org->id,
            'country_id' => $this->country->id,
            'status_id'  => $this->companyStatus->id,
            'created_by' => $this->user->id
        ]);
        $this->companyBranch = factory(CompanyBranch::class)->create([
            'company_id' => $this->company->id,
            'created_by' => $this->user->id
        ]);
        session(['selected_org_id' => $this->org->id]);
    }

    public function testShowCompanyBranch()
    {
        $response = $this->get("/company-branch/{$this->companyBranch->id}/show");
        $response->assertOk()
                 ->assertSee('company_id')
                 ->assertSee('name')
                 ->assertSee('address')
                 ->assertSee('phone')
                 ->assertSee('email')
                 ->assertSee('color')
                 ->assertSee('created_by');
    }

    public function testStoreCompanyBranch()
    {
        $response = $this->post("/company-branch/store", [
            'company_id' => $this->company->id,
            'name'       => 'test',
            'address'    => 'test',
            'phone'      => 'test',
            'email'      => 'test',
            'color'      => 'test',
            'created_by' => $this->user->id

        ]);
        $response->assertOk();
    }

    public function testUpdateCompanyBranch()
    {
        $response = $this->put("/company-branch/{$this->companyBranch->id}/update", [
            'company_id' => $this->company->id,
            'name'       => 'test',
            'address'    => 'test',
            'phone'      => 'test',
            'email'      => 'test',
            'color'      => 'test'
        ]);
        $response->assertOk();
    }

    public function testDestroyCompanyBranch()
    {
        $response = $this->delete("/company-branch/{$this->companyBranch->id}/destroy");
        $response->assertOk();
    }
}
