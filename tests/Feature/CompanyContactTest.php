<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Illuminate\Support\Facades\Auth;

use App\CompanyContact;
use App\CompanyBranch;
use App\Company;
use App\Country;
use App\Organization;
use App\CompanyStatus;

class CompanyContactTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected $company;
    protected $companyContact;
    protected $branch;
    protected $user;
    protected $org;
    protected $country;
    protected $companyStatus;
    protected $branchContact;

    protected function setUp(): void
    {
        parent::setup();
        $this->authenticate();
        $this->user           = Auth::user();
        $this->org            = factory(Organization::class)->create();
        $this->companyStatus  = factory(CompanyStatus::class)->create([
            'org_id' => $this->org->id
        ]);
        $this->country        = factory(Country::class)->create();
        $this->company        = factory(Company::class)->create([
            'org_id'     => $this->org->id,
            'country_id' => $this->country->id,
            'status_id'  => $this->companyStatus->id,
            'created_by' => $this->user->id
        ]);
        $this->branch         = factory(CompanyBranch::class)->create([
            'company_id' => $this->company->id,
            'created_by' => $this->user->id
        ]);
        $this->companyContact = factory(CompanyContact::class)->create([
            'company_id' => $this->company->id,
            'created_by' => $this->user->id
        ]);
        $this->branchContact  = factory(CompanyContact::class)->create([
            'company_id' => $this->company->id,
            'branch_id'  => $this->branch->id,
            'created_by' => $this->user->id
        ]);
        session(['selected_org_id' => $this->org->id]);
    }

    public function testCompanyContacts()
    {
        $response = $this->get("/company-contacts/{$this->company->id}");
        $response->assertOk()
                 ->assertSee('fname')
                 ->assertSee('lname')
                 ->assertSee('phone')
                 ->assertSee('email')
                 ->assertSee('job_title')
                 ->assertSee('created_by');
    }

    public function testCompanyBranchContacts()
    {
        $response = $this->get("/company-contacts/{$this->company->id}/branch/{$this->branch->id}");
        $response->assertOk()
                 ->assertSee('fname')
                 ->assertSee('lname')
                 ->assertSee('phone')
                 ->assertSee('email')
                 ->assertSee('job_title')
                 ->assertSee('created_by');
    }

    public function testShowCompanyContact()
    {
        $response = $this->get("/company-contact/{$this->companyContact->id}/show");
        $response->assertOk()
                 ->assertSee('company_id')
                 ->assertSee('fname')
                 ->assertSee('lname')
                 ->assertSee('phone')
                 ->assertSee('email')
                 ->assertSee('job_title')
                 ->assertSee('branch_id')
                 ->assertSee('created_by');
    }

    public function testStoreCompanyContact()
    {
        $response = $this->post("/company-contact/store", [
            'company_id' => $this->company->id,
            'fname'      => 'test',
            'lname'      => 'test',
            'phone'      => 'test',
            'email'      => 'test',
            'job_title'  => 'test',
            'created_by' => $this->user->id

        ]);
        $response->assertOk();
    }

    public function testStoreCompanyBranchContact()
    {
        $response = $this->post("/company-contact/store", [
            'branch'     => $this->branch->id,
            'company_id' => $this->company->id,
            'fname'      => 'test',
            'lname'      => 'test',
            'phone'      => 'test',
            'email'      => 'test',
            'job_title'  => 'test',
            'created_by' => $this->user->id

        ]);
        $response->assertOk();
    }

    public function testUpdateCompanyContact()
    {
        $response = $this->put("/company-contact/{$this->companyContact->id}/update", [
            'fname'     => 'test',
            'lname'     => 'test',
            'phone'     => 'test',
            'email'     => 'test',
            'job_title' => 'test',
        ]);
        $response->assertOk();
    }

    public function testDestroyCompanyContact()
    {
        $response = $this->delete("/company-contact/{$this->companyContact->id}/destroy");
        $response->assertOk();
    }
}
