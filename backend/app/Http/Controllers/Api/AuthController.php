<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Login do aplicativo mobile.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'string',
            ],
        ]);

        $user = User::where(
            'email',
            $request->email
        )->first();

        /*
        |--------------------------------------------------------------------------
        | Usuário não encontrado ou senha incorreta
        |--------------------------------------------------------------------------
        */

        if (
            !$user ||
            !Hash::check(
                $request->password,
                $user->password
            )
        ) {
            return response()->json([
                'success' => false,
                'message' => 'E-mail ou senha incorretos.',
            ], 401);
        }

        /*
        |--------------------------------------------------------------------------
        | Remove tokens antigos
        |--------------------------------------------------------------------------
        */

        $user->tokens()->delete();

        /*
        |--------------------------------------------------------------------------
        | Cria novo token
        |--------------------------------------------------------------------------
        */

        $token = $user->createToken(
            'mobile'
        )->plainTextToken;

        /*
        |--------------------------------------------------------------------------
        | Retorno
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,
            'message' => 'Login realizado com sucesso.',

            'token' => $token,

            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ], 200);
    }


    /**
     * Logout do aplicativo mobile.
     */
    public function logout(Request $request)
    {
        $request->user()
            ->currentAccessToken()
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout realizado com sucesso.',
        ], 200);
    }


    /**
     * Retorna o usuário autenticado.
     */
    public function user(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,

            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ], 200);
    }
}