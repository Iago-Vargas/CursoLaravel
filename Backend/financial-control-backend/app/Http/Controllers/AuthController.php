<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthController extends Controller
{
    public function __construct(protected User $userModel){ }
        /* Metodo de registro */
        public function register(Request $request){

            $authRegisterFields = $request ->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed'
            ]);

            $userRegistered = $this->userModel->create($authRegisterFields);
            $token = $userRegistered->createToken($request->name);
            return ['userRegistered'=>$userRegistered, 'token'=>$token];
        }

        /* Metodo de login  */
        /* Como estamos pegando um login ele ja tem que existir no BD */
        public function login(Request $request){
            $request->validate([
                /* Required | do tipo email | Se existe no BD o user*/
                'email' => 'required|email|exists:users',
                'password' => 'required'
            ]);
            /* Busca no banco */
            $user = $this->userModel->where('email', $request->email)->first();

            /* Hash verifica se a senha do BD bate com a que colocamos */
            /* Senha tem que estar no metodo HASH no banco de dados */
            /* Verifica se colocou user OU e SE o Hash for diferente a senha que o usuario colocou ou a senha do BD ele entra no IF*/
            if(!$user || !Hash::check($request->password, $user->password)){
                return['MessageErrorLogin' => 'The Provide Credentials Are Incorrect'];
            }
            /* Criamos um label associado ao token do usuario */
            $token = $user->createToken($user->name);
            return ['user' => $user, 'token' => $token ];
        }

        /* Logout */
        public function logout(Request $request){
            $request->user()->tokens()->delete();
            return ['LogoutMessage' => 'You are logged out'];
        }

}
