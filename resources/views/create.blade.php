@extends('welcome')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <form action="{{ route('ajoutSauce') }}" method="post">
        <h2>Ajouter une sauce</h2>
        @csrf
        <input type='text' name='nom' placeholder='Nom de la sauce'>
        <input type='text' name='manufacturer' placeholder='Manufacturer'>
        <input type='text' name='description' placeholder='Description'>
        <input type='number' name='heat' placeholder='Heat' max="10" min="0">
        <input type='text' name='pimentPrincipale' placeholder='Piment principal'>
        <input type='text' name='image' placeholder="Lien de l'image">
        <button type="submit">Valider</button>
    </form>
@endsection
