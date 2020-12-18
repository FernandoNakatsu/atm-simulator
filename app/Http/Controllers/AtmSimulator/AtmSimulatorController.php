<?php

namespace App\Http\Controllers\AtmSimulator;

use DB;
use App\Http\Controllers\Controller;
use App\Models\{AccountBank,BankNote};
use Illuminate\Http\Request;

class AtmSimulatorController extends Controller
{
    public function withdraw(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'account_bank_id' => 'required|integer',
            'account_bank_type_id' => 'required|integer|between:1,2',
            'value' => 'required|integer|min:20'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        // Begin the transaction
        DB::beginTransaction();

        $accountBank = AccountBank::where([
            'id'=> $request->account_bank_id,
            'account_bank_type_id' => $request->account_bank_type_id,
            'user_id' => $request->user_id
        ])
        ->lockForUpdate()
        ->first();

        if (!$accountBank) {
            // Roll back the transaction
            DB::rollBack();
            return response()->json(["errors" => ["Account Bank not found."]], 404);
        } else {
            if ($request->withdraw_value > $accountBank->balance) {
                // Roll back the transaction
                DB::rollBack();
                return response()->json(["errors" => ["Insufficient balance to make the desired withdrawal."]], 403);
            } else {
                $withdraw_value = $request->value;
                $bankNotes = BankNote::all()->sortByDesc('value')->pluck('value')->toArray();
                $lowestBankNote = min($bankNotes);
                $amountBankNotes = array();
                foreach ($bankNotes as $i => $bn) {
                    $countBankNotes = 0;                  
                    while (
                        $bn <= $withdraw_value &&  // Valor de saque for maior ou igual a nota atual
                        (
                            count($bankNotes) == $i+1 || // Ser a nota de menor valor
                            $withdraw_value % $bn == 0 || // O resto da divisão ser igual a ZERO
                            $withdraw_value % $bn >= $bankNotes[$i+1] // O resto da divisão ser maior ou igual que a próxima nota
                        )
                    ) {
                        if ($withdraw_value < $lowestBankNote) {
                            break;
                        }

                        $withdraw_value -= $bn;
                        $countBankNotes++;
                    }

                    if ($withdraw_value < $lowestBankNote && $withdraw_value != 0) {
                        // Roll back the transaction
                        DB::rollBack();
                        return response()->json(["errors" => ["Unavailable banknotes for the requested amount."]], 403);
                    }

                    if ($countBankNotes > 0) {
                        $amountBankNotes[$bn] = $countBankNotes;
                    }
                }

                $accountBank->balance -= intval($request->value);
                $accountBank->save();

                // Commit the transaction
                DB::commit();

                return response()->json([
                    'user_id' => $accountBank->user_id,
                    'account_bank_id' => $accountBank->id,
                    'account_bank_type_id' => $accountBank->account_bank_type_id,
                    'banknotes_info' => $this->messageAmountBankNotes($amountBankNotes),
                    'balance' => $accountBank->balance,
                ], 200); 
            }
        }
    }

    public function deposit(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'account_bank_id' => 'required|integer',
            'account_bank_type_id' => 'required|integer|between:1,2',
            'value' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        // Begin the transaction
        DB::beginTransaction();

        $accountBank = AccountBank::where([
            'id'=> $request->account_bank_id,
            'account_bank_type_id' => $request->account_bank_type_id,
            'user_id' => $request->user_id
        ])
        ->lockForUpdate()
        ->first();

        if (!$accountBank) {
            // Roll back the transaction
            DB::rollBack();
            return response()->json(["errors" => ["Account Bank not found."]], 404);
        } else {
            $accountBank->balance += intval($request->value);
            $accountBank->save();

            // Commit the transaction
            DB::commit();
            return response()->json([
                'user_id' => $accountBank->user_id,
                'account_bank_id' => $accountBank->id,
                'account_bank_type_id' => $accountBank->account_bank_type_id,
                'balance' => $accountBank->balance
            ], 200); 
        }
    }

    private function messageAmountBankNotes($amountBankNotes)
    {   
        $message = array();
        foreach ($amountBankNotes as $bankNote => $amount) {
            $message[] = "{$amount} banknotes of {$bankNote}";
        }
        return $message;
    }
}
