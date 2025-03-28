<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\utilisateur;

class inscriptionController extends Controller
{
    
    public function register(){
        return view('register');
    }

    public function nouveauUser(Request $request){
        $request -> validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ]);

        $user = utilisateur::where('email', $request->email)->first();
        if($user){
            return back()->with('error', 'Cet email est déjà utilisé');
        }
        else{
            $user = new utilisateur;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect()->route('register')->with('success', 'Votre compte a bien été créé');
        }

    }
}
