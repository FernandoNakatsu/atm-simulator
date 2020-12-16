<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create(Request $request)
    {
        try {
            $user = new User;
            $user->fullname = $request->fullname;
            $user->birthdate = $request->birthdate;
            $user->cpf = $request->cpf;
            $user->save();

            return response()->json(['User created successfully'], 201);            
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }

    public function update(Request $request)
    {
        try {
            $user = User::find($request->user_id);
            if ($user) {
                $user->fullname = $request->fullname;
                $user->birthdate = $request->birthdate;
                $user->cpf = $request->cpf;
                $user->save();
                return response()->json(['User updated successfully'], 200);
            } else {
                return response()->json(['User not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }

    public function delete(Request $request)
    {
        try {
            $user = User::find($request->user_id);
            if ($user) {
                $user->delete();
                return response()->json(['User deleted successfully'], 200);
            } else {
                return response()->json(['User not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }

    public function search($search)
    {
        try {
            $searchString = mb_strtolower($search);
            $result = User::whereRaw("lower(fullname) LIKE '%{$searchString}%'")->get();

            return response()->json(
                [
                    'message' => 'Success.',
                    'data' => $result,
                ]
            );
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }
}
