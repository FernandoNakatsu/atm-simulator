<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * /user
 */
class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateUserTest()
    {
        // Set
        $data = [
            "fullname" => "João Teste",
            "birthday" => "2000-01-01",
            "cpf" => "111.111.111-11",
        ];

        // Response Body
        $responseBody = ["User created successfully."];

        // Actions
        $response = $this->postJson("/api/user", $data);

        // Assertions
        $response->assertStatus(201);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }

    public function testUpdateUserTest()
    {
        // Set
        $user_id = $this->createUser()->id;
        $data = [
            "user_id" => $user_id,
            "fullname" => "João Teste Updated",
            "birthday" => "2000-02-02",
            "cpf" => "222.222.222-22"
        ];

        // Response Body
        $responseBody = ['User updated successfully.'];
        
        // Actions
        $response = $this->putJson("/api/user", $data);

        // Assertions
        $response->assertStatus(200);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }

    public function testDeleteUserTest()
    {
        // Set
        $user_id = $this->createUser()->id;
        $data = ["user_id" => $user_id];
        $responseBody = ["User deleted successfully."];

        // Actions
        $response = $this->deleteJson("/api/user", $data);

        // Assertions
        $response->assertStatus(200);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }

    public function testSearchUserTest()
    {
        // Set
        $cpf = $this->createUser()->cpf;
        $responseBody = User::with('account_banks','account_banks.account_bank_type')->where("cpf", $cpf)->first();

        // Actions
        $response = $this->getJson("/api/user/{$cpf}");

        // Assertions
        $response->assertStatus(200);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }

    private function createUser()
    {
        return User::create([
            'fullname' => 'João Teste',
            "birthday" => "2000-01-01",
            "cpf" => "111.111.111-11"
        ]);
    }
}
