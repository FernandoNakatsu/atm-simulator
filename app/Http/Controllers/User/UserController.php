<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $customMessages = ['cpf.formato_cpf'=> 'Invalid CPF format.'];
        $rules = [
            'fullname' => 'required|string',
            'birthday' => 'required|date_format:Y-m-d',
            'cpf' => 'required|formato_cpf',
        ];

        $validator = \Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $user = new User;
        $user->fullname = $request->fullname;
        $user->birthday = $request->birthday;
        $user->cpf = $request->cpf;
        $user->save();

        return response()->json(["User created successfully."], 201);  
    }

    public function update(Request $request)
    {
        $customMessages = ['cpf.formato_cpf'=> 'Invalid CPF format.'];
        $rules = [
            'user_id' => 'required|integer',
            'fullname' => 'nullable|string',
            'birthday' => 'nullable|date_format:Y-m-d',
            'cpf' => 'nullable|formato_cpf',
        ];

        $validator = \Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $user = User::find($request->user_id);
        if ($user) {
            if ($request->filled('name')) {
                $user->fullname = $request->fullname;
            }

            if ($request->filled('birthday')) {
                $user->birthday = $request->birthday;
            }

            if ($request->filled('cpf')) {
                $user->cpf = $request->cpf;
            }
            
            $user->save();

            return response()->json(['User updated successfully'], 200);
        } else {
            return response()->json(["errors" => ["User not found."]], 404);
        }
    }

    public function delete(Request $request)
    {
        $validator = \Validator::make($request->all(), ['user_id' => 'required|integer']);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $user = User::find($request->user_id);
        if ($user) {
            $user->delete();

            return response()->json(["User deleted successfully."], 200);
        } else {
            return response()->json(["errors" => ["User not found."]], 404);
        }
    }

    public function search($fullname)
    {
        $searchString = mb_strtolower($fullname);
        $result = User::whereRaw("lower(fullname) LIKE '%{$searchString}%'")->get();

        if ($result->isEmpty()) {
            return response()->json(['errors' => 'User not found.'], 404);
        }

        return response()->json(
            [
                'message' => 'Success.',
                'data' => $result,
            ]
        );
    }
}
