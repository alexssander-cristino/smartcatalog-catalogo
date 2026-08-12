<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
                'foto' => $user->foto,
            ],
        ], 200);
    }


    /**
     * Logout do aplicativo mobile.
     */
    public function logout(Request $request)
    {
        $token = $request->user()
            ->currentAccessToken();

        if ($token) {
            $token->delete();
        }

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
                'foto' => $user->foto,
            ],
        ], 200);
    }


    /**
     * Atualiza o perfil do usuário.
     *
     * Permite alterar:
     * - Nome
     * - E-mail
     * - Senha
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Validação básica
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
            ],

            'current_password' => [
                'nullable',
                'string',
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Se informou nova senha
        |--------------------------------------------------------------------------
        |
        | A senha atual passa a ser obrigatória.
        |
        */

        if (
            $request->filled('password')
        ) {

            if (
                !$request->filled('current_password')
            ) {
                return response()->json([
                    'success' => false,
                    'message' =>
                        'Informe sua senha atual para alterar a senha.',
                ], 422);
            }


            /*
            |--------------------------------------------------------------------------
            | Confere senha atual
            |--------------------------------------------------------------------------
            */

            if (
                !Hash::check(
                    $request->current_password,
                    $user->password
                )
            ) {
                return response()->json([
                    'success' => false,
                    'message' =>
                        'A senha atual está incorreta.',
                ], 422);
            }


            /*
            |--------------------------------------------------------------------------
            | Atualiza senha
            |--------------------------------------------------------------------------
            */

            $user->password = Hash::make(
                $request->password
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Atualiza nome e e-mail
        |--------------------------------------------------------------------------
        */

        $user->name = $request->name;

        $user->email = $request->email;


        /*
        |--------------------------------------------------------------------------
        | Salva alterações
        |--------------------------------------------------------------------------
        */

        $user->save();


        /*
        |--------------------------------------------------------------------------
        | Se a senha foi alterada, invalida tokens antigos
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('password')
        ) {
            $user->tokens()->delete();

            /*
            |--------------------------------------------------------------------------
            | Cria novo token automaticamente
            |--------------------------------------------------------------------------
            */

            $token = $user->createToken(
                'mobile'
            )->plainTextToken;

            return response()->json([
                'success' => true,

                'message' =>
                    'Perfil e senha atualizados com sucesso.',

                'token' => $token,

                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'foto' => $user->foto,
                ],
            ], 200);
        }


        /*
        |--------------------------------------------------------------------------
        | Retorno sem alteração de senha
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,

            'message' =>
                'Perfil atualizado com sucesso.',

            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'foto' => $user->foto,
            ],
        ], 200);
    }
}