<?php

namespace Tests\Feature;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

class LoginTest extends TestCase
{
    public function testExample()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    // TODO: needs to be fixed
    public function LoginAccount()
    {
        $username = 'test@test.test';
        $password = 'secret';

        $url                  = env('ACCOUNT_URL') . "/api/login";
        $account_login_result = $this->checkAccountLogin($url, $username, $password);

        if ( ! empty($account_login_result)) {
            $account_data = json_decode($account_login_result);
            $response     = $this->get("/api/token/validate?access_token=" . $account_data->access_token);
            $this->assertEquals(302, $response->status());
        }
    }

    function checkAccountLogin($url, $username, $password)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'username=' . $username . '&password=' . $password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
