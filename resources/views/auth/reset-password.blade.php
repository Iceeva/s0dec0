@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-50 to-gray-100">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <div class="text-center mb-8">
            <img src="{{ asset('images/SODECO-980x316.png') }}" alt="Logo SODECO" class="h-16 mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 mt-4">Nouveau mot de passe</h1>
            <p class="text-gray-600 mt-2">Définissez votre nouveau mot de passe</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-6">
                <label for="email" class="block text-gray-700 mb-2">Adresse Email</label>
                <input type="email" id="email" name="email" 
                       class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('email', $request->email) }}" required autofocus>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 mb-2">Nouveau mot de passe</label>
                <input type="password" id="password" name="password" 
                       class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 mb-2">Confirmer le mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation" 
                       class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                Réinitialiser le mot de passe
            </button>
        </form>
    </div>
</div>
@endsection