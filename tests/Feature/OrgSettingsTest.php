<?php

namespace Tests\Feature;

use App\Organization;
use App\OrgSettings;
use App\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use function factory;

class OrgSettingsTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;
    
    protected $user;
    protected $org;
    protected $orgSettings;
    
    public function setUp(): void
    {
        parent::setUp();
        $this->authenticate();
        
        $this->user = Auth::user();
        $this->org = factory(Organization::class)->create();
        $this->org->users()->attach($this->user->id);
        $this->role = factory(Role::class)->create(['org_id' => $this->org->id]);
        $this->user->roles()->attach($this->role->id, [
            'org_id' => $this->org->id
        ]);
        
        $this->orgSettings = factory(OrgSettings::class)->create(
            [
                'org_id' => $this->org->id
            ]
        );
    }
    
    public function testIndex()
    {
        $response = $this->get("/org/settings/{{$this->orgSettings->id}}/show");
        $response->assertOk();
    }
    
    public function testUpdate()
    {
        $response = $this->put("/org/settings/{$this->orgSettings->id}/update", [
            'status_length_days' => $this->orgSettings->status_length_days,
        ]);
        $response->assertOk();
    }
}
