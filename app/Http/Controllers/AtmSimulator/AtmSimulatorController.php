<?php

namespace App\Http\Controllers\AtmSimulator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{AccountBank,MoneyNote};

class AtmSimulatorController extends Controller
{
    public function withdraw(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'account_bank_id' => 'required|integer',
            'account_bank_type_id' => 'required|integer|between:1,2',
            'user_id' => 'required|integer',
            'withdraw_value' => 'required|integer|min:20'
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
                    #TODO
                    return response()->json(['Withdrawal was successful'], 200);
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
            'deposit_value' => 'required|integer|min:1'
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
                $accountBank->balance = $accountBank->balance + intval($request->deposit_value);
                $accountBank->save();
                return response()->json(['Deposit was successful'], 200);
            }
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }
}
