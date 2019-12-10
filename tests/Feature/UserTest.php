<?php

namespace Tests\Feature;

use App\Organization;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected $user;
    protected $org;

    protected function setUp(): void
    {
        parent::setup();
        $this->authenticate();

        $this->user = factory(User::class)->create();
        $this->org  = factory(Organization::class)->create();
        $this->org->users()->attach($this->user->id);

        session(['selected_org_id' => $this->org->id]);
    }

    public function testGetOrgUsers()
    {
        $response = $this->get("/users");
        $response->assertOk()
                 ->assertSee('fname')
                 ->assertSee('lname')
                 ->assertSee('email');
    }

    public function testShowUser()
    {
        $response = $this->get("/user/{$this->user->id}/show");
        $response->assertOk()
                 ->assertSee('fname')
                 ->assertSee('lname')
                 ->assertSee('email')
                 ->assertSee('country');
    }

    // TODO: needs to be fixed
    public function UpdateUser()
    {
        $username = 'test@test.test';
        $password = 'secret';

        $url = env('ACCOUNT_URL') . "/api/login";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'username=' . $username . '&password=' . $password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $account_data = json_decode($result);

        session(['account_token' => $account_data->access_token]);

        $response = $this->put("/user/{$this->user->id}/update", [
            'fname' => 'test',
            'lname' => 'test',
            'email' => 'test@example.com'
        ]);
        $response->assertOk();
    }

    // TODO: needs to be fixed
    public function DestroyUser()
    {
        $username = 'test@test.test';
        $password = 'secret';

        $url = env('ACCOUNT_URL') . "/api/login";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'username=' . $username . '&password=' . $password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $account_data = json_decode($result);

        session(['account_token' => $account_data->access_token]);

        $response = $this->delete("/user/{$this->user->id}/destroy");
        $response->assertOk();
    }

    // TODO: needs to be fixed
    public function LoginToAccount()
    {
        $username = 'test@test.test';
        $password = 'secret';

        $url = env('ACCOUNT_URL') . "/api/login";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'username=' . $username . '&password=' . $password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $account_data = json_decode($result);

        session(['account_token' => $account_data->access_token]);

        $response = $this->get("/login-to-account");
        $response->assertOk()
                 ->assertSee('url');

    }

}
