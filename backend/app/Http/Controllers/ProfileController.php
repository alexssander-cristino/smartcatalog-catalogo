<?php


namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;





class ProfileController extends Controller
{



    public function edit()
    {


        return view('profile.edit');


    }








    public function update(Request $request)
    {



        $request->validate([


            'name' => 'required|string|max:255',


            'email' => 'required|email|max:255',


            'foto' => 'nullable|image|max:2048',


        ]);





        $user = Auth::user();





        $foto = $user->foto;






        if($request->hasFile('foto')){


            // remove foto antiga

            if($user->foto){

                Storage::disk('public')
                    ->delete($user->foto);

            }





            // salva nova foto

            $foto = $request->file('foto')
                ->store(
                    'perfis',
                    'public'
                );


        }






        $user->update([


            'name' => $request->name,


            'email' => $request->email,


            'foto' => $foto,


        ]);





        return back()->with(
            'status',
            'Perfil atualizado com sucesso!'
        );



    }









    public function updatePassword(Request $request)
    {



        $request->validate([


            'current_password' => 'required',


            'password' => 'required|min:8|confirmed',


        ]);





        $user = Auth::user();





        if(!Hash::check(

            $request->current_password,

            $user->password

        )){



            return back()->withErrors([


                'current_password' => 'Senha atual incorreta.'


            ]);



        }





        $user->update([


            'password' => Hash::make(

                $request->password

            )


        ]);





        return back()->with(
            'status',
            'Senha alterada com sucesso!'
        );



    }









    public function destroy(Request $request)
    {



        $user = Auth::user();





        if($user->foto){


            Storage::disk('public')
                ->delete($user->foto);


        }





        Auth::logout();





        $user->delete();





        $request->session()->invalidate();


        $request->session()->regenerateToken();





        return redirect('/');


    }



}