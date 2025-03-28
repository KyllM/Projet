<?php

namespace App\Http\Controllers;

use App\Models\utilisateur;
use Illuminate\Http\Request;

class connexionController extends Controller
{
    public function login(){
        if(session()->has('utilisateur')){
            return redirect()->route('sauce');
        }
        return view('login');
    }

    public function authenticate(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        $user = utilisateur::where('email', $request->email)->first();
        if($user){
            if(password_verify($request->password, $user->password)){
                $request->session()->put('utilisateur', $user);
                return redirect()->route('sauce');
            }
            else{
                return back()->with('error', 'Identifiants incorrects');
            }
        }
        return back()->with('error', 'Identifiants incorrects');
    }

    public function logout(){
        if(session()->has('utilisateur')){
            session()->pull('utilisateur');
        }
        return redirect()->route('login');
    }
}
