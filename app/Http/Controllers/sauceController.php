<?php

namespace App\Http\Controllers;

use App\Models\sauce;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use PhpOption\None;

class sauceController extends Controller
{
    public function voir($id): View
    {
        $sauce = \App\Models\sauce::findOrfail($id);
        return view('sauce', ['sauce' => $sauce]);
    }

    public function index(): View
    {
        $sauces = \App\Models\sauce::all();
        return view('allSauces', ['sauces' => $sauces]);
    }

    public function creerUneSauce(){
        if(!session('utilisateur'))
            return redirect()->route('login');
        return view('create');
    }

    public function ajoutSauce(Request $request){
        if(!session('utilisateur'))
            return redirect()->route('login');
        $request -> validate([
            'nom' => 'required',
            'manufacturer' => 'required',
            'description' => 'required',
            'pimentPrincipale' => 'required',
            'heat' => 'required',
            'image' => 'required'
        ]);

        $sauce = new sauce();
        $sauce->userID = session('utilisateur')->id;
        $sauce->nom = $request->nom;
        $sauce->manufacturer = $request->manufacturer;
        $sauce->description = $request->description;
        $sauce->pimentPrincipale = $request->pimentPrincipale;
        $sauce->heat = $request->heat;
        $sauce->imgURL = $request->image;
        $sauce->save();
        return redirect()->route('sauce')->with('success', 'Votre sauce a bien été créée');
    }

    public function likeSauce($id){
        if(!session('utilisateur'))
            return redirect()->route('login');
        $idUser = session('utilisateur')->id;
        $sauce = sauce::findOrfail($id);
        $usersWhoLiked = json_decode($sauce->usersWhoLiked);
        if(in_array($idUser, $usersWhoLiked)){
            return redirect()->back()->with('error', 'Vous avez déjà liké cette sauce');
            
        }
        $usersWhoDisliked = json_decode($sauce->usersWhoDisliked);
        if(in_array($idUser, $usersWhoDisliked)){
            $usersWhoDisliked = array_diff($usersWhoDisliked, [$idUser]);
            $sauce->usersWhoDisliked = json_encode($usersWhoDisliked);
            $sauce->dislikes -= 1;
        }
        $sauce->likes += 1;
        array_push($usersWhoLiked, $idUser);
        $sauce->usersWhoLiked = json_encode($usersWhoLiked);
        $sauce->save();
        return redirect()->back()->with('success', 'Vous avez liké cette sauce');
        

    }

    public function dislikeSauce($id){
        if(!session('utilisateur'))
            return redirect()->route('login');
        $idUser = session('utilisateur')->id;
        $sauce = sauce::findOrfail($id);
        $usersWhoDisliked = json_decode($sauce->usersWhoDisliked);
        if(in_array($idUser, $usersWhoDisliked)){
            return redirect()->back()->with('error', 'Vous avez déjà disliké cette sauce');
        }
        $usersWhoLiked = json_decode($sauce->usersWhoLiked);
        if(in_array($idUser, $usersWhoLiked)){
            $usersWhoLiked = array_diff($usersWhoLiked, [$idUser]);
            $sauce->usersWhoLiked = json_encode($usersWhoLiked);
            $sauce->likes -= 1;
        }
        $sauce->dislikes += 1;
        array_push($usersWhoDisliked, $idUser);
        $sauce->usersWhoDisliked = json_encode($usersWhoDisliked);
        $sauce->save();
        return redirect()->back()->with('success', 'Vous avez disliké cette sauce');
    }

    public function deleteSauce($id){
        if(!session('utilisateur'))
            return redirect()->route('login');
        $sauce = sauce::findOrfail($id);
        if($sauce->userID != session('utilisateur')->id)
            return redirect()->back()->with('error', 'Vous n\'êtes pas le propriétaire de cette sauce');
        $sauce->delete();
        return redirect()->route('sauce')->with('success', 'Votre sauce a bien été supprimée');
    }

    public function editSauce($id, Request $request){
        if(!session('utilisateur'))
            return redirect()->route('login');
        $sauce = sauce::findOrfail($id);
        if($sauce->userID != session('utilisateur')->id)
            return redirect()->back()->with('error', 'Vous n\'êtes pas le propriétaire de cette sauce');
        $request -> validate([
            'nom' => 'required',
            'manufacturer' => 'required',
            'description' => 'required',
            'pimentPrincipale' => 'required',
            'heat' => 'required',
            'imgURL' => 'required'
        ]);
        
        $sauce->nom = $request->nom;
        $sauce->manufacturer = $request->manufacturer;
        $sauce->description = $request->description;
        $sauce->pimentPrincipale = $request->pimentPrincipale;
        $sauce->heat = $request->heat;
        $sauce->imgURL = $request->imgURL;
        $sauce->save();
        return redirect()->back()->with('success', 'Votre sauce a bien été modifiée');
    }
}
