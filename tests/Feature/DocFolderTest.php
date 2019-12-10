<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Illuminate\Support\Facades\Auth;

use App\DocFolder;
use App\Company;
use App\Country;
use App\Organization;
use App\CompanyStatus;
use App\Role;

class DocFolderTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected $docFolder;
    protected $user;
    protected $company;
    protected $org;
    protected $country;
    protected $companyStatus;
    protected $role;

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
        $this->docFolder     = factory(DocFolder::class)->create([
            'company_id' => $this->company->id,
            'created_by' => $this->user->id
        ]);
        session(['selected_org_id' => $this->org->id]);
    }

    public function testIndexDocFolder()
    {
        $response = $this->get("/docfolders/{$this->company->id}");
        $response->assertOk()
                 ->assertSee('id')
                 ->assertSee('company_id')
                 ->assertSee('name')
                 ->assertSee('parent_id')
                 ->assertSee('created_by');
    }

    public function testShowDocFolder()
    {
        $response = $this->get("/docfolder/{$this->docFolder->id}/show");
        $response->assertOk()
                 ->assertSee('id')
                 ->assertSee('company_id')
                 ->assertSee('name')
                 ->assertSee('parent_id')
                 ->assertSee('created_by');
    }

    public function testStoreDocFolder()
    {
        $parentDocFolder = factory(DocFolder::class)->create([
            'company_id' => $this->company->id,
            'created_by' => $this->user->id
        ]);

        $response = $this->post("/docfolder/store", [
            'company_id' => $this->company->id,
            'name'       => 'test',
            'parent_id'  => $parentDocFolder->id,
            'created_by' => $this->user->id
        ]);

        $response->assertOk();
    }

    public function testUpdateDocFolder()
    {
        $response = $this->put("/docfolder/{$this->docFolder->id}/update", [
            'name' => 'test',
        ]);
        $response->assertOk();
    }

    public function testDestroyDocFolder()
    {
        $response = $this->delete("/docfolder/{$this->docFolder->id}/destroy");
        $response->assertOk();
    }
}
