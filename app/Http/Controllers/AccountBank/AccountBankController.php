<?php

namespace App\Http\Controllers\AccountBank;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AccountBank;

class AccountBankController extends Controller
{
    public function create(Request $request)
    {
        try {
            $accountBank = new AccountBank;
            $accountBank->user_id = $request->user_id;
            $accountBank->account_bank_type = $request->account_bank_type;
            $accountBank->balance = 0;
            $accountBank->save();

            return response()->json(['Account Bank created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }

    public function delete(Request $request)
    {
        try {
            User::find($request->id)->delete();
            return response()->json(['Account Bank deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }
}
