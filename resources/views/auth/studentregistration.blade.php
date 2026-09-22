@extends('layouts.login_master')

@section('title', 'Inscription Élève')

@section('content')

<style>
    .student-reg-wrapper {
        min-height: 100vh;
        padding: 40px 15px;
    }

    .student-reg-card {
        max-width: 1100px;
        margin: 0 auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
        padding: 35px;
    }

    .student-reg-title {
        text-align: center;
        margin-bottom: 30px;
    }

    .student-reg-title h2 {
        font-weight: 700;
        margin-bottom: 8px;
    }

    .student-reg-title p {
        color: #777;
        margin: 0;
    }

    .student-reg-section {
        margin-top: 30px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }

    .student-reg-section h4 {
        font-weight: 600;
        margin: 0;
    }

    .student-reg-form-group {
        margin-bottom: 20px;
    }

    .student-reg-form-group label {
        font-weight: 500;
        margin-bottom: 7px;
        display: block;
    }

    .student-reg-required {
        color: #dc3545;
    }

    .student-reg-form-control {
        width: 100%;
        padding: 11px 14px;
        border: 1px solid #ddd;
        border-radius: 6px;
        outline: none;
        transition: 0.2s;
        font-size: 14px;
    }

    .student-reg-form-control:focus {
        border-color: #7367f0;
        box-shadow: 0 0 0 3px rgba(115, 103, 240, 0.08);
    }

    textarea.student-reg-form-control {
        resize: vertical;
        min-height: 100px;
    }

    .student-reg-row {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .student-reg-submit {
        margin-top: 30px;
        text-align: center;
    }

    .student-reg-submit button {
        border: none;
        background: #7367f0;
        color: #fff;
        padding: 12px 35px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .student-reg-submit button:hover {
        background: #6258d9;
    }

    .student-reg-academic-fields {
        display: none;
        margin-top: 20px;
        padding: 20px;
        border: 1px solid #eee;
        border-radius: 8px;
        background: #fafafa;
    }

    .student-reg-academic-fields.active {
        display: block;
    }

    .student-reg-academic-title {
        font-weight: 600;
        margin-bottom: 20px;
    }

    .student-reg-checkbox-group {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .student-reg-checkbox-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 10px;
        border: 1px solid #e5e5e5;
        border-radius: 6px;
        background: #fff;
    }

    .student-reg-checkbox-item input {
        margin: 0;
    }

    .student-reg-help {
        font-size: 12px;
        color: #777;
        margin-top: 6px;
    }

    .student-reg-error {
        color: #dc3545;
        font-size: 13px;
        margin-top: 8px;
        display: none;
    }

    @media (max-width: 768px) {
        .student-reg-card {
            padding: 20px;
        }

        .student-reg-row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .student-reg-checkbox-group {
            grid-template-columns: 1fr;
        }
    }
    .student-reg-alert {
    margin-bottom: 25px;
    padding: 15px 18px;
    border-radius: 6px;
    font-size: 14px;
}

.student-reg-alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.student-reg-alert-danger ul {
    margin: 8px 0 0;
    padding-left: 20px;
}

.student-reg-alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.student-reg-submit button:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}
</style>

<div style="background-image: url(/global_assets/images/login_covereco.png)" class="student-reg-page py-5">
    <div class="student-reg-card">

        <img
                    src="https://madaure.vercel.app/assets/images/logo/logo.png"
                    alt="Logo"
                    width="200"
                    class="student-reg-logo"
                    onerror="this.style.display='none';"
                >
        <div class="student-reg-title">
            <h2>Inscription Élève</h2>
            <p>Créez le dossier d'inscription de l'élève — votre dossier sera examiné par l'administration.</p>
        </div>

        <form action="{{ route('student.registration.store') }}" method="POST" enctype="multipart/form-data" id="studentRegistrationForm">
           @csrf

{{-- Messages --}}
@if ($errors->any())
    <div class="student-reg-alert student-reg-alert-danger">
        <strong>Veuillez corriger les erreurs suivantes :</strong>

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="student-reg-alert student-reg-alert-success">
        {{ session('success') }}
    </div>
@endif

            {{-- Informations de l'élève --}}
            <div class="student-reg-section">
                <h4>Informations de l'élève</h4>
            </div>

            <div class="student-reg-row">

                <div class="student-reg-form-group">
                    <label for="full_name">
                        Nom complet <span class="student-reg-required">*</span>
                    </label>
                    <input
                        type="text"
                        name="full_name"
                        id="full_name"
                        class="student-reg-form-control"
                        value="{{ old('full_name') }}"
                        required
                    >
                </div>

                <div class="student-reg-form-group">
                    <label for="first_name">Prénom</label>
                    <input
                        type="text"
                        name="first_name"
                        id="first_name"
                        class="student-reg-form-control"
                        value="{{ old('first_name') }}"
                    >
                </div>

            </div>

            <div class="student-reg-row">

                <div class="student-reg-form-group">
                    <label for="last_name">Nom</label>
                    <input
                        type="text"
                        name="last_name"
                        id="last_name"
                        class="student-reg-form-control"
                        value="{{ old('last_name') }}"
                    >
                </div>

                <div class="student-reg-form-group">
                    <label for="date_of_birth">
                        Date de naissance <span class="student-reg-required">*</span>
                    </label>
                    <input
                        type="date"
                        name="date_of_birth"
                        id="date_of_birth"
                        class="student-reg-form-control"
                        value="{{ old('date_of_birth') }}"
                        required
                    >
                </div>

            </div>

            <div class="student-reg-row">

                <div class="student-reg-form-group">
                    <label for="place_of_birth">Lieu de naissance</label>
                    <input
                        type="text"
                        name="place_of_birth"
                        id="place_of_birth"
                        class="student-reg-form-control"
                        value="{{ old('place_of_birth') }}"
                    >
                </div>

                <div class="student-reg-form-group">
                    <label for="parent_email">
                        Email <span class="student-reg-required">*</span>
                    </label>
                    <input
                        type="email"
                        name="parent_email"
                        id="parent_email"
                        class="student-reg-form-control"
                        value="{{ old('parent_email') }}"
                        required
                    >
                </div>

            </div>

            <div class="student-reg-row">

                <div class="student-reg-form-group">
                    <label for="gender">
                        Sexe <span class="student-reg-required">*</span>
                    </label>
                    <select
                        name="gender"
                        id="gender"
                        class="student-reg-form-control"
                        required
                    >
                        <option value="">Sélectionnez...</option>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Masculin</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Féminin</option>
                    </select>
                </div>

                <div class="student-reg-form-group">
                    <label for="nationality">Nationalité</label>
                    <input
                        type="text"
                        name="nationality"
                        id="nationality"
                        class="student-reg-form-control"
                        value="{{ old('nationality') }}"
                    >
                </div>

            </div>

            <div class="student-reg-form-group">
                <label for="photo">Photo</label>
                <input
                    type="file"
                    name="photo"
                    id="photo"
                    class="student-reg-form-control"
                    accept="image/*"
                >
            </div>

            {{-- Adresse --}}
            <div class="student-reg-section">
                <h4>Adresse</h4>
            </div>

            <div class="student-reg-form-group">
                <label for="address">Adresse</label>
                <input
                    type="text"
                    name="address"
                    id="address"
                    class="student-reg-form-control"
                    value="{{ old('address') }}"
                >
            </div>

            <div class="student-reg-row">

                <div class="student-reg-form-group">
                    <label for="city">Ville</label>
                    <input
                        type="text"
                        name="city"
                        id="city"
                        class="student-reg-form-control"
                        value="{{ old('city') }}"
                    >
                </div>

                <div class="student-reg-form-group">
                    <label for="country">Pays</label>
                    <input
                        type="text"
                        name="country"
                        id="country"
                        class="student-reg-form-control"
                        value="{{ old('country') }}"
                    >
                </div>

            </div>

            {{-- Parcours scolaire --}}
            <div class="student-reg-section">
                <h4>Parcours scolaire</h4>
            </div>

            <div class="student-reg-row">

                <div class="student-reg-form-group">
                    <label for="current_school">Établissement actuel</label>
                    <input
                        type="text"
                        name="current_school"
                        id="current_school"
                        class="student-reg-form-control"
                        value="{{ old('current_school') }}"
                    >
                </div>

                <div class="student-reg-form-group">
                    <label for="current_level">Niveau actuel</label>
                    <input
                        type="text"
                        name="current_level"
                        id="current_level"
                        class="student-reg-form-control"
                        value="{{ old('current_level') }}"
                        placeholder="Ex : 5ème, 3ème, Seconde"
                    >
                </div>

            </div>

            <div class="student-reg-row">

                <div class="student-reg-form-group">
                    <label for="previous_school">Établissement précédent</label>
                    <input
                        type="text"
                        name="previous_school"
                        id="previous_school"
                        class="student-reg-form-control"
                        value="{{ old('previous_school') }}"
                    >
                </div>

                <div class="student-reg-form-group">
                    <label for="program">
                        Programme souhaité <span class="student-reg-required">*</span>
                    </label>
                    <input
                        type="text"
                        name="program"
                        id="program"
                        class="student-reg-form-control"
                        value="{{ old('program') }}"
                        placeholder="Ex : Collège, Lycée, Première générale"
                        required
                    >
                </div>

            </div>

            <div class="student-reg-form-group">
                <label for="requested_level">
                    Niveau demandé <span class="student-reg-required">*</span>
                </label>

                <select
                    name="requested_level"
                    id="requested_level"
                    class="student-reg-form-control"
                    required
                >
                    <option value="">Sélectionnez...</option>

                    <option value="Sixieme" {{ old('requested_level') == 'Sixieme' ? 'selected' : '' }}>
                        Sixième
                    </option>

                    <option value="Cinquieme" {{ old('requested_level') == 'Cinquieme' ? 'selected' : '' }}>
                        Cinquième
                    </option>

                    <option value="Quatrieme" {{ old('requested_level') == 'Quatrieme' ? 'selected' : '' }}>
                        Quatrième
                    </option>

                    <option value="Troisieme" {{ old('requested_level') == 'Troisieme' ? 'selected' : '' }}>
                        Troisième
                    </option>

                    <option value="Seconde" {{ old('requested_level') == 'Seconde' ? 'selected' : '' }}>
                        Seconde
                    </option>

                    <option value="Premiere-generale" {{ old('requested_level') == 'Premiere-generale' ? 'selected' : '' }}>
                        Première générale
                    </option>

                    <option value="Premiere-STMG" {{ old('requested_level') == 'Premiere-STMG' ? 'selected' : '' }}>
                        Première STMG
                    </option>

                    <option value="Terminale-generale" {{ old('requested_level') == 'Terminale-generale' ? 'selected' : '' }}>
                        Terminale générale
                    </option>

                    <option value="Terminale-STMG" {{ old('requested_level') == 'Terminale-STMG' ? 'selected' : '' }}>
                        Terminale STMG
                    </option>
                </select>
            </div>

            {{-- Champs supplémentaires pour Première / Terminale générale --}}
            <div
                class="student-reg-academic-fields"
                id="studentAcademicFields"
            >

                <div class="student-reg-academic-title">
                    Informations complémentaires
                </div>

                <div class="student-reg-form-group">
                    <label for="dropped_subject">
                        Matière abandonnée en Première
                        <span class="student-reg-required">*</span>
                    </label>

                    <input
                        type="text"
                        name="dropped_subject"
                        id="dropped_subject"
                        class="student-reg-form-control"
                        value="{{ old('dropped_subject') }}"
                        placeholder="Ex : Mathématiques"
                    >
                </div>

                <div class="student-reg-form-group">

                    <label>
                        Spécialités
                        <span class="student-reg-required">*</span>
                    </label>

                    <div class="student-reg-checkbox-group">

                        <label class="student-reg-checkbox-item">
                            <input
                                type="checkbox"
                                name="terminal_specialties[]"
                                value="Mathématiques"
                                {{ in_array('Mathématiques', old('terminal_specialties', [])) ? 'checked' : '' }}
                            >
                            <span>Mathématiques</span>
                        </label>

                        <label class="student-reg-checkbox-item">
                            <input
                                type="checkbox"
                                name="terminal_specialties[]"
                                value="Physique - Chimie"
                                {{ in_array('Physique - Chimie', old('terminal_specialties', [])) ? 'checked' : '' }}
                            >
                            <span>Physique - Chimie</span>
                        </label>

                        <label class="student-reg-checkbox-item">
                            <input
                                type="checkbox"
                                name="terminal_specialties[]"
                                value="SVT"
                                {{ in_array('SVT', old('terminal_specialties', [])) ? 'checked' : '' }}
                            >
                            <span>SVT</span>
                        </label>

                        <label class="student-reg-checkbox-item">
                            <input
                                type="checkbox"
                                name="terminal_specialties[]"
                                value="SES"
                                {{ in_array('SES', old('terminal_specialties', [])) ? 'checked' : '' }}
                            >
                            <span>SES</span>
                        </label>

                        <label class="student-reg-checkbox-item">
                            <input
                                type="checkbox"
                                name="terminal_specialties[]"
                                value="HGGSP"
                                {{ in_array('HGGSP', old('terminal_specialties', [])) ? 'checked' : '' }}
                            >
                            <span>HGGSP</span>
                        </label>

                        <label class="student-reg-checkbox-item">
                            <input
                                type="checkbox"
                                name="terminal_specialties[]"
                                value="LLCER"
                                {{ in_array('LLCER', old('terminal_specialties', [])) ? 'checked' : '' }}
                            >
                            <span>LLCER</span>
                        </label>

                    </div>

                    <div class="student-reg-help">
                        Sélectionnez exactement 2 spécialités.
                    </div>

                    <div
                        class="student-reg-error"
                        id="studentSpecialtiesError"
                    >
                        Veuillez sélectionner exactement 2 spécialités.
                    </div>

                </div>

                <div class="student-reg-form-group">

                    <label>
                        Langues
                        <span class="student-reg-required">*</span>
                    </label>

                    <div class="student-reg-checkbox-group">

                        <label class="student-reg-checkbox-item">
                            <input
                                type="checkbox"
                                name="languages[]"
                                value="Arab"
                                {{ in_array('Arab', old('languages', [])) ? 'checked' : '' }}
                            >
                            <span>Arabe</span>
                        </label>

                        <label class="student-reg-checkbox-item">
                            <input
                                type="checkbox"
                                name="languages[]"
                                value="Anglais"
                                {{ in_array('Anglais', old('languages', [])) ? 'checked' : '' }}
                            >
                            <span>Anglais</span>
                        </label>

                        <label class="student-reg-checkbox-item">
                            <input
                                type="checkbox"
                                name="languages[]"
                                value="Espagnol"
                                {{ in_array('Espagnol', old('languages', [])) ? 'checked' : '' }}
                            >
                            <span>Espagnol</span>
                        </label>

                    </div>

                    <div class="student-reg-help">
                        Sélectionnez exactement 2 langues.
                    </div>

                    <div
                        class="student-reg-error"
                        id="studentLanguagesError"
                    >
                        Veuillez sélectionner exactement 2 langues.
                    </div>

                </div>

            </div>

            <div class="student-reg-row">

                <div class="student-reg-form-group">
                    <label for="academic_year">Année scolaire</label>
                    <input
                        type="text"
                        name="academic_year"
                        id="academic_year"
                        class="student-reg-form-control"
                        value="{{ old('academic_year') }}"
                    >
                </div>

                <div class="student-reg-form-group">
                    <label for="desired_start_date">Date de début souhaitée</label>
                    <input
                        type="date"
                        name="desired_start_date"
                        id="desired_start_date"
                        class="student-reg-form-control"
                        value="{{ old('desired_start_date') }}"
                    >
                </div>

            </div>

            <div class="student-reg-form-group">
                <label for="academic_notes">Notes académiques</label>
                <textarea
                    name="academic_notes"
                    id="academic_notes"
                    class="student-reg-form-control"
                >{{ old('academic_notes') }}</textarea>
            </div>

            {{-- Informations du parent --}}
            <div class="student-reg-section">
                <h4>Informations du parent</h4>
            </div>

            <div class="student-reg-row">

                <div class="student-reg-form-group">
                    <label for="parent_name">
                        Nom du parent <span class="student-reg-required">*</span>
                    </label>
                    <input
                        type="text"
                        name="parent_name"
                        id="parent_name"
                        class="student-reg-form-control"
                        value="{{ old('parent_name') }}"
                        required
                    >
                </div>

                <div class="student-reg-form-group">
                    <label for="parent_relationship">Relation avec l'élève</label>
                    <select
                        name="parent_relationship"
                        id="parent_relationship"
                        class="student-reg-form-control"
                    >
                        <option value="">Sélectionnez...</option>
                        <option value="Father" {{ old('parent_relationship') == 'Father' ? 'selected' : '' }}>
                            Père
                        </option>
                        <option value="Mother" {{ old('parent_relationship') == 'Mother' ? 'selected' : '' }}>
                            Mère
                        </option>
                        <option value="Guardian" {{ old('parent_relationship') == 'Guardian' ? 'selected' : '' }}>
                            Tuteur
                        </option>
                        <option value="Other" {{ old('parent_relationship') == 'Other' ? 'selected' : '' }}>
                            Autre
                        </option>
                    </select>
                </div>

            </div>

            <div class="student-reg-row">

                <div class="student-reg-form-group">
                    <label for="parent_phone">
                        Téléphone du parent <span class="student-reg-required">*</span>
                    </label>
                    <input
                        type="text"
                        name="parent_phone"
                        id="parent_phone"
                        class="student-reg-form-control"
                        value="{{ old('parent_phone') }}"
                        required
                    >
                </div>

                <div class="student-reg-form-group">
                    <label for="parent_whatsapp">WhatsApp</label>
                    <input
                        type="text"
                        name="parent_whatsapp"
                        id="parent_whatsapp"
                        class="student-reg-form-control"
                        value="{{ old('parent_whatsapp') }}"
                    >
                </div>

            </div>

            <div class="student-reg-row">

                <div class="student-reg-form-group">
                    <label for="parent_occupation">Profession</label>
                    <input
                        type="text"
                        name="parent_occupation"
                        id="parent_occupation"
                        class="student-reg-form-control"
                        value="{{ old('parent_occupation') }}"
                    >
                </div>

                <div class="student-reg-form-group">
                    <label for="parent_address">Adresse du parent</label>
                    <input
                        type="text"
                        name="parent_address"
                        id="parent_address"
                        class="student-reg-form-control"
                        value="{{ old('parent_address') }}"
                    >
                </div>

            </div>

            {{-- Contact d'urgence --}}
            <div class="student-reg-section">
                <h4>Contact d'urgence</h4>
            </div>

            <div class="student-reg-row">

                <div class="student-reg-form-group">
                    <label for="emergency_name">Nom</label>
                    <input
                        type="text"
                        name="emergency_name"
                        id="emergency_name"
                        class="student-reg-form-control"
                        value="{{ old('emergency_name') }}"
                    >
                </div>

                <div class="student-reg-form-group">
                    <label for="emergency_relationship">Relation</label>
                    <input
                        type="text"
                        name="emergency_relationship"
                        id="emergency_relationship"
                        class="student-reg-form-control"
                        value="{{ old('emergency_relationship') }}"
                    >
                </div>

            </div>

            <div class="student-reg-form-group">
                <label for="emergency_phone">Téléphone</label>
                <input
                    type="text"
                    name="emergency_phone"
                    id="emergency_phone"
                    class="student-reg-form-control"
                    value="{{ old('emergency_phone') }}"
                >
            </div>

            {{-- Informations complémentaires --}}
            <div class="student-reg-section">
                <h4>Informations complémentaires</h4>
            </div>

            <div class="student-reg-form-group">
                <label for="medical_notes">Informations médicales</label>
                <textarea
                    name="medical_notes"
                    id="medical_notes"
                    class="student-reg-form-control"
                >{{ old('medical_notes') }}</textarea>
            </div>

            <div class="student-reg-form-group">
                <label for="how_did_you_hear">Comment avez-vous connu notre école ?</label>
                <input
                    type="text"
                    name="how_did_you_hear"
                    id="how_did_you_hear"
                    class="student-reg-form-control"
                    value="{{ old('how_did_you_hear') }}"
                >
            </div>

            <div class="student-reg-form-group">
                <label for="additional_comments">Commentaires supplémentaires</label>
                <textarea
                    name="additional_comments"
                    id="additional_comments"
                    class="student-reg-form-control"
                >{{ old('additional_comments') }}</textarea>
            </div>

            <div class="student-reg-submit">
                <div class="student-reg-submit">
    <button type="submit" id="studentSubmitButton">
        <span id="studentSubmitText">
            Envoyer la demande d'inscription
        </span>

        <span id="studentSubmitLoading" style="display: none;">
            Envoi en cours...
        </span>
    </button>
</div>
            </div>

        </form>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const studentForm = document.getElementById('studentRegistrationForm');
const submitButton = document.getElementById('studentSubmitButton');
const submitText = document.getElementById('studentSubmitText');
const submitLoading = document.getElementById('studentSubmitLoading');

        const requestedLevel = document.getElementById('requested_level');
        const academicFields = document.getElementById('studentAcademicFields');
        const droppedSubject = document.getElementById('dropped_subject');

        const specialties = document.querySelectorAll(
            'input[name="terminal_specialties[]"]'
        );

        const languages = document.querySelectorAll(
            'input[name="languages[]"]'
        );

        const specialtiesError = document.getElementById(
            'studentSpecialtiesError'
        );

        const languagesError = document.getElementById(
            'studentLanguagesError'
        );

        const ACADEMIC_LEVELS = [
            'Premiere-generale',
            'Terminale-generale'
        ];

        function updateAcademicFields(level) {

            const isAcademicLevel = ACADEMIC_LEVELS.includes(level);

            if (isAcademicLevel) {

                academicFields.classList.add('active');

                droppedSubject.required = true;

            } else {

                academicFields.classList.remove('active');

                droppedSubject.required = false;
                droppedSubject.value = '';

                specialties.forEach(function (checkbox) {
                    checkbox.checked = false;
                });

                languages.forEach(function (checkbox) {
                    checkbox.checked = false;
                });

                specialtiesError.style.display = 'none';
                languagesError.style.display = 'none';
            }
        }

        requestedLevel.addEventListener('change', function () {
            updateAcademicFields(this.value);
        });

        /*
         * Prevent selecting more than 2 specialties
         */
        specialties.forEach(function (checkbox) {

            checkbox.addEventListener('change', function () {

                const checkedSpecialties = document.querySelectorAll(
                    'input[name="terminal_specialties[]"]:checked'
                );

                if (checkedSpecialties.length > 2) {
                    this.checked = false;
                }

                const currentCount = document.querySelectorAll(
                    'input[name="terminal_specialties[]"]:checked'
                ).length;

                if (currentCount === 2) {
                    specialtiesError.style.display = 'none';
                }
            });

        });

        /*
         * Prevent selecting more than 2 languages
         */
        languages.forEach(function (checkbox) {

            checkbox.addEventListener('change', function () {

                const checkedLanguages = document.querySelectorAll(
                    'input[name="languages[]"]:checked'
                );

                if (checkedLanguages.length > 2) {
                    this.checked = false;
                }

                const currentCount = document.querySelectorAll(
                    'input[name="languages[]"]:checked'
                ).length;

                if (currentCount === 2) {
                    languagesError.style.display = 'none';
                }
            });

        });

        /*
         * Validate before submitting
         */
       document.getElementById('studentRegistrationForm')
    .addEventListener('submit', function (event) {

        const level = requestedLevel.value;

        if (!ACADEMIC_LEVELS.includes(level)) {
            specialtiesError.style.display = 'none';
            languagesError.style.display = 'none';

            // Show loading state
            submitButton.disabled = true;
            submitText.style.display = 'none';
            submitLoading.style.display = 'inline';

            // Let the normal form submission continue
            return;
        }

        const selectedSpecialties = document.querySelectorAll(
            'input[name="terminal_specialties[]"]:checked'
        ).length;

        const selectedLanguages = document.querySelectorAll(
            'input[name="languages[]"]:checked'
        ).length;

        let valid = true;

        if (selectedSpecialties !== 2) {
            specialtiesError.style.display = 'block';
            valid = false;
        } else {
            specialtiesError.style.display = 'none';
        }

        if (selectedLanguages !== 2) {
            languagesError.style.display = 'block';
            valid = false;
        } else {
            languagesError.style.display = 'none';
        }

        if (!valid) {
            event.preventDefault();

            if (selectedSpecialties !== 2) {
                document.querySelector(
                    '.student-reg-checkbox-group'
                ).scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }

            return;
        }

        // Show loading state
        submitButton.disabled = true;
        submitText.style.display = 'none';
        submitLoading.style.display = 'inline';

        // Do NOT call form.submit()
        // The browser will continue with the normal form submission.
    });

        /*
         * Restore academic fields if validation fails
         * and old requested_level exists.
         */
        updateAcademicFields(requestedLevel.value);

    });
</script>

@endsection