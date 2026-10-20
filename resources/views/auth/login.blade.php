@extends('layouts.login_master')

@section('content') <div class="page-content login-cover">


    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Content area -->
        <div class="content d-flex justify-content-center align-items-center">

            <!-- Login card -->
            <form class="login-form" method="post" action="{{ route('login') }}">
                @csrf

                <div class="card mb-0">
                    <div class="card-body">

                        <div class="text-center mb-3">
                            <img
                                src="https://madaure.vercel.app/assets/images/logo/logo.png"
                                alt="Logo"
                                class="img-fluid mb-3 mt-1"
                                style="max-width: 120px; height: auto;"
                            >
                            <h5 class="mb-0">Connectez-vous à votre compte</h5>
                            <span class="d-block text-muted">Entrez vos identifiants</span>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-styled-left alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                <span class="font-weight-semibold">Oups !</span>
                                {{ implode('<br>', $errors->all()) }}
                            </div>
                        @endif

                        <div class="form-group">
                            <input
                                type="text"
                                class="form-control"
                                name="identity"
                                value="{{ old('identity') }}"
                                placeholder="Identifiant ou adresse e-mail"
                            >
                        </div>

                       <div class="form-group">
    <div class="input-group">
        <input
            required
            name="password"
            id="password"
            type="password"
            class="form-control"
            placeholder="Mot de passe"
        >

        <div class="input-group-append">
            <button
                type="button"
                class="btn btn-light"
                id="togglePassword"
                aria-label="Afficher le mot de passe"
            >
                <i class="icon-eye" id="passwordIcon"></i>
            </button>
        </div>
    </div>
</div>

                        
<div class="form-group text-right">
    <a href="{{ route('password.request') }}">
        Mot de passe oublié ?
    </a>
</div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                Se connecter
                                <i class="icon-circle-right2 ml-2"></i>
                            </button>
                        </div>

                        {{-- <div class="form-group">
                            <a href="#" class="btn btn-light btn-block">
                                <i class="icon-home"></i> Retour à l'accueil
                            </a>
                        </div> --}}

                    </div>
                </div>
            </form>

        </div>

    </div>

</div>
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const password = document.getElementById('password');
        const icon = document.getElementById('passwordIcon');

        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('icon-eye');
            icon.classList.add('icon-eye-blocked');
            this.setAttribute('aria-label', 'Masquer le mot de passe');
        } else {
            password.type = 'password';
            icon.classList.remove('icon-eye-blocked');
            icon.classList.add('icon-eye');
            this.setAttribute('aria-label', 'Afficher le mot de passe');
        }
    });
</script>


@endsection
