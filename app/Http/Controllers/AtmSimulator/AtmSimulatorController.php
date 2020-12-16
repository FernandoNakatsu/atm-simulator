<?php

namespace App\Http\Controllers\AtmSimulator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{AccountBank,BankNote};

class AtmSimulatorController extends Controller
{
    public function withdraw(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'account_bank_id' => 'required|integer',
            'account_bank_type_id' => 'required|integer|between:1,2',
            'user_id' => 'required|integer',
            'value' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        try {
            $accountBank = AccountBank::where([
                'id'=> $request->account_bank_id,
                'account_bank_type_id' => $request->account_bank_type_id,
                'user_id' => $request->user_id
            ])
            ->first();

            if (!$accountBank) {
                return response()->json(['Account Bank not found'], 404);
            } else {
                if ($request->withdraw_value > $accountBank->balance) {
                    return response()->json(['Insufficient balance to make the desired withdrawal'], 200);
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
                            return response()->json(
                                [
                                    'message' => 'Error.',
                                    'errors' => ['Não há cédulas disponíveis para o valor solicitado'],
                                ]
                            , 404); 
                        }

                        if ($countBankNotes > 0) {
                            $amountBankNotes[$bn] = $countBankNotes;
                        }
                    }

                    $accountBank->balance -= intval($request->value);
                    $accountBank->save();

                    return response()->json(
                        [
                            'message' => 'Success.',
                            'data' => [
                                'banknotes_info' => $this->messageAmountBankNotes($amountBankNotes),
                                'account_bank_id' => $accountBank->id,
                                'balance' => $accountBank->balance,
                            ],
                        ]
                    ); 
                }
            }
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }

    public function deposit(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'account_bank_id' => 'required|integer',
            'account_bank_type_id' => 'required|integer|between:1,2',
            'user_id' => 'required|integer',
            'value' => 'required|integer|min:1'
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        try {
            $accountBank = AccountBank::where([
                'id'=> $request->account_bank_id,
                'account_bank_type_id' => $request->account_bank_type_id,
                'user_id' => $request->user_id
            ])
            ->first();

            if (!$accountBank) {
                return response()->json(['Account Bank not found'], 404);
            } else {
                $accountBank->balance += intval($request->value);
                $accountBank->save();

                return response()->json(
                    [
                        'message' => 'Success.',
                        'data' => [
                            'account_bank_id' => $accountBank->id,
                            'balance' => $accountBank->balance,
                        ],
                    ]
                ); 
            }
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }

    private function messageAmountBankNotes($amountBankNotes)
    {   
        $message = array();
        foreach ($amountBankNotes as $bankNote => $amount) {
            $message[] = "{$amount} nota(s) de {$bankNote}";
        }
        return $message;
    }
}
