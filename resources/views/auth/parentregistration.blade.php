@extends('layouts.login_master')

@section('content')

<style>
    /* =========================================
       INSCRIPTION PARENT
       ========================================= */

    .parent-reg-page {
        width: 100%;
        min-height: 100vh;
        padding: 40px 20px;
        background: #f4f6f9;
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }

    .parent-reg-wrapper {
        width: 100%;
        max-width: 1000px;
    }

    .parent-reg-box {
        width: 100%;
        background: #ffffff !important;
        border: 1px solid #dddddd;
        border-radius: 10px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        overflow: hidden;
    }

    .parent-reg-header {
        padding: 25px 30px;
        text-align: center;
    }

    .parent-reg-logo {
        max-width: 180px;
        max-height: 80px;
        margin: 0 auto 15px;
        display: block;
    }

    .parent-reg-header-title {
        margin: 0;
        color: #000000 !important;
        font-size: 26px;
        font-weight: 600;
    }

    .parent-reg-header-text {
        margin: 7px 0 0;
        color: #010101 !important;
        font-size: 14px;
    }

    .parent-reg-body {
        background: #ffffff !important;
        padding: 35px;
    }

    .parent-reg-section-title {
        margin: 35px 0 25px;
        padding-bottom: 12px;
        border-bottom: 2px solid #eeeeee;
        color: #333333 !important;
        font-size: 20px;
        font-weight: 600;
    }

    .parent-reg-section-title:first-of-type {
        margin-top: 0;
    }

    .parent-reg-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px 25px;
    }

    .parent-reg-field {
        width: 100%;
    }

    .parent-reg-field-full {
        grid-column: 1 / -1;
    }

    .parent-reg-label {
        display: block;
        margin-bottom: 7px;
        color: #333333 !important;
        font-size: 14px;
        font-weight: 600;
    }

    .parent-reg-required {
        color: #e53935 !important;
    }

    .parent-reg-input,
    .parent-reg-select,
    .parent-reg-textarea {
        display: block;
        width: 100%;
        padding: 10px 13px;
        background: #ffffff !important;
        color: #333333 !important;
        border: 1px solid #bdbdbd !important;
        border-radius: 5px;
        outline: none !important;
        font-size: 14px;
        box-sizing: border-box;
        font-family: inherit;
    }

    .parent-reg-input,
    .parent-reg-select {
        height: 44px;
    }

    .parent-reg-textarea {
        min-height: 90px;
        resize: vertical;
    }

    .parent-reg-input::placeholder,
    .parent-reg-textarea::placeholder {
        color: #999999 !important;
        opacity: 1 !important;
    }

    .parent-reg-input:focus,
    .parent-reg-select:focus,
    .parent-reg-textarea:focus {
        background: #ffffff !important;
        color: #333333 !important;
        border-color: #2196f3 !important;
        box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.12) !important;
    }

    .parent-reg-select option {
        background: #ffffff !important;
        color: #333333 !important;
    }

    .parent-reg-help {
        display: block;
        margin-top: 6px;
        color: #777777 !important;
        font-size: 12px;
    }

    .parent-reg-alert-danger {
        margin-bottom: 25px;
        padding: 15px 18px;
        background: #f8d7da !important;
        color: #721c24 !important;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
    }

    .parent-reg-alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }

    .parent-reg-alert-danger li {
        color: #721c24 !important;
    }

    .parent-reg-alert-success {
        margin-bottom: 25px;
        padding: 15px 18px;
        text-align: center;
        background: #d4edda !important;
        color: #155724 !important;
        border: 1px solid #c3e6cb;
        border-radius: 5px;
    }

    .parent-reg-submit-area {
        margin-top: 30px;
        padding-top: 25px;
        border-top: 1px solid #eeeeee;
        text-align: center;
    }

    .parent-reg-submit {
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

    .parent-reg-submit:hover {
        background: #1976d2 !important;
        border-color: #1976d2 !important;
        color: #ffffff !important;
    }

    @media (max-width: 767px) {

        .parent-reg-page {
            padding: 20px 10px;
        }

        .parent-reg-body {
            padding: 25px 20px;
        }

        .parent-reg-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .parent-reg-header-title {
            font-size: 22px;
        }

        .parent-reg-submit {
            width: 100%;
        }
    }
</style>

<div style="background-image: url(/global_assets/images/login_covereco.png)" class="parent-reg-page">

    <div class="parent-reg-wrapper">

        <div class="parent-reg-box">

            {{-- EN-TÊTE --}}
            <div class="parent-reg-header">

                <img
                    src="https://madaure.vercel.app/assets/images/logo/logo.png"
                    alt="Logo"
                    class="parent-reg-logo"
                    onerror="this.style.display='none';"
                >

                <h3 class="parent-reg-header-title">
                    Inscription Parent
                </h3>

                <p class="parent-reg-header-text">
                    Créez votre dossier d'inscription — votre dossier sera examiné par l'administration.
                </p>

            </div>


            {{-- CORPS --}}
            <div class="parent-reg-body">


                {{-- ERREURS --}}
                @if ($errors->any())

                    <div class="parent-reg-alert-danger">

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

                    <div class="parent-reg-alert-success">
                        {{ session('success') }}
                    </div>

                @endif


                <form
                    method="POST"
                    action="{{ route('parent.registration.store') }}"
                    class="parent-reg-form"
                >

                    @csrf


                    {{-- ==================================================
                         INFORMATIONS DU PARENT
                         ================================================== --}}
                    <h4 class="parent-reg-section-title">
                        Informations du parent
                    </h4>

                    <div class="parent-reg-grid">

                        {{-- NOM ET PRÉNOM --}}
                        <div class="parent-reg-field parent-reg-field-full">

                            <label class="parent-reg-label">
                                Nom et prénom <span class="parent-reg-required">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Nom et prénom du parent"
                                class="parent-reg-input"
                                required
                            >

                        </div>


                        {{-- EMAIL --}}
                        <div class="parent-reg-field">

                            <label class="parent-reg-label">
                                E-mail <span class="parent-reg-required">*</span>
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="parent@email.com"
                                class="parent-reg-input"
                                required
                            >

                        </div>


                        {{-- TÉLÉPHONE --}}
                        <div class="parent-reg-field">

                            <label class="parent-reg-label">
                                Téléphone portable <span class="parent-reg-required">*</span>
                            </label>

                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="+213 XX XX XX XX"
                                class="parent-reg-input"
                                required
                            >

                        </div>


                        {{-- DEUXIÈME TÉLÉPHONE --}}
                        <div class="parent-reg-field">

                            <label class="parent-reg-label">
                                Deuxième téléphone
                            </label>

                            <input
                                type="text"
                                name="phone2"
                                value="{{ old('phone2') }}"
                                placeholder="+213 XX XX XX XX"
                                class="parent-reg-input"
                            >

                        </div>


                        {{-- DATE D'INSCRIPTION --}}
                        <div class="parent-reg-field">

                            <label class="parent-reg-label">
                                Date d'inscription <span class="parent-reg-required">*</span>
                            </label>

                            <input
                                type="date"
                                name="registration_date"
                                value="{{ old('registration_date', date('Y-m-d')) }}"
                                class="parent-reg-input"
                                required
                            >

                        </div>


                        {{-- NOMBRE D'ENFANTS --}}
                        <div class="parent-reg-field">

                            <label class="parent-reg-label">
                                Nombre d'enfants <span class="parent-reg-required">*</span>
                            </label>

                            <select
                                name="number_of_children"
                                class="parent-reg-select"
                                required
                            >

                                <option value="">Sélectionnez...</option>

                                <option value="1" {{ old('number_of_children') == '1' ? 'selected' : '' }}>
                                    1
                                </option>

                                <option value="2" {{ old('number_of_children') == '2' ? 'selected' : '' }}>
                                    2
                                </option>

                                <option value="3" {{ old('number_of_children') == '3' ? 'selected' : '' }}>
                                    3
                                </option>

                                <option value="4" {{ old('number_of_children') == '4' ? 'selected' : '' }}>
                                    Autre
                                </option>

                            </select>

                        </div>


                        {{-- ADRESSE --}}
                        <div class="parent-reg-field parent-reg-field-full">

                            <label class="parent-reg-label">
                                Adresse
                            </label>

                            <textarea
                                name="address"
                                placeholder="Adresse de résidence du parent"
                                class="parent-reg-textarea"
                            >{{ old('address') }}</textarea>

                        </div>

                    </div>


                    {{-- ==================================================
                         SCOLARITÉ
                         ================================================== --}}
                    <h4 class="parent-reg-section-title">
                        Scolarité
                    </h4>

                    <div class="parent-reg-grid">


                        {{-- ÉCOLE PRÉCÉDENTE --}}
                        <div class="parent-reg-field">

                            <label class="parent-reg-label">
                                École précédente <span class="parent-reg-required">*</span>
                            </label>

                            <input
                                type="text"
                                name="previous_school"
                                value="{{ old('previous_school') }}"
                                placeholder="Nom de l'établissement"
                                class="parent-reg-input"
                                required
                            >

                        </div>


                        {{-- PROGRAMME --}}
                        <div class="parent-reg-field">

                            <label class="parent-reg-label">
                                Programme déjà étudié <span class="parent-reg-required">*</span>
                            </label>

                            <select
                                name="studied_program"
                                class="parent-reg-select"
                                required
                            >

                                <option value="">Sélectionnez...</option>

                                <option value="National"
                                    {{ old('studied_program') == 'National' ? 'selected' : '' }}>
                                    National
                                </option>

                                <option value="Français"
                                    {{ old('studied_program') == 'Français' ? 'selected' : '' }}>
                                    Français
                                </option>

                                <option value="Britannique"
                                    {{ old('studied_program') == 'Britannique' ? 'selected' : '' }}>
                                    Britannique
                                </option>

                                <option value="Autre"
                                    {{ old('studied_program') == 'Autre' ? 'selected' : '' }}>
                                    Autre
                                </option>

                            </select>

                        </div>


                        {{-- NIVEAU --}}
                        <div class="parent-reg-field parent-reg-field-full">

                            <label class="parent-reg-label">
                                Niveau demandé <span class="parent-reg-required">*</span>
                            </label>

                            <select
                                name="requested_level"
                                class="parent-reg-select"
                                required
                            >

                                <option value="">Sélectionnez...</option>

                                <option value="5eme"
                                    {{ old('requested_level') == '5eme' ? 'selected' : '' }}>
                                    5ème
                                </option>

                                <option value="4eme"
                                    {{ old('requested_level') == '4eme' ? 'selected' : '' }}>
                                    4ème
                                </option>

                                <option value="3eme-DNB"
                                    {{ old('requested_level') == '3eme-DNB' ? 'selected' : '' }}>
                                    3ème - DNB
                                </option>

                                <option value="Seconde"
                                    {{ old('requested_level') == 'Seconde' ? 'selected' : '' }}>
                                    Seconde
                                </option>

                                <option value="Première"
                                    {{ old('requested_level') == 'Première' ? 'selected' : '' }}>
                                    Première
                                </option>

                                <option value="Terminale"
                                    {{ old('requested_level') == 'Terminale' ? 'selected' : '' }}>
                                    Terminale
                                </option>

                                <option value="Autre"
                                    {{ old('requested_level') == 'Autre' ? 'selected' : '' }}>
                                    Autre
                                </option>

                            </select>

                        </div>

                    </div>


                    {{-- ==================================================
                         INFORMATIONS DE L'ÉLÈVE
                         ================================================== --}}
                    <h4 class="parent-reg-section-title">
                        Informations de l'élève
                    </h4>

                    <div class="parent-reg-grid">


                        {{-- NOM ÉLÈVE --}}
                        <div class="parent-reg-field parent-reg-field-full">

                            <label class="parent-reg-label">
                                Nom et prénom de l'élève <span class="parent-reg-required">*</span>
                            </label>

                            <input
                                type="text"
                                name="student_name"
                                value="{{ old('student_name') }}"
                                placeholder="Nom et prénom de l'élève"
                                class="parent-reg-input"
                                required
                            >

                        </div>


                        {{-- DATE DE NAISSANCE --}}
                        <div class="parent-reg-field">

                            <label class="parent-reg-label">
                                Date de naissance <span class="parent-reg-required">*</span>
                            </label>

                            <input
                                type="date"
                                name="student_date_of_birth"
                                value="{{ old('student_date_of_birth') }}"
                                class="parent-reg-input"
                                required
                            >

                        </div>


                        {{-- LIEU DE NAISSANCE --}}
                        <div class="parent-reg-field">

                            <label class="parent-reg-label">
                                Lieu de naissance <span class="parent-reg-required">*</span>
                            </label>

                            <input
                                type="text"
                                name="student_place_of_birth"
                                value="{{ old('student_place_of_birth') }}"
                                placeholder="Ville de naissance"
                                class="parent-reg-input"
                                required
                            >

                        </div>


                        {{-- ADRESSE ÉLÈVE --}}
                        <div class="parent-reg-field parent-reg-field-full">

                            <label class="parent-reg-label">
                                Adresse de l'élève <span class="parent-reg-required">*</span>
                            </label>

                            <textarea
                                name="student_address"
                                placeholder="Adresse de résidence de l'élève"
                                class="parent-reg-textarea"
                                required
                            >{{ old('student_address') }}</textarea>

                        </div>


                        {{-- STATUT --}}
                        <div class="parent-reg-field parent-reg-field-full">

                            <label class="parent-reg-label">
                                Statut de l'élève <span class="parent-reg-required">*</span>
                            </label>

                            <select
                                name="student_status"
                                class="parent-reg-select"
                                required
                            >

                                <option value="">Sélectionnez...</option>

                                <option value="Candidat Libre"
                                    {{ old('student_status') == 'Candidat Libre' ? 'selected' : '' }}>
                                    Candidat Libre
                                </option>

                                <option value="CNED"
                                    {{ old('student_status') == 'CNED' ? 'selected' : '' }}>
                                    CNED
                                </option>

                                <option value="Étudiant"
                                    {{ old('student_status') == 'Étudiant' ? 'selected' : '' }}>
                                    Étudiant
                                </option>

                                <option value="Autre"
                                    {{ old('student_status') == 'Autre' ? 'selected' : '' }}>
                                    Autre
                                </option>

                            </select>

                        </div>

                    </div>


                    {{-- ==================================================
                         INFORMATIONS ACADÉMIQUES
                         ================================================== --}}
                    <h4 class="parent-reg-section-title">
                        Informations académiques
                    </h4>

                    <div class="parent-reg-grid">


                        {{-- MATIÈRE ABANDONNÉE --}}
                        <div class="parent-reg-field">

                            <label class="parent-reg-label">
                                Matière abandonnée en Première
                            </label>

                            <select
                                name="dropped_subject"
                                class="parent-reg-select"
                            >

                                <option value="">Sélectionnez...</option>

                                <option value="Physique-chimie"
                                    {{ old('dropped_subject') == 'Physique-chimie' ? 'selected' : '' }}>
                                    Physique-chimie
                                </option>

                                <option value="SVT"
                                    {{ old('dropped_subject') == 'SVT' ? 'selected' : '' }}>
                                    SVT
                                </option>

                                <option value="SES"
                                    {{ old('dropped_subject') == 'SES' ? 'selected' : '' }}>
                                    SES
                                </option>

                                <option value="Non concerné"
                                    {{ old('dropped_subject') == 'Non concerné' ? 'selected' : '' }}>
                                    Non concerné
                                </option>

                                <option value="Autre"
                                    {{ old('dropped_subject') == 'Autre' ? 'selected' : '' }}>
                                    Autre
                                </option>

                            </select>

                        </div>


                        {{-- SPÉCIALITÉS TERMINALE --}}
                        <div class="parent-reg-field">

                            <label class="parent-reg-label">
                                Spécialités Terminale
                            </label>

                            <select
                                name="terminal_specialties"
                                class="parent-reg-select"
                            >

                                <option value="">Sélectionnez...</option>

                                <option value="Mathématiques"
                                    {{ old('terminal_specialties') == 'Mathématiques' ? 'selected' : '' }}>
                                    Mathématiques
                                </option>

                                <option value="Physique-chimie"
                                    {{ old('terminal_specialties') == 'Physique-chimie' ? 'selected' : '' }}>
                                    Physique-chimie
                                </option>

                                <option value="SVT"
                                    {{ old('terminal_specialties') == 'SVT' ? 'selected' : '' }}>
                                    SVT
                                </option>

                                <option value="SES"
                                    {{ old('terminal_specialties') == 'SES' ? 'selected' : '' }}>
                                    SES
                                </option>

                                <option value="Non concerné"
                                    {{ old('terminal_specialties') == 'Non concerné' ? 'selected' : '' }}>
                                    Non concerné
                                </option>

                            </select>

                        </div>


                        {{-- LANGUES --}}
                        <div class="parent-reg-field parent-reg-field-full">

                            <label class="parent-reg-label">
                                Langues <span class="parent-reg-required">*</span>
                            </label>

                            <select
                                name="languages"
                                class="parent-reg-select"
                                required
                            >

                                <option value="">Sélectionnez...</option>

                                <option value="Arabe"
                                    {{ old('languages') == 'Arabe' ? 'selected' : '' }}>
                                    Arabe
                                </option>

                                <option value="Anglais"
                                    {{ old('languages') == 'Anglais' ? 'selected' : '' }}>
                                    Anglais
                                </option>

                                <option value="Espagnol"
                                    {{ old('languages') == 'Espagnol' ? 'selected' : '' }}>
                                    Espagnol
                                </option>

                                <option value="Autre"
                                    {{ old('languages') == 'Autre' ? 'selected' : '' }}>
                                    Autre
                                </option>

                            </select>

                        </div>

                    </div>


                    {{-- ==================================================
                         BESOINS ÉDUCATIFS
                         ================================================== --}}
                    <h4 class="parent-reg-section-title">
                        Besoins éducatifs particuliers
                    </h4>

                    <div class="parent-reg-grid">

                        <div class="parent-reg-field parent-reg-field-full">

                            <label class="parent-reg-label">
                                Besoins éducatifs <span class="parent-reg-required">*</span>
                            </label>

                            <select
                                name="educational_needs"
                                class="parent-reg-select"
                                required
                            >

                                <option value="">Sélectionnez...</option>

                                <option value="Rien"
                                    {{ old('educational_needs') == 'Rien' ? 'selected' : '' }}>
                                    Rien
                                </option>

                                <option value="Dyslexie"
                                    {{ old('educational_needs') == 'Dyslexie' ? 'selected' : '' }}>
                                    Dyslexie
                                </option>

                                <option value="TDAH"
                                    {{ old('educational_needs') == 'TDAH' ? 'selected' : '' }}>
                                    TDAH
                                </option>

                                <option value="Autre"
                                    {{ old('educational_needs') == 'Autre' ? 'selected' : '' }}>
                                    Autre
                                </option>

                            </select>

                        </div>

                    </div>


                    {{-- ==================================================
                         ACTIVITÉS EXTRASCOLAIRES
                         ================================================== --}}
                    <h4 class="parent-reg-section-title">
                        Activités extrascolaires
                    </h4>

                    <div class="parent-reg-grid">


                        {{-- ACTIVITÉS --}}
                        <div class="parent-reg-field parent-reg-field-full">

                            <label class="parent-reg-label">
                                Activités extrascolaires
                            </label>

                            <textarea
                                name="extracurricular_activities"
                                placeholder="Sports, musique, arts, autres activités..."
                                class="parent-reg-textarea"
                            >{{ old('extracurricular_activities') }}</textarea>

                        </div>


                        {{-- CLUBS --}}
                        <div class="parent-reg-field parent-reg-field-full">

                            <label class="parent-reg-label">
                                Clubs qui vous intéressent
                            </label>

                            <textarea
                                name="interested_clubs"
                                placeholder="Indiquez les clubs ou activités qui pourraient vous intéresser..."
                                class="parent-reg-textarea"
                            >{{ old('interested_clubs') }}</textarea>

                        </div>

                    </div>


                    {{-- ==================================================
                         RENSEIGNEMENTS COMPLÉMENTAIRES
                         ================================================== --}}
                    <h4 class="parent-reg-section-title">
                        Renseignements complémentaires
                    </h4>

                    <div class="parent-reg-grid">


                        {{-- COMMENT AVEZ-VOUS CONNU L'ÉCOLE --}}
                        <div class="parent-reg-field parent-reg-field-full">

                            <label class="parent-reg-label">
                                Comment avez-vous connu l'école ?
                                <span class="parent-reg-required">*</span>
                            </label>

                            <select
                                name="how_did_you_hear"
                                class="parent-reg-select"
                                required
                            >

                                <option value="">Sélectionnez...</option>

                                <option value="Publicité"
                                    {{ old('how_did_you_hear') == 'Publicité' ? 'selected' : '' }}>
                                    Publicité
                                </option>

                                <option value="Bouche à oreille"
                                    {{ old('how_did_you_hear') == 'Bouche à oreille' ? 'selected' : '' }}>
                                    Bouche à oreille
                                </option>

                                <option value="Réseaux sociaux"
                                    {{ old('how_did_you_hear') == 'Réseaux sociaux' ? 'selected' : '' }}>
                                    Réseaux sociaux
                                </option>

                                <option value="Recommandation ancien élève"
                                    {{ old('how_did_you_hear') == 'Recommandation ancien élève' ? 'selected' : '' }}>
                                    Recommandation d'un ancien élève
                                </option>

                                <option value="Autre"
                                    {{ old('how_did_you_hear') == 'Autre' ? 'selected' : '' }}>
                                    Autre
                                </option>

                            </select>

                        </div>


                        {{-- INFORMATIONS SUPPLÉMENTAIRES --}}
                        <div class="parent-reg-field parent-reg-field-full">

                            <label class="parent-reg-label">
                                Informations supplémentaires
                                <span class="parent-reg-required">*</span>
                            </label>

                            <textarea
                                name="additional_information"
                                placeholder="Toute information complémentaire que vous souhaitez communiquer à l'administration..."
                                class="parent-reg-textarea"
                                required
                            >{{ old('additional_information') }}</textarea>

                        </div>

                    </div>


                    {{-- ==================================================
                         CRÉATION DU COMPTE
                         ================================================== --}}
                    <h4 class="parent-reg-section-title">
                        Création du compte
                    </h4>

                    <div class="parent-reg-grid">


                        {{-- MOT DE PASSE --}}
                        <div class="parent-reg-field">

                            <label class="parent-reg-label">
                                Mot de passe <span class="parent-reg-required">*</span>
                            </label>

                            <input
                                type="password"
                                name="password"
                                placeholder="Votre mot de passe"
                                class="parent-reg-input"
                                required
                            >

                        </div>


                        {{-- CONFIRMATION --}}
                        <div class="parent-reg-field">

                            <label class="parent-reg-label">
                                Confirmer le mot de passe <span class="parent-reg-required">*</span>
                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                placeholder="Confirmez votre mot de passe"
                                class="parent-reg-input"
                                required
                            >

                        </div>

                    </div>


                    {{-- ==================================================
                         APPROBATION
                         ================================================== --}}
                    <div class="parent-reg-submit-area">

                        <p class="parent-reg-help" style="margin-bottom: 20px; font-size: 13px;">
                            Après l'envoi de votre dossier, votre compte sera examiné par
                            l'administration. Vous pourrez vous connecter une fois votre
                            compte approuvé.
                        </p>

                        <button
                            type="submit"
                            class="parent-reg-submit"
                        >
                            Envoyer le dossier d'inscription
                        </button>

                    </div>


                </form>

            </div>

        </div>

    </div>

</div>

@endsection