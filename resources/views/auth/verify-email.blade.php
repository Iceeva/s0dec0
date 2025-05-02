@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-50 to-gray-100">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <div class="text-center mb-8">
            <img src="{{ asset('images/SODECO-980x316.png') }}" alt="Logo SODECO" class="h-16 mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 mt-4">Vérification d'email requise</h1>
        </div>

        <div class="mb-6 text-sm text-gray-600">
            Merci pour votre inscription ! Avant de commencer, veuillez vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer.
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 text-sm text-green-600">
                Un nouveau lien de vérification a été envoyé à l'adresse e-mail que vous avez fournie lors de votre inscription.
            </div>
        @endif

        <div class="mt-6 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" 
                        class="text-blue-600 hover:text-blue-800 font-medium">
                    Renvoyer l'email de vérification
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="text-gray-600 hover:text-gray-800 font-medium">
                    Se déconnecter
                </button>
            </form>
        </div>
    </div>
</div>
@endsection