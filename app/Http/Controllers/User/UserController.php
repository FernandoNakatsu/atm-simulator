<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

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

            return response()->json(
                [
                    'message' => 'Success.',
                    'data' => [
                        'fullname' => $user->fullname,
                        'birthdate' => $user->birthdate->format('Y-m-d'),
                        'cpf' => $user->cpf,
                    ],
                ]
            );            
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }

    public function update(Request $request)
    {
        try {
            $user = User::find($request->id);
            $user->fullname = $request->fullname;
            $user->birthdate = $request->birthdate;
            $user->cpf = $request->cpf;
            $user->save();

            return response()->json(
                [
                    'message' => 'Success.',
                    'data' => [
                        'fullname' => $user->fullname,
                        'birthdate' => $user->birthdate->format('Y-m-d'),
                        'cpf' => $user->cpf,
                    ],
                ]
            );    
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }

    public function delete(Request $request)
    {
        try {
            User::find($request->id)->delete();
            return response()->json(['User deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }
    }

    public function search(Request $request)
    {
        if ($request->get('search')) {
            $searchString = mb_strtolower($request->get('search'));
            $result = User::whereRaw("
                lower(fullname) LIKE '%{$searchString}%' OR
                lower(birthdate) LIKE '%{$searchString}%' OR
                lower(cpf) LIKE '%{$searchString}%'
            ")
            ->get();
        } else {
            $result = User::all();
        }

        return response()->json(
            [
                'message' => 'Success.',
                'data' => $result,
            ]
        ); 
    }
}
