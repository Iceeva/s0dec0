@php use Illuminate\Support\Facades\Route; @endphp

@extends('layouts.guest')

@section('content')

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Login & Signup</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Captur.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

<body>
    <div class="corner-decor top-right"></div>
    <div class="corner-decor bottom-left"></div>

    <main class="py-8">
        <div class="wrapper">
            <!-- Logo -->
            <div class="logo-container">
                <a href="/">
                    <img src="{{ asset('images/SODECO-980x316.png') }}" alt="Logo SODECO">
                </a>
            </div>
            
            <div class="title-text">
                <div class="title login">Connexion</div>
                <div class="title signup">Inscription</div>
            </div>
            
            <div class="form-container">
                <div class="slide-controls">
                    <input type="radio" name="slide" id="login" checked>
                    <input type="radio" name="slide" id="signup">
                    <label for="login" class="slide login">Connexion</label>
                    <label for="signup" class="slide signup">Inscription</label>
                    <div class="slider-tab"></div>
                </div>
                
                <div class="form-inner">
                    <!-- Connexion -->
                    <form action="{{ route('login') }}" method="POST" class="login">
                        @csrf
                        <div class="field">
                            <input type="email" name="email" id="email_login" placeholder="Email" required>
                        </div>
                        <div class="field">
                            <input type="password" name="password" id="password_login" placeholder="Mot de passe" required>
                        </div>
                        <div class="pass-link">
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                {{ __('Mot de passe oublié ?') }}
                            </a>
                            @endif
                        </div>
                        <div class="field btn">
                            <div class="btn-layer"></div>
                            <input type="submit" value="Se connecter">
                        </div>
                        <div class="signup-link">
                            Pas encore membre? <a href="{{ route('register') }}">Inscrivez-vous maintenant</a>
                        </div>
                    </form>
                    
                    <!-- Inscription -->
                    <form action="{{ route('register') }}" method="POST" class="signup">
                        @csrf
                        <div class="field">
                            <input type="text" name="name" id="name" placeholder="Nom complet" required>
                        </div>
                        <div class="field">
                            <input type="email" name="email" id="email_register" placeholder="Email" required>
                        </div>
                        <div class="field">
                            <input type="password" name="password" id="password_register" placeholder="Mot de passe" required>
                        </div>
                        <div class="field">
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirmer le mot de passe" required>
                        </div>
                        <div class="field btn">
                            <div class="btn-layer"></div>
                            <input type="submit" value="S'inscrire">
                        </div>
                        <div class="signup-link">
                            Déjà un compte? <a href="{{ route('login') }}">Se connecter</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">SODECO</h3>
                    <p class="text-gray-400">La traçabilité du coton, de la graine au produit fini.</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Liens rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Accueil</a></li>
                        <li><a href="login" class="text-gray-400 hover:text-white">Connexion</a></li>
                        <li><a href="gener_qr_code" class="text-gray-400 hover:text-white">Générer QR Code</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Contact</h3>
                    <ul class="text-gray-400 space-y-2">
                        <li><i class="fas fa-envelope mr-2"></i> sodeco@sodeco.bj</li>
                        <li><i class="fas fa-phone mr-2"></i> (229) 01 21 30 95 39</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Immeuble FAGACE, Bld de la CENSAD, 01 BP 8059,
                            Cotonou – BENIN</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Réseaux sociaux</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white text-xl"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
                <p>© 2025 SODECO. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        const loginText = document.querySelector(".title-text .login");
        const loginForm = document.querySelector("form.login");
        const loginBtn = document.querySelector("label.login");
        const signupBtn = document.querySelector("label.signup");
        const signupLink = document.querySelector("form.login .signup-link a");
        const loginLink = document.querySelector("form.signup .signup-link a");
        
        signupBtn.onclick = () => {
            loginForm.style.marginLeft = "-50%";
            loginText.style.marginLeft = "-50%";
        };
        
        loginBtn.onclick = () => {
            loginForm.style.marginLeft = "0%";
            loginText.style.marginLeft = "0%";
        };
        
        signupLink.onclick = () => {
            signupBtn.click();
            return false;
        };
        
        loginLink.onclick = () => {
            loginBtn.click();
            return false;
        };
    </script>
</body>
</html>
@endsection