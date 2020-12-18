<?php

namespace Tests\Feature;

use App\Models\{AccountBank, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * /account-bank
 */
class AccountBankTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateAccountBankType1()
    {
        // Set
        $user_id = $this->createUser()->id;
        $data = [
            "account_bank_type_id" => 1,
            "user_id" => $user_id,
        ];

        // Response Body
        $responseBody = ["Account Bank created successfully."];

        // Actions
        $response = $this->postJson("/api/account-bank", $data);

        // Assertions
        $response->assertStatus(201);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }

    public function testCreateAccountBankType2()
    {
        // Set
        $user_id = $this->createUser()->id;
        $data = [
            "account_bank_type_id" => 2,
            "user_id" => $user_id,
        ];

        // Response Body
        $responseBody = ["Account Bank created successfully."];

        // Actions
        $response = $this->postJson("/api/account-bank", $data);

        // Assertions
        $response->assertStatus(201);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }

    public function testCreateAccountBankAlreadyExists()
    {
        // Set
        $user = $this->createUserWithAccountsBank();
        $data = [
            "account_bank_type_id" => 1,
            "user_id" => $user->id,
        ];

        // Response Body
        $responseBody = ["errors" => ["Account Bank already exists for this user."]];

        // Actions
        $response = $this->postJson("/api/account-bank", $data);

        // Assertions
        $response->assertStatus(403);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }

    public function testCreateAccountBankWithoutTypeId()
    {
        // Set
        $data = ["user_id" => 1];

        // Response Body
        $responseBody = ["errors" => ["The account bank type id field is required."]];

        // Actions
        $response = $this->postJson("/api/account-bank", $data);

        // Assertions
        $response->assertStatus(422);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }

    public function testCreateAccountBankWithoutUserId()
    {
        // Set
        $data = ["account_bank_type_id" => 1];

        // Response Body
        $responseBody = ["errors" => ["The user id field is required."]];

        // Actions
        $response = $this->postJson("/api/account-bank", $data);

        // Assertions
        $response->assertStatus(422);
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

    private function createUserWithAccountsBank()
    {
        $user = User::create([
            'fullname' => 'João Teste',
            "birthday" => "2000-01-01",
            "cpf" => "111.111.111-11"
        ]);
        
        AccountBank::create([
            "account_bank_type_id" => 1,
            "user_id" => $user->id,
        ])->create([
            "account_bank_type_id" => 2,
            "user_id" => $user->id,
        ]);

        return $user;
    }
}
