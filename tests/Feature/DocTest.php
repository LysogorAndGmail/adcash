<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;

use Illuminate\Support\Facades\Auth;

use App\Doc;
use App\DocFolder;
use App\Company;
use App\Country;
use App\Organization;
use App\CompanyStatus;
use App\Role;

class DocTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected $doc;
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

        $testdoc = UploadedFile::fake()->create('document.pdf', 1024);

        $extension = $testdoc->getClientOriginalExtension();

        $mime = $testdoc->getClientMimeType();

        $size = $testdoc->getClientSize();

        $filename = uniqid() . '.' . $extension;

        $this->doc = factory(Doc::class)->create([
            'company_id' => $this->company->id,
            'folder_id'  => $this->docFolder->id,
            'filename'   => $filename,
            'dbname'     => $testdoc->name,
            'ext'        => $extension,
            'mime'       => $mime,
            'size'       => $size,
            'created_by' => $this->user->id
        ]);
        session(['selected_org_id' => $this->org->id]);
    }

    public function testIndexDoc()
    {
        $response = $this->get("/docs/{$this->docFolder->id}");
        $response->assertOk()
                 ->assertSee('id')
                 ->assertSee('company_id')
                 ->assertSee('folder_id')
                 ->assertSee('name')
                 ->assertSee('filename')
                 ->assertSee('dbname')
                 ->assertSee('ext')
                 ->assertSee('mime')
                 ->assertSee('size');
    }

    public function testShowDoc()
    {
        $response = $this->get("/doc/{$this->doc->id}/show");
        $response->assertOk()
                 ->assertSee('id')
                 ->assertSee('company_id')
                 ->assertSee('name')
                 ->assertSee('parent_id')
                 ->assertSee('created_by');
    }

    public function testStoreDoc()
    {
        $testdoc   = UploadedFile::fake()->create('save.pdf', 1024);

        $response = $this->post("/doc/store", [
            'company_id' => $this->company->id,
            'folder_id'  => $this->docFolder->id,
            'name'       => 'save',
            'files' => array($testdoc),
            'count_files'=> 1
        ]);

        $response->assertOk();
    }

    public function testDestroyDoc()
    {
        $response = $this->delete("/doc/{$this->doc->id}/destroy");
        $response->assertOk();
    }

}


