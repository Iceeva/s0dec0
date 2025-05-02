@extends('layouts.guest')

<head>
    <meta charset="UTF-8">
    <title>Mot de passe oublié</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Captur.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        @import url("https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap");
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            position: relative;
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(196, 197, 204, 0.8) 0%, rgba(220, 221, 225, 0.9) 100%);
            overflow-x: hidden;
        }

        body::before {
            content: "SODECO";
            position: fixed;
            top: 50%;
            right: -100px;
            transform: translateY(-50%) rotate(-45deg);
            font-size: 120px;
            font-weight: 900;
            color: rgba(0, 83, 179, 0.08);
            z-index: -1;
            text-transform: uppercase;
            letter-spacing: 10px;
            font-family: 'Arial Black', sans-serif;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .corner-decor {
            position: fixed;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0, 83, 179, 0.1) 0%, rgba(0, 83, 179, 0) 70%);
            z-index: -1;
        }

        .corner-decor.top-right {
            top: -150px;
            right: -150px;
        }

        .corner-decor.bottom-left {
            bottom: -150px;
            left: -150px;
        }

        .wrapper {
            overflow: hidden;
            max-width: 500px;
            width: 90%;
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.15);
            margin: 50px auto;
            position: relative;
            z-index: 1;
        }

        .wrapper::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: linear-gradient(45deg, #0073e6, #00b33c);
            z-index: -1;
            border-radius: 25px;
            opacity: 0.1;
        }

        .wrapper .title-text {
            display: flex;
            width: 200%;
        }

        .wrapper .title {
            width: 50%;
            font-size: 35px;
            font-weight: 600;
            text-align: center;
            transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            color: #0053b3;
            margin-bottom: 20px;
        }

        .wrapper .slide-controls {
            position: relative;
            display: flex;
            height: 50px;
            width: 100%;
            overflow: hidden;
            margin: 30px 0;
            justify-content: space-between;
            border: 1px solid lightgrey;
            border-radius: 15px;
        }

        .slide-controls .slide {
            height: 100%;
            width: 100%;
            color: #000;
            font-size: 18px;
            font-weight: 500;
            text-align: center;
            line-height: 48px;
            cursor: pointer;
            z-index: 1;
            transition: all 0.6s ease;
        }

        .slide-controls .slider-tab {
            position: absolute;
            height: 100%;
            width: 50%;
            left: 0;
            z-index: 0;
            border-radius: 15px;
            background: linear-gradient(to right, #003366, #0073e6);
            transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        input[type="radio"] {
            display: none;
        }

        #signup:checked ~ .slider-tab {
            left: 50%;
        }

        #signup:checked ~ label.signup {
            color: #fff;
            cursor: default;
            user-select: none;
        }

        #signup:checked ~ label.login {
            color: #000;
        }

        #login:checked ~ label.signup {
            color: #000;
        }

        #login:checked ~ label.login {
            color: #fff;
            cursor: default;
            user-select: none;
        }

        .wrapper .form-container {
            width: 100%;
            overflow: hidden;
        }

        .form-container .form-inner {
            display: flex;
            width: 200%;
        }

        .form-container .form-inner form {
            width: 50%;
            transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            padding: 0 10px;
        }

        .form-inner form .field {
            height: 50px;
            width: 100%;
            margin-top: 20px;
        }

        .form-inner form .field input {
            height: 100%;
            width: 100%;
            outline: none;
            padding-left: 15px;
            border-radius: 15px;
            border: 1px solid lightgrey;
            border-bottom-width: 2px;
            font-size: 17px;
            transition: all 0.3s ease;
        }

        .form-inner form .field input:focus {
            border-color: #0073e6;
            box-shadow: 0 0 5px rgba(0, 115, 230, 0.3);
        }

        .form-inner form .field input::placeholder {
            color: #999;
            transition: all 0.3s ease;
        }

        form .field input:focus::placeholder {
            color: #0073e6;
        }

        .form-inner form .pass-link {
            margin-top: 5px;
            text-align: right;
        }

        .form-inner form .signup-link {
            text-align: center;
            margin-top: 30px;
            color: #666;
        }

        .form-inner form .pass-link a,
        .form-inner form .signup-link a {
            color: #0073e6;
            text-decoration: none;
            font-weight: 500;
        }

        .form-inner form .pass-link a:hover,
        .form-inner form .signup-link a:hover {
            text-decoration: underline;
        }

        form .btn {
            height: 50px;
            width: 100%;
            border-radius: 15px;
            position: relative;
            overflow: hidden;
            margin-top: 30px;
            box-shadow: 0 5px 15px rgba(0, 83, 179, 0.2);
        }

        form .btn .btn-layer {
            height: 100%;
            width: 300%;
            position: absolute;
            left: -100%;
            background: linear-gradient(to right, #003366, #004080, #0059b3, #0073e6);
            border-radius: 15px;
            transition: all 0.4s ease;
        }

        form .btn:hover .btn-layer {
            left: 0;
        }

        form .btn input[type="submit"] {
            height: 100%;
            width: 100%;
            z-index: 1;
            position: relative;
            background: none;
            border: none;
            color: #fff;
            padding-left: 0;
            border-radius: 15px;
            font-size: 20px;
            font-weight: 500;
            cursor: pointer;
            letter-spacing: 1px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-container img {
            height: 70px;
            width: auto;
            transition: all 0.3s ease;
        }

        .logo-container img:hover {
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .wrapper {
                padding: 30px 20px;
            }
            
            body::before {
                font-size: 80px;
                right: -150px;
            }
            
            .wrapper .title {
                font-size: 28px;
            }
        }

        @media (max-width: 480px) {
            body::before {
                display: none;
            }
            
            .wrapper {
                width: 95%;
                padding: 25px 15px;
            }
            
            .slide-controls .slide {
                font-size: 16px;
            }
        }
    </style>
</head>

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-50 to-gray-100">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <div class="text-center mb-8">
            <img src="{{ asset('images/SODECO-980x316.png') }}" alt="Logo SODECO" class="h-16 mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 mt-4">Réinitialisation du mot de passe</h1>
            <p class="text-gray-600 mt-2">Entrez votre email pour recevoir un lien de réinitialisation</p>
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-6">
                <label for="email" class="block text-gray-700 mb-2"></label>
                <input type="email" id="email" name="email"  placeholder="Adresse Email"
                       class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('email') }}" required autofocus>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                Envoyer le lien de réinitialisation
            </button>

            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                    Retour à la page de connexion
                </a>
            </div>
        </form>
    </div>
</div>
@endsection