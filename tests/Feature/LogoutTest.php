<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function testsUserIsLoggedOutProperly(){
        $user = factory(User::class)->create(['email'=>'user@test.com']);
        $token = $user->generateToken();
        $headers = ['Authorization'=>"Bearer $token"];

        $this->json('get','/api/articles',[],$headers)->assertStatus(200);
        $this->json('post','/api/logout',[],$headers)->assertStatus(200);

        $user = User::find($user->id);

        $this->assertEquals(null, $user->api_token);
    }

    public function testUserWithNullToken(){
        //simulating login
        $user = factory(User::class)->create(['email'=>'user@test.com']);
        $token = $user->generateToken();
        $headers = ['Authorization'=>"Bearer $token"];

        //simulating logout
        $user->api_token = null;
        $user->save();

        $this->json('get', '/api/articles',[],$headers)
            ->assertStatus(401);
    }
}
