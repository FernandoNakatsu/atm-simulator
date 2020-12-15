<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

/**
 * /user
 */
class UserTest extends TestCase
{
    public function testListUsersTest()
    {
        // Set
        $expectedResult = User::all();

        // Actions
        $response = $this->getJson("/api/user");

        // Assertions
        $response->assertStatus(200);
        $responseBody = [
            'message' => 'Success.',
            'data' => $expectedResult,
        ];

        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }

    public function testSearchUserTest()
    {
        // Set
        $search = "111.111.111-11";
        $searchString = mb_strtolower($search);
        $expectedResult = User::whereRaw("
            lower(fullname) LIKE '%{$searchString}%' OR
            lower(birthdate) LIKE '%{$searchString}%' OR
            lower(cpf) LIKE '%{$searchString}%'
        ")
        ->get();

        // Actions
        $response = $this->getJson("/api/user/{$search}");

        // Assertions
        $response->assertStatus(200);
        $responseBody = [
            'message' => 'Success.',
            'data' => $expectedResult,
        ];

        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }
}
