<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

/**
 * /user
 */
class UserTest extends TestCase
{
    public function testCreateUserTest()
    {
        // Set
        $data = [
            "fullname" => "João Teste",
            "birthdate" => "2000-01-01",
            "cpf" => "111.111.111-11"
        ];
        $responseBody = ['User created successfully'];

        // Actions
        $response = $this->postJson("/api/user", $data);

        // Assertions
        $response->assertStatus(201);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }

    public function testUpdateUserTest()
    {
        // Set
        $user = User::first();
        $data = [
            "user_id" => $user->id,
            "fullname" => "João Teste Updated",
            "birthdate" => "2000-02-02",
            "cpf" => "222.222.222-22"
        ];
        $responseBody = ['User updated successfully'];

        // Actions
        $response = $this->putJson("/api/user", $data);

        // Assertions
        $response->assertStatus(200);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }

    public function testDeleteUserTest()
    {
        // Set
        $user = User::first();
        $data = ["user_id" => $user->id];
        $responseBody = ['User deleted successfully'];

        // Actions
        $response = $this->deleteJson("/api/user", $data);

        // Assertions
        $response->assertStatus(200);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }

    public function testSearchUserTest()
    {
        // Set
        $search = "João Teste";
        $searchString = mb_strtolower($search);
        $expectedResult = User::whereRaw("lower(fullname) LIKE '%{$searchString}%'")->get();
        $responseBody = [
            'message' => 'Success.',
            'data' => $expectedResult,
        ];

        // Actions
        $response = $this->getJson("/api/user/{$search}");

        // Assertions
        $response->assertStatus(200);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }
}
