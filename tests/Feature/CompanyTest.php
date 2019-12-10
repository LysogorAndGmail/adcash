<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;

use Illuminate\Support\Facades\Auth;

use App\Company;
use App\Country;
use App\Organization;
use App\CompanyStatus;
use App\Role;

class CompanyTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected $company;
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
        $this->role          = factory(Role::class)->create([
            'org_id' => $this->org->id
        ]);
        $this->country       = factory(Country::class)->create();
        $this->company       = factory(Company::class)->create([
            'org_id'     => $this->org->id,
            'country_id' => $this->country->id,
            'status_id'  => $this->companyStatus->id,
            'created_by' => $this->user->id
        ]);

        session(['selected_org_id' => $this->org->id]);
    }

    public function testIndexCompany()
    {
        $response = $this->get("/companies");
        $response->assertOk()
                 ->assertSee('org_id')
                 ->assertSee('country_id')
                 ->assertSee('status_id')
                 ->assertSee('created_by')
                 ->assertSee('name')
                 ->assertSee('reg')
                 ->assertSee('vat')
                 ->assertSee('legal_address')
                 ->assertSee('address')
                 ->assertSee('source');
    }

    public function testShowCompany()
    {
        $response = $this->get("/company/{$this->company->id}/show");
        $response->assertOk()
                 ->assertSee('org_id')
                 ->assertSee('country_id')
                 ->assertSee('status_id')
                 ->assertSee('created_by')
                 ->assertSee('name')
                 ->assertSee('reg')
                 ->assertSee('vat')
                 ->assertSee('legal_address')
                 ->assertSee('address')
                 ->assertSee('source');
    }

    public function testStoreCompany()
    {

        $response = $this->post("/company/store", [
            'name'          => 'test',
            'reg'           => 'test',
            'vat'           => 'test',
            'legal_address' => 'test',
            'address'       => 'test',
            'source'        => 'test',
            'org_id'        => session('selected_org_id'),
            'country_id'    => $this->country->id,
            'status_id'     => $this->companyStatus->id,
            'created_by'    => $this->user->id,
            'logo'          => UploadedFile::fake()->image('logo.jpg')
        ]);

        $response->assertOk();
    }

    public function testUpdateCompany()
    {
        $response = $this->put("/company/{$this->company->id}/update", [
            'name'          => 'test',
            'reg'           => 'test',
            'vat'           => 'test',
            'legal_address' => 'test',
            'address'       => 'test',
            'source'        => 'test',
            'org_id'        => $this->org->id,
            'country_id'    => $this->country->id,
            'status_id'     => $this->companyStatus->id
        ]);
        $response->assertOk();
    }

    public function testDestroyCompany()
    {
        $response = $this->delete("/company/{$this->company->id}/destroy");
        $response->assertOk();
    }

    public function testSearchCompany()
    {
        $response = $this->get("/company/{$this->company->name}/search");
        $response->assertOk()
                 ->assertSee('id')
                 ->assertSee('status')
                 ->assertSee('name')
                 ->assertSee('reg')
                 ->assertSee('phone')
                 ->assertSee('email')
                 ->assertSee('address');
    }
}
