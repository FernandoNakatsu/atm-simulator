<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'fullname' => 'required|string',
            'birthdate' => 'required|date_format:Y-m-d',
            'cpf' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

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
        $validator = \Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'fullname' => 'nullable|string',
            'birthdate' => 'nullable|date_format:Y-m-d',
            'cpf' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        try {
            $user = User::find($request->user_id);
            if ($user) {
                if ($request->filled('name')) {
                    $user->fullname = $request->fullname;
                }

                if ($request->filled('birthdate')) {
                    $user->birthdate = $request->birthdate;
                }

                if ($request->filled('cpf')) {
                    $user->cpf = $request->cpf;
                }
                
                $user->save();

                return response()->json(['User updated successfully'], 200);
            } else {
                return response()->json(["errors" => ["User not found."]], 404);
            }
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }

    public function delete(Request $request)
    {
        $validator = \Validator::make($request->all(), ['user_id' => 'required|integer']);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        try {
            $user = User::find($request->user_id);
            if ($user) {
                $user->delete();

                return response()->json(['User deleted successfully'], 200);
            } else {
                return response()->json(["errors" => ["User not found."]], 404);
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
