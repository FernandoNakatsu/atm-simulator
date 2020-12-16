<?php

namespace App\Http\Controllers\AccountBank;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AccountBank;

class AccountBankController extends Controller
{
    public function create(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'account_bank_type_id' => 'required|integer|between:1,2',
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $accountBank = AccountBank::where(
            [
                'account_bank_type_id' => $request->$account_bank_type_id,
                'user_id' => $request->$user_id,
            ]
        )->first();

        if ($accountBank) {
            return response()->json(['Bank account already exists for this user'], 403); 
        }

        $accountBank = new AccountBank;
        $accountBank->user_id = $request->user_id;
        $accountBank->account_bank_type_id = $request->account_bank_type_id;
        $accountBank->balance = 0;
        $accountBank->save();

        return response()->json(['Account Bank created successfully'], 201); 
    }
}
