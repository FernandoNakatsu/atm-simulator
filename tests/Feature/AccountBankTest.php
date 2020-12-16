<?php

namespace Tests\Feature;

use App\Models\BankAccount;
use Tests\TestCase;

/**
 * /account-bank
 */
class AccountBankTest extends TestCase
{
    public function testCreateAccountBankType1Test()
    {
        // Set
        $data = [
            "account_bank_type_id" => 1,
            "user_id" => 1,
        ];
        $responseBody = ["Account Bank created successfully."];

        // Actions
        $response = $this->postJson("/api/account-bank", $data);

        // Assertions
        $response->assertStatus(201);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }

    public function testCreateAccountBankType2Test()
    {
        // Set
        $data = [
            "account_bank_type_id" => 2,
            "user_id" => 1,
        ];
        $responseBody = ["Account Bank created successfully."];

        // Actions
        $response = $this->postJson("/api/account-bank", $data);

        // Assertions
        $response->assertStatus(201);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }

    public function testCreateAccountBankAlreadyExistsTest()
    {
        // Set
        $data = [
            "account_bank_type_id" => 1,
            "user_id" => 1,
        ];
        $responseBody = ["errors" => ["Account Bank already exists for this user."]];

        // Actions
        $response = $this->postJson("/api/account-bank", $data);

        // Assertions
        $response->assertStatus(403);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }

    public function testCreateAccountBankWithoutTypeIdTest()
    {
        // Set
        $data = [
            "user_id" => 1,
        ];
        $responseBody = ["errors" => ["The account bank type id field is required."]];

        // Actions
        $response = $this->postJson("/api/account-bank", $data);

        // Assertions
        $response->assertStatus(422);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }

    public function testCreateAccountBankWithoutUserIdTest()
    {
        // Set
        $data = [
            "account_bank_type_id" => 1,
        ];
        $responseBody = ["errors" => ["The user id field is required."]];

        // Actions
        $response = $this->postJson("/api/account-bank", $data);

        // Assertions
        $response->assertStatus(422);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }
}
