<?php

namespace Tests\Feature;

use App\UserSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserSettingsTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;
    
    protected $user;
    protected $userSettings;

    public function setUp(): void
    {
        parent::setUp();
        $this->authenticate();

        $this->user         = Auth::user();
        $this->userSettings = factory(UserSettings::class)->create([
            'user_id' => $this->user->id
        ]);
    }

    public function testShowUserSettings()
    {
        $response = $this->get("/user/settings/{$this->userSettings->id}/show");
        $response->assertOk();
    }

    public function testUpdateUserSettings()
    {
        $response = $this->put("/user/settings/{$this->userSettings->id}/update", [
            'zero_sales_act_companies' => 6
        ]);
        $response->assertOk();
    }
}
