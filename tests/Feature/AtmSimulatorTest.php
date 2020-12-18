<?php

namespace Tests\Feature;

use App\Models\{AccountBank, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * /atm-simulator
 */
class AtmSimulatorTest extends TestCase
{
    use RefreshDatabase;

    public function testDeposit1000BankNotes()
    {
        // Set
        $user = $this->createUserWithAccountsBank()->load('account_banks');
        $accountBank = $user->account_banks[0];
        $data = [
            "user_id" => $user->id,
            "account_bank_id" => $accountBank->id,
            "account_bank_type_id" => $accountBank->account_bank_type_id,
            "value" => 1000,
        ];

        // Response Body
        $responseBody = [
            "user_id" => $user->id,
            "account_bank_id" => $accountBank->id,
            "account_bank_type_id" => $accountBank->account_bank_type_id,
            "balance" => 1000,
        ];

        // Actions
        $response = $this->postJson("/api/atm-simulator/deposit", $data);

        // Assertions
        $response->assertStatus(200);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }

    public function testDeposit100BankNotesWithCents()
    {
        // Set
        $user = $this->createUserWithAccountsBank()->load('account_banks');
        $accountBank = $user->account_banks[0];
        $data = [
            "user_id" => $user->id,
            "account_bank_id" => $accountBank->id,
            "account_bank_type_id" => $accountBank->account_bank_type_id,
            "value" => 100.85,
        ];

        // Response Body
        $responseBody = [
            "errors" => ["The value must be an integer."]
        ];

        // Actions
        $response = $this->postJson("/api/atm-simulator/deposit", $data);

        // Assertions
        $response->assertStatus(422);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }

    public function testWithDraw150BankNotes()
    {
        // Set
        $user = $this->createUserWithAccountsBank()->load('account_banks');
        $accountBank = $user->account_banks[0];
        $accountBank->update(['balance' => 1000]);
        $data = [
            "user_id" => $user->id,
            "account_bank_id" => $accountBank->id,
            "account_bank_type_id" => $accountBank->account_bank_type_id,
            "value" => 150,
        ];

        // Response Body
        $responseBody = [
            "user_id" => $user->id,
            "account_bank_id" => $accountBank->id,
            "account_bank_type_id" => $accountBank->account_bank_type_id,
            "banknotes_info" => [
              "1 banknotes of 100",
              "1 banknotes of 50"
            ],
            "balance" => 850
        ];

        // Actions
        $response = $this->postJson("/api/atm-simulator/withdraw", $data);

        // Assertions
        $response->assertStatus(200);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }

    public function testWithDraw60BankNotes()
    {
        // Set
        $user = $this->createUserWithAccountsBank()->load('account_banks');
        $accountBank = $user->account_banks[0];
        $accountBank->update(['balance' => 1000]);
        $data = [
            "user_id" => $user->id,
            "account_bank_id" => $accountBank->id,
            "account_bank_type_id" => $accountBank->account_bank_type_id,
            "value" => 60,
        ];

        // Response Body
        $responseBody = [
            "user_id" => $user->id,
            "account_bank_id" => $accountBank->id,
            "account_bank_type_id" => $accountBank->account_bank_type_id,
            "banknotes_info" => [
              "3 banknotes of 20"
            ],
            "balance" => 940
        ];

        // Actions
        $response = $this->postJson("/api/atm-simulator/withdraw", $data);

        // Assertions
        $response->assertStatus(200);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }

    public function testWithDrawInsufficientBalance()
    {
        // Set
        $user = $this->createUserWithAccountsBank()->load('account_banks');
        $accountBank = $user->account_banks[0];
        $accountBank->update(['balance' => 100]);
        $data = [
            "user_id" => $user->id,
            "account_bank_id" => $accountBank->id,
            "account_bank_type_id" => $accountBank->account_bank_type_id,
            "value" => 150,
        ];

        // Response Body
        $responseBody = [
            "errors" => ["Insufficient balance to make the desired withdrawal."]
        ];

        // Actions
        $response = $this->postJson("/api/atm-simulator/withdraw", $data);

        // Assertions
        $response->assertStatus(403);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }

    public function testWithDraw693BankNotes()
    {
        // Set
        $user = $this->createUserWithAccountsBank()->load('account_banks');
        $accountBank = $user->account_banks[0];
        $accountBank->update(['balance' => 1000]);
        $data = [
            "user_id" => $user->id,
            "account_bank_id" => $accountBank->id,
            "account_bank_type_id" => $accountBank->account_bank_type_id,
            "value" => 693,
        ];

        // Response Body
        $responseBody = [
            "errors" => ["Unavailable banknotes for the requested amount."]
        ];

        // Actions
        $response = $this->postJson("/api/atm-simulator/withdraw", $data);

        // Assertions
        $response->assertStatus(403);
        $this->assertEquals(json_encode($responseBody), $response->getContent());
    }

    public function testThreeWithdrawals100BankNotesSimultaneous()
    {
        // Set
        $user = $this->createUserWithAccountsBank()->load('account_banks');
        $accountBank = $user->account_banks[0];
        $accountBank->update(['balance' => 1000]);
        $data = [
            "user_id" => $user->id,
            "account_bank_id" => $accountBank->id,
            "account_bank_type_id" => $accountBank->account_bank_type_id,
            "value" => 100,
        ];

        // Response Body
        $responseBody1 = [
            "user_id" => $user->id,
            "account_bank_id" => $accountBank->id,
            "account_bank_type_id" => $accountBank->account_bank_type_id,
            "banknotes_info" => [
             "1 banknotes of 100"
            ],
            "balance" => 900
        ];

        $responseBody2 = [
            "user_id" => $user->id,
            "account_bank_id" => $accountBank->id,
            "account_bank_type_id" => $accountBank->account_bank_type_id,
            "banknotes_info" => [
              "1 banknotes of 100"
            ],
            "balance" => 800
        ];

        $responseBody3 = [
            "user_id" => $user->id,
            "account_bank_id" => $accountBank->id,
            "account_bank_type_id" => $accountBank->account_bank_type_id,
            "banknotes_info" => [
              "1 banknotes of 100"
            ],
            "balance" => 700
        ];

        // Actions
        $response1 = $this->postJson("/api/atm-simulator/withdraw", $data);
        $response2 = $this->postJson("/api/atm-simulator/withdraw", $data);
        $response3 = $this->postJson("/api/atm-simulator/withdraw", $data);

        // Assertions
        $response1->assertStatus(200);
        $this->assertEquals(json_encode($responseBody1), $response1->getContent());

        $response2->assertStatus(200);
        $this->assertEquals(json_encode($responseBody2), $response2->getContent());

        $response3->assertStatus(200);
        $this->assertEquals(json_encode($responseBody3), $response3->getContent());
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
