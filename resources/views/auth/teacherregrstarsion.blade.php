@extends('layouts.login_master')

@section('content')

<style>
    /* =========================================
       INSCRIPTION ENSEIGNANT
       ========================================= */

    .teacher-reg-page {
        width: 100%;
        min-height: 100vh;
        padding: 40px 20px;
        background: #f4f6f9;
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }

    .teacher-reg-wrapper {
        width: 100%;
        max-width: 1000px;
    }

    .teacher-reg-box {
        width: 100%;
        background: #ffffff !important;
        border: 1px solid #dddddd;
        border-radius: 10px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        overflow: hidden;
    }

    .teacher-reg-header {
        background: #2196f3 !important;
        padding: 25px 30px;
        text-align: center;
    }

    .teacher-reg-logo {
        max-width: 180px;
        max-height: 80px;
        margin: 0 auto 15px;
        display: block;
    }

    .teacher-reg-header-title {
        margin: 0;
        color: #ffffff !important;
        font-size: 26px;
        font-weight: 600;
    }

    .teacher-reg-header-text {
        margin: 7px 0 0;
        color: #eaf5ff !important;
        font-size: 14px;
    }

    .teacher-reg-body {
        background: #ffffff !important;
        padding: 35px;
    }

    .teacher-reg-section-title {
        margin: 0 0 25px;
        padding-bottom: 12px;
        border-bottom: 2px solid #eeeeee;
        color: #333333 !important;
        font-size: 20px;
        font-weight: 600;
    }

    .teacher-reg-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px 25px;
    }

    .teacher-reg-field {
        width: 100%;
    }

    .teacher-reg-label {
        display: block;
        margin-bottom: 7px;
        color: #333333 !important;
        font-size: 14px;
        font-weight: 600;
    }

    .teacher-reg-required {
        color: #e53935 !important;
    }

    .teacher-reg-input,
    .teacher-reg-select {
        display: block;
        width: 100%;
        height: 44px;
        padding: 10px 13px;
        background: #ffffff !important;
        color: #333333 !important;
        border: 1px solid #bdbdbd !important;
        border-radius: 5px;
        outline: none !important;
        font-size: 14px;
        box-sizing: border-box;
    }

    .teacher-reg-input::placeholder {
        color: #999999 !important;
        opacity: 1 !important;
    }

    .teacher-reg-input:focus,
    .teacher-reg-select:focus {
        background: #ffffff !important;
        color: #333333 !important;
        border-color: #2196f3 !important;
        box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.12) !important;
    }

    .teacher-reg-select option {
        background: #ffffff !important;
        color: #333333 !important;
    }

    .teacher-reg-file {
        display: block;
        width: 100%;
        min-height: 44px;
        padding: 8px;
        background: #ffffff !important;
        color: #333333 !important;
        border: 1px solid #bdbdbd !important;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .teacher-reg-help {
        display: block;
        margin-top: 6px;
        color: #777777 !important;
        font-size: 12px;
    }

    .teacher-reg-alert-danger {
        margin-bottom: 25px;
        padding: 15px 18px;
        background: #f8d7da !important;
        color: #721c24 !important;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
    }

    .teacher-reg-alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }

    .teacher-reg-alert-danger li {
        color: #721c24 !important;
    }

    .teacher-reg-alert-success {
        margin-bottom: 25px;
        padding: 15px 18px;
        text-align: center;
        background: #d4edda !important;
        color: #155724 !important;
        border: 1px solid #c3e6cb;
        border-radius: 5px;
    }

    .teacher-reg-submit-area {
        margin-top: 30px;
        padding-top: 25px;
        border-top: 1px solid #eeeeee;
        text-align: center;
    }

    .teacher-reg-submit {
        display: inline-block;
        min-width: 240px;
        padding: 12px 30px;
        background: #2196f3 !important;
        color: #ffffff !important;
        border: 1px solid #2196f3 !important;
        border-radius: 5px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .teacher-reg-submit:hover {
        background: #1976d2 !important;
        border-color: #1976d2 !important;
        color: #ffffff !important;
    }

    .teacher-reg-hidden {
        display: none !important;
    }

    @media (max-width: 767px) {

        .teacher-reg-page {
            padding: 20px 10px;
        }

        .teacher-reg-body {
            padding: 25px 20px;
        }

        .teacher-reg-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .teacher-reg-header-title {
            font-size: 22px;
        }

        .teacher-reg-submit {
            width: 100%;
        }
    }
</style>

<div style="background-image: url(/global_assets/images/login_covereco.png)" class="teacher-reg-page">


<div class="teacher-reg-wrapper">

    <div class="teacher-reg-box">

        {{-- EN-TÊTE --}}
        <div class="teacher-reg-header">

            {{-- 
                Remplacez cette image par le même logo
                utilisé dans votre page de connexion.
            --}}
            <img
                src="{{ asset('global_assets/images/logo.png') }}"
                alt="Logo"
                class="teacher-reg-logo"
                onerror="this.style.display='none';"
            >

            <h3 class="teacher-reg-header-title">
                Inscription Enseignant
            </h3>

            <p class="teacher-reg-header-text">
                Créez votre compte enseignant
            </p>

        </div>


        {{-- CORPS --}}
        <div class="teacher-reg-body">


            {{-- ERREURS --}}
            @if ($errors->any())

                <div class="teacher-reg-alert-danger">

                    <ul>

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- SUCCÈS --}}
            @if(session('success'))

                <div class="teacher-reg-alert-success">
                    {{ session('success') }}
                </div>

            @endif


            <form
                method="POST"
                enctype="multipart/form-data"
                action="{{ route('teacher.registration.store') }}"
                class="teacher-reg-form"
            >

                @csrf


                {{-- ENSEIGNANT AUTOMATIQUE --}}
                <input
                    type="hidden"
                    name="user_type"
                    value="teacher"
                >

                {{-- ALGÉRIE AUTOMATIQUE --}}
                <input
                    type="hidden"
                    name="state_id"
                    value="1"
                >

                {{-- LGA AUTOMATIQUE --}}
                <input
                    type="hidden"
                    name="lga_id"
                    value="1"
                >


                {{-- TITRE --}}
                <h4 class="teacher-reg-section-title">
                    Informations personnelles
                </h4>


                <div class="teacher-reg-grid">


                    {{-- NOM COMPLET --}}
                    <div class="teacher-reg-field">

                        <label class="teacher-reg-label">
                            Nom complet
                            <span class="teacher-reg-required">*</span>
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Nom et prénom"
                            class="teacher-reg-input"
                            required
                        >

                    </div>


                    {{-- ADRESSE --}}
                    <div class="teacher-reg-field">

                        <label class="teacher-reg-label">
                            Adresse
                            <span class="teacher-reg-required">*</span>
                        </label>

                        <input
                            type="text"
                            name="address"
                            value="{{ old('address') }}"
                            placeholder="Votre adresse"
                            class="teacher-reg-input"
                            required
                        >

                    </div>


                    {{-- DATE DE NAISSANCE --}}
                    <div class="teacher-reg-field">

                        <label class="teacher-reg-label">
                            Date de naissance
                            <span class="teacher-reg-required">*</span>
                        </label>

                        <input
                            type="date"
                            name="dob"
                            value="{{ old('dob') }}"
                            class="teacher-reg-input"
                            required
                        >

                    </div>


                    {{-- EMAIL --}}
                    <div class="teacher-reg-field">

                        <label class="teacher-reg-label">
                            Adresse e-mail
                            <span class="teacher-reg-required">*</span>
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="exemple@email.com"
                            class="teacher-reg-input"
                            required
                        >

                    </div>


                    {{-- NOM D'UTILISATEUR --}}
                    <div class="teacher-reg-field">

                        <label class="teacher-reg-label">
                            Nom d'utilisateur
                            <span class="teacher-reg-required">*</span>
                        </label>

                        <input
                            type="text"
                            name="username"
                            value="{{ old('username') }}"
                            placeholder="Nom d'utilisateur"
                            class="teacher-reg-input"
                            required
                        >

                    </div>


                    {{-- TÉLÉPHONE --}}
                    <div class="teacher-reg-field">

                        <label class="teacher-reg-label">
                            Téléphone
                            <span class="teacher-reg-required">*</span>
                        </label>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="+213 XX XX XX XX"
                            class="teacher-reg-input"
                            required
                        >

                    </div>


                    {{-- AUTRE TÉLÉPHONE --}}
                    <div class="teacher-reg-field">

                        <label class="teacher-reg-label">
                            Téléphone secondaire
                        </label>

                        <input
                            type="text"
                            name="phone2"
                            value="{{ old('phone2') }}"
                            placeholder="+213 XX XX XX XX"
                            class="teacher-reg-input"
                        >

                    </div>


                    {{-- MOT DE PASSE --}}
                    <div class="teacher-reg-field">

                        <label class="teacher-reg-label">
                            Mot de passe
                            <span class="teacher-reg-required">*</span>
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="teacher-reg-input"
                            placeholder="Choisissez un mot de passe"
                            required
                        >

                    </div>


                    {{-- SEXE --}}
                    <div class="teacher-reg-field">

                        <label class="teacher-reg-label">
                            Sexe
                            <span class="teacher-reg-required">*</span>
                        </label>

                        <select
                            name="gender"
                            class="teacher-reg-select"
                            required
                        >

                            <option value="">
                                Sélectionnez...
                            </option>

                            <option
                                value="Male"
                                {{ old('gender') == 'Male' ? 'selected' : '' }}
                            >
                                Homme
                            </option>

                            <option
                                value="Female"
                                {{ old('gender') == 'Female' ? 'selected' : '' }}
                            >
                                Femme
                            </option>

                        </select>

                    </div>


                    {{-- NATIONALITÉ --}}
                    <div class="teacher-reg-field">

                        <label class="teacher-reg-label">
                            Nationalité
                            <span class="teacher-reg-required">*</span>
                        </label>

                        <select
                            name="nal_id"
                            class="teacher-reg-select"
                            required
                        >

                            <option value="">
                                Sélectionnez votre nationalité...
                            </option>

                            @foreach($nationals as $nal)

                                <option
                                    value="{{ $nal->id }}"
                                    {{ old('nal_id') == $nal->id ? 'selected' : '' }}
                                >
                                    {{ $nal->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- DATE D'EMPLOI --}}
                    <div class="teacher-reg-field">

                        <label class="teacher-reg-label">
                            Date d'emploi
                        </label>

                        <input
                            type="date"
                            name="emp_date"
                            value="{{ old('emp_date') }}"
                            class="teacher-reg-input"
                        >

                    </div>


                    {{-- GROUPE SANGUIN --}}
                    <div class="teacher-reg-field">

                        <label class="teacher-reg-label">
                            Groupe sanguin
                        </label>

                        <select
                            name="bg_id"
                            class="teacher-reg-select"
                        >

                            <option value="">
                                Sélectionnez...
                            </option>

                            @foreach($blood_groups as $bg)

                                <option
                                    value="{{ $bg->id }}"
                                    {{ old('bg_id') == $bg->id ? 'selected' : '' }}
                                >
                                    {{ $bg->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- PHOTO --}}
                    <div class="teacher-reg-field">

                        <label class="teacher-reg-label">
                            Photo d'identité
                        </label>

                        <input
                            type="file"
                            name="photo"
                            accept="image/jpeg,image/png,image/jpg"
                            class="teacher-reg-file"
                        >

                        <small class="teacher-reg-help">
                            Formats acceptés : JPEG, JPG, PNG — Taille maximale : 2 Mo.
                        </small>

                    </div>


                </div>


                {{-- BOUTON --}}
                <div class="teacher-reg-submit-area">

                    <button
                        type="submit"
                        class="teacher-reg-submit"
                    >
                        Créer mon compte enseignant
                    </button>

                </div>


            </form>

        </div>

    </div>

</div>


</div>

@endsection
