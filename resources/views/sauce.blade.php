@extends('welcome')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/sauce.css') }}">
    <div class="container">
        <img src="{{ $sauce->imgURL }}" alt="{{ $sauce->nom }}">
        <div>
            <h2>{{ $sauce->nom }}</h1>
            <p><span class='titreDesc'>Manufacturer</span> : {{ $sauce->manufacturer }}</p>
            <p><span class='titreDesc'>Description</span> : {{ $sauce->description }}</p>
            <p><span class='titreDesc'>Main Pepper</span> : {{ $sauce->pimentPrincipale }}</p>
            <p><span class='titreDesc'>Heat</span> : {{ $sauce->heat }}/10</p>
            <div>
                <a class="buttonSauce" id="like" href='{{route('likeSauce', ['id' => $sauce->id])}}'>👍 {{ $sauce->likes }}</a>
                <a class="buttonSauce" id="dislike" href='{{route('dislikeSauce', ['id' => $sauce->id])}}'>👎 {{ $sauce->dislikes }}</a>
            </div>
            <div>
                @if(session('utilisateur') && session('utilisateur')->id == $sauce->userID)
                <p><span class='titreDesc'>🛠 Manage your sauce : </span></p>
                <a class="buttonSauce" id="edit" >✏ Edit</a>
                <a class="buttonSauce" id="delete">🗑 Delete</a>
                <script>
                    btnDelete = document.querySelector('#delete');

                    btnDelete.addEventListener('click', (e) =>{
                    let modal = document.createElement('div');
                    modal.classList.add('modal');
                    modal.innerHTML = `
                        <div class="modal-content">
                            <p>Êtes-vous sûr de vouloir supprimer ce produit ?</p>
                            <div class="modal-buttons">
                                <button id="cancel">Annuler</button>
                                <button id="confirm">Confirmer</button>
                            </div>
                        </div>
                    `;
                    document.body.appendChild(modal);
                    btnConfirm = document.querySelector('#confirm');
                    btnConfirm.addEventListener('click', (e) =>{
                        window.location.href = '{{route('deleteSauce', ['id' => $sauce->id])}}';
                    });

                    btnCancel = document.querySelector('#cancel');
                    btnCancel.addEventListener('click', (e) =>{
                    modal = document.querySelector('.modal');
                    document.body.removeChild(modal);
                    });
                });

                btnEdit = document.querySelector('#edit');

                btnEdit.addEventListener('click', (e) =>{
                    let modal = document.createElement('div');
                    modal.classList.add('modal');
                    modal.innerHTML = `
                        <div class="modal-content-edit">
                            <form action="{{route('editSauce', ['id' => $sauce->id])}}" method="POST">
                                <h2>Edit your sauce</h2>
                                @csrf
                                <label for="nom">Nom</label><br>
                                <input type="text" name="nom" id="nom" value="{{ $sauce->nom }}"><br>
                                <label for="manufacturer">Manufacturer</label><br>
                                <input type="text" name="manufacturer" id="manufacturer" value="{{ $sauce->manufacturer }}"><br>
                                <label for="description">Description</label><br>
                                <input type="text" name="description" id="description" cols="30" rows="10" value="{{ $sauce->description }}"><br>
                                <label for="pimentPrincipale">Main Pepper</label><br>
                                <input type="text" name="pimentPrincipale" id="pimentPrincipale" value="{{ $sauce->pimentPrincipale }}"><br>
                                <label for="heat">Heat</label><br>
                                <input type="number" name="heat" id="heat" value="{{ $sauce->heat }}"><br>
                                <label for="imgURL">Image URL</label><br>
                                <input type="text" name="imgURL" value="{{ $sauce->imgURL }}"><br>
                                <button type="submit">Save</button>
                            </form>
                        </div>
                    `;
                    document.body.appendChild(modal);
                    
                });
                </script>
                @endif
            </div>
    </div>
@endsection
