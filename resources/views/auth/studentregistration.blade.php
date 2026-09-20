@extends('layouts.login_master')

@section('content')

<style>
    /* =========================================
       INSCRIPTION ÉLÈVE
       ========================================= */

    .student-reg-page {
        width: 100%;
        min-height: 100vh;
        padding: 40px 20px;
        background: #f4f6f9;
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }

    .student-reg-wrapper {
        width: 100%;
        max-width: 1000px;
    }

    .student-reg-box {
        width: 100%;
        background: #ffffff !important;
        border: 1px solid #dddddd;
        border-radius: 10px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        overflow: hidden;
    }

    .student-reg-header {
        padding: 25px 30px;
        text-align: center;
    }

    .student-reg-logo {
        max-width: 180px;
        max-height: 80px;
        margin: 0 auto 15px;
        display: block;
    }

    .student-reg-header-title {
        margin: 0;
        color: #000000 !important;
        font-size: 26px;
        font-weight: 600;
    }

    .student-reg-header-text {
        margin: 7px 0 0;
        color: #010101 !important;
        font-size: 14px;
    }

    .student-reg-body {
        background: #ffffff !important;
        padding: 35px;
    }

    .student-reg-section-title {
        margin: 35px 0 25px;
        padding-bottom: 12px;
        border-bottom: 2px solid #eeeeee;
        color: #333333 !important;
        font-size: 20px;
        font-weight: 600;
    }

    .student-reg-section-title:first-of-type {
        margin-top: 0;
    }

    .student-reg-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px 25px;
    }

    .student-reg-field {
        width: 100%;
    }

    .student-reg-field-full {
        grid-column: 1 / -1;
    }

    .student-reg-label {
        display: block;
        margin-bottom: 7px;
        color: #333333 !important;
        font-size: 14px;
        font-weight: 600;
    }

    .student-reg-required {
        color: #e53935 !important;
    }

    .student-reg-input,
    .student-reg-select,
    .student-reg-textarea {
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

    .student-reg-input,
    .student-reg-select {
        height: 44px;
    }

    .student-reg-textarea {
        min-height: 90px;
        resize: vertical;
    }

    .student-reg-input::placeholder,
    .student-reg-textarea::placeholder {
        color: #999999 !important;
        opacity: 1 !important;
    }

    .student-reg-input:focus,
    .student-reg-select:focus,
    .student-reg-textarea:focus {
        background: #ffffff !important;
        color: #333333 !important;
        border-color: #2196f3 !important;
        box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.12) !important;
    }

    .student-reg-select option {
        background: #ffffff !important;
        color: #333333 !important;
    }

    .student-reg-file {
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

    .student-reg-help {
        display: block;
        margin-top: 6px;
        color: #777777 !important;
        font-size: 12px;
    }

    .student-reg-alert-danger {
        margin-bottom: 25px;
        padding: 15px 18px;
        background: #f8d7da !important;
        color: #721c24 !important;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
    }

    .student-reg-alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }

    .student-reg-alert-danger li {
        color: #721c24 !important;
    }

    .student-reg-alert-success {
        margin-bottom: 25px;
        padding: 15px 18px;
        text-align: center;
        background: #d4edda !important;
        color: #155724 !important;
        border: 1px solid #c3e6cb;
        border-radius: 5px;
    }

    .student-reg-submit-area {
        margin-top: 30px;
        padding-top: 25px;
        border-top: 1px solid #eeeeee;
        text-align: center;
    }

    .student-reg-submit {
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

    .student-reg-submit:hover {
        background: #1976d2 !important;
        border-color: #1976d2 !important;
        color: #ffffff !important;
    }

    @media (max-width: 767px) {

        .student-reg-page {
            padding: 20px 10px;
        }

        .student-reg-body {
            padding: 25px 20px;
        }

        .student-reg-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .student-reg-header-title {
            font-size: 22px;
        }

        .student-reg-submit {
            width: 100%;
        }
    }
</style>

<div style="background-image: url(/global_assets/images/login_covereco.png)" class="student-reg-page">

    <div class="student-reg-wrapper">

        <div class="student-reg-box">

            {{-- EN-TÊTE --}}
            <div class="student-reg-header">

                <img
                    src="https://madaure.vercel.app/assets/images/logo/logo.png"
                    alt="Logo"
                    class="student-reg-logo"
                    onerror="this.style.display='none';"
                >

                <h3 class="student-reg-header-title">
                    Inscription Élève
                </h3>

                <p class="student-reg-header-text">
                    Créez le dossier d'inscription de l'élève — votre dossier sera examiné par l'administration.
                </p>

            </div>

            {{-- CORPS --}}
            <div class="student-reg-body">

                {{-- ERREURS --}}
                @if ($errors->any())

                    <div class="student-reg-alert-danger">

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

                    <div class="student-reg-alert-success">
                        {{ session('success') }}
                    </div>

                @endif

                <form
                    method="POST"
                    enctype="multipart/form-data"
                    action="{{ route('student.registration.store') }}"
                    class="student-reg-form"
                >

                    @csrf

                    {{-- ==================================================
                         INFORMATIONS DE L'ÉLÈVE
                         ================================================== --}}
                    <h4 class="student-reg-section-title">
                        Informations de l'élève
                    </h4>

                    <div class="student-reg-grid">

                        {{-- NOM COMPLET --}}
                        <div class="student-reg-field student-reg-field-full">
                            <label class="student-reg-label">
                                Nom complet <span class="student-reg-required">*</span>
                            </label>

                            <input
                                type="text"
                                name="full_name"
                                value="{{ old('full_name') }}"
                                placeholder="Nom et prénom de l'élève"
                                class="student-reg-input"
                                required
                            >
                        </div>

                        {{-- PRÉNOM --}}
                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                Prénom
                            </label>

                            <input
                                type="text"
                                name="first_name"
                                value="{{ old('first_name') }}"
                                placeholder="Prénom"
                                class="student-reg-input"
                            >
                        </div>

                        {{-- NOM --}}
                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                Nom
                            </label>

                            <input
                                type="text"
                                name="last_name"
                                value="{{ old('last_name') }}"
                                placeholder="Nom"
                                class="student-reg-input"
                            >
                        </div>

                        {{-- DATE DE NAISSANCE --}}
                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                Date de naissance
                                <span class="student-reg-required">*</span>
                            </label>

                            <input
                                type="date"
                                name="date_of_birth"
                                value="{{ old('date_of_birth') }}"
                                class="student-reg-input"
                                required
                            >
                        </div>

                        {{-- LIEU DE NAISSANCE --}}
                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                Lieu de naissance
                            </label>

                            <input
                                type="text"
                                name="place_of_birth"
                                value="{{ old('place_of_birth') }}"
                                placeholder="Ville de naissance"
                                class="student-reg-input"
                            >
                        </div>

                        {{-- EMAIL DU PARENT --}}
                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                E-mail du parent
                                <span class="student-reg-required">*</span>
                            </label>

                            <input
                                type="email"
                                name="parent_email"
                                value="{{ old('parent_email') }}"
                                placeholder="parent@email.com"
                                class="student-reg-input"
                                required
                            >
                        </div>

                        {{-- SEXE --}}
                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                Sexe
                                <span class="student-reg-required">*</span>
                            </label>

                            <select
                                name="gender"
                                class="student-reg-select"
                                required
                            >
                                <option value="">Sélectionnez...</option>

                                <option
                                    value="Male"
                                    {{ old('gender') == 'Male' ? 'selected' : '' }}
                                >
                                    Garçon
                                </option>

                                <option
                                    value="Female"
                                    {{ old('gender') == 'Female' ? 'selected' : '' }}
                                >
                                    Fille
                                </option>
                            </select>
                        </div>

                        {{-- NATIONALITÉ --}}
                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                Nationalité
                            </label>

                            <input
                                type="text"
                                name="nationality"
                                value="{{ old('nationality', 'Algérienne') }}"
                                placeholder="Nationalité"
                                class="student-reg-input"
                            >
                        </div>

                        {{-- PHOTO --}}
                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                Photo d'identité
                            </label>

                            <input
                                type="file"
                                name="photo"
                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                class="student-reg-file"
                            >

                            <small class="student-reg-help">
                                Formats acceptés : JPEG, JPG, PNG, WEBP — Taille maximale : 5 Mo.
                            </small>
                        </div>

                    </div>

                    {{-- ==================================================
                         ADRESSE
                         ================================================== --}}
                    <h4 class="student-reg-section-title">
                        Adresse
                    </h4>

                    <div class="student-reg-grid">

                        <div class="student-reg-field student-reg-field-full">
                            <label class="student-reg-label">
                                Adresse
                            </label>

                            <input
                                type="text"
                                name="address"
                                value="{{ old('address') }}"
                                placeholder="Adresse de résidence"
                                class="student-reg-input"
                            >
                        </div>

                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                Ville
                            </label>

                            <input
                                type="text"
                                name="city"
                                value="{{ old('city') }}"
                                placeholder="Ville"
                                class="student-reg-input"
                            >
                        </div>

                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                Pays
                            </label>

                            <input
                                type="text"
                                name="country"
                                value="{{ old('country', 'Algérie') }}"
                                placeholder="Pays"
                                class="student-reg-input"
                            >
                        </div>

                    </div>

                    {{-- ==================================================
                         SCOLARITÉ ET PROGRAMME SOUHAITÉ
                         ================================================== --}}
                    <h4 class="student-reg-section-title">
                        Scolarité et programme souhaité
                    </h4>

                    <div class="student-reg-grid">

                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                École actuelle
                            </label>

                            <input
                                type="text"
                                name="current_school"
                                value="{{ old('current_school') }}"
                                placeholder="Établissement actuel"
                                class="student-reg-input"
                            >
                        </div>

                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                Niveau actuel
                            </label>

                            <input
                                type="text"
                                name="current_level"
                                value="{{ old('current_level') }}"
                                placeholder="Ex : 5ème année primaire"
                                class="student-reg-input"
                            >
                        </div>

                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                École précédente
                            </label>

                            <input
                                type="text"
                                name="previous_school"
                                value="{{ old('previous_school') }}"
                                placeholder="Établissement précédent (si applicable)"
                                class="student-reg-input"
                            >
                        </div>

                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                Programme souhaité
                                <span class="student-reg-required">*</span>
                            </label>

                            <input
                                type="text"
                                name="program"
                                value="{{ old('program') }}"
                                placeholder="Ex : Primaire, Collège, Lycée"
                                class="student-reg-input"
                                required
                            >
                        </div>

                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                Niveau demandé
                                <span class="student-reg-required">*</span>
                            </label>

                            <input
                                type="text"
                                name="requested_level"
                                value="{{ old('requested_level') }}"
                                placeholder="Ex : 1ère année"
                                class="student-reg-input"
                                required
                            >
                        </div>

                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                Année scolaire
                            </label>

                            <input
                                type="text"
                                name="academic_year"
                                value="{{ old('academic_year') }}"
                                placeholder="Ex : 2026/2027"
                                class="student-reg-input"
                            >
                        </div>

                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                Date de rentrée souhaitée
                            </label>

                            <input
                                type="date"
                                name="desired_start_date"
                                value="{{ old('desired_start_date') }}"
                                class="student-reg-input"
                            >
                        </div>

                        <div class="student-reg-field student-reg-field-full">
                            <label class="student-reg-label">
                                Notes académiques
                            </label>

                            <textarea
                                name="academic_notes"
                                placeholder="Informations utiles sur le parcours scolaire de l'élève"
                                class="student-reg-textarea"
                            >{{ old('academic_notes') }}</textarea>
                        </div>

                    </div>

                    {{-- ==================================================
                         PARENT / TUTEUR
                         ================================================== --}}
                    <h4 class="student-reg-section-title">
                        Informations du parent / tuteur
                    </h4>

                    <div class="student-reg-grid">

                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                Nom complet du parent
                                <span class="student-reg-required">*</span>
                            </label>

                            <input
                                type="text"
                                name="parent_name"
                                value="{{ old('parent_name') }}"
                                placeholder="Nom et prénom du parent/tuteur"
                                class="student-reg-input"
                                required
                            >
                        </div>

                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                Lien de parenté
                            </label>

                            <select
                                name="parent_relationship"
                                class="student-reg-select"
                            >
                                <option value="">Sélectionnez...</option>

                                <option
                                    value="Père"
                                    {{ old('parent_relationship') == 'Père' ? 'selected' : '' }}
                                >
                                    Père
                                </option>

                                <option
                                    value="Mère"
                                    {{ old('parent_relationship') == 'Mère' ? 'selected' : '' }}
                                >
                                    Mère
                                </option>

                                <option
                                    value="Tuteur"
                                    {{ old('parent_relationship') == 'Tuteur' ? 'selected' : '' }}
                                >
                                    Tuteur légal
                                </option>

                                <option
                                    value="Autre"
                                    {{ old('parent_relationship') == 'Autre' ? 'selected' : '' }}
                                >
                                    Autre
                                </option>
                            </select>
                        </div>

                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                Téléphone du parent
                                <span class="student-reg-required">*</span>
                            </label>

                            <input
                                type="text"
                                name="parent_phone"
                                value="{{ old('parent_phone') }}"
                                placeholder="+213 XX XX XX XX"
                                class="student-reg-input"
                                required
                            >
                        </div>

                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                WhatsApp
                            </label>

                            <input
                                type="text"
                                name="parent_whatsapp"
                                value="{{ old('parent_whatsapp') }}"
                                placeholder="+213 XX XX XX XX"
                                class="student-reg-input"
                            >
                        </div>

                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                Profession du parent
                            </label>

                            <input
                                type="text"
                                name="parent_occupation"
                                value="{{ old('parent_occupation') }}"
                                placeholder="Profession"
                                class="student-reg-input"
                            >
                        </div>

                        <div class="student-reg-field student-reg-field-full">
                            <label class="student-reg-label">
                                Adresse du parent
                            </label>

                            <input
                                type="text"
                                name="parent_address"
                                value="{{ old('parent_address') }}"
                                placeholder="Si différente de l'adresse de l'élève"
                                class="student-reg-input"
                            >
                        </div>

                    </div>

                    {{-- ==================================================
                         CONTACT D'URGENCE
                         ================================================== --}}
                    <h4 class="student-reg-section-title">
                        Contact d'urgence
                    </h4>

                    <div class="student-reg-grid">

                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                Nom
                            </label>

                            <input
                                type="text"
                                name="emergency_name"
                                value="{{ old('emergency_name') }}"
                                placeholder="Nom du contact d'urgence"
                                class="student-reg-input"
                            >
                        </div>

                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                Lien de parenté
                            </label>

                            <input
                                type="text"
                                name="emergency_relationship"
                                value="{{ old('emergency_relationship') }}"
                                placeholder="Ex : Oncle, Tante, Voisin"
                                class="student-reg-input"
                            >
                        </div>

                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                Téléphone
                            </label>

                            <input
                                type="text"
                                name="emergency_phone"
                                value="{{ old('emergency_phone') }}"
                                placeholder="+213 XX XX XX XX"
                                class="student-reg-input"
                            >
                        </div>

                    </div>

                    {{-- ==================================================
                         INFORMATIONS COMPLÉMENTAIRES
                         ================================================== --}}
                    <h4 class="student-reg-section-title">
                        Informations complémentaires
                    </h4>

                    <div class="student-reg-grid">

                        <div class="student-reg-field student-reg-field-full">
                            <label class="student-reg-label">
                                Informations médicales
                            </label>

                            <textarea
                                name="medical_notes"
                                placeholder="Allergies, traitements, conditions particulières..."
                                class="student-reg-textarea"
                            >{{ old('medical_notes') }}</textarea>
                        </div>

                        <div class="student-reg-field">
                            <label class="student-reg-label">
                                Comment avez-vous connu l'école ?
                            </label>

                            <input
                                type="text"
                                name="how_did_you_hear"
                                value="{{ old('how_did_you_hear') }}"
                                placeholder="Ex : Réseaux sociaux, bouche à oreille..."
                                class="student-reg-input"
                            >
                        </div>

                        <div class="student-reg-field student-reg-field-full">
                            <label class="student-reg-label">
                                Commentaires additionnels
                            </label>

                            <textarea
                                name="additional_comments"
                                placeholder="Toute information utile pour l'administration"
                                class="student-reg-textarea"
                            >{{ old('additional_comments') }}</textarea>
                        </div>

                    </div>

                    {{-- BOUTON --}}
                    <div class="student-reg-submit-area">

                        <button
                            type="submit"
                            class="student-reg-submit"
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