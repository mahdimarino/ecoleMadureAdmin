
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inscription Parent</title>

    <style>

        .password-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.password-wrapper .parent-reg-input {
    padding-right: 42px; /* space for the button */
    width: 100%;
}

.toggle-password {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    line-height: 1;
    color: #666;
    transition: color 0.2s ease, opacity 0.2s ease;
    opacity: 0.7;
}

.toggle-password:hover {
    color: #000;
    opacity: 1;
}

.toggle-password.is-visible .eye-icon {
    opacity: 1;
}

.toggle-password.is-visible .eye-icon::after {
    content: '';
    position: absolute;
    width: 100%;
    height: 2px;
    background: currentColor;
    transform: rotate(45deg);
    top: 50%;
    left: 0;
}
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background: #f5f7fa;
            font-family: Arial, Helvetica, sans-serif;
            color: #222;
        }

        .parent-reg-wrapper {
            width: 100%;
            padding: 40px 15px;
        }

        .parent-reg-container {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
            padding: 35px;
        }

        .parent-reg-title {
            text-align: center;
            margin-bottom: 10px;
            font-size: 30px;
            font-weight: 700;
            color: #1f2937;
        }

        .parent-reg-subtitle {
            text-align: center;
            margin-bottom: 35px;
            color: #6b7280;
        }

        .parent-reg-section {
            margin-top: 35px;
            margin-bottom: 30px;
        }

        .parent-reg-section-title {
            font-size: 21px;
            font-weight: 700;
            color: #1f2937;
            padding-bottom: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #eee;
        }

        .parent-reg-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .parent-reg-field {
            width: 100%;
        }

        .parent-reg-field.full {
            grid-column: 1 / -1;
        }

        .parent-reg-label {
            display: block;
            margin-bottom: 7px;
            font-weight: 600;
            color: #374151;
        }

        .required-star {
            color: #dc2626;
        }

        .parent-reg-input,
        .parent-reg-select,
        .parent-reg-textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            background: #fff;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .parent-reg-input:focus,
        .parent-reg-select:focus,
        .parent-reg-textarea:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
        }

        .parent-reg-textarea {
            min-height: 110px;
            resize: vertical;
        }

        .children-count-wrapper {
            max-width: 350px;
        }

        .child-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            background: #fafafa;
        }

        .child-card-title {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 25px;
        }

        .child-card + .child-card {
            margin-top: 20px;
        }

        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-top: 8px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            border: 1px solid #e5e7eb;
            border-radius: 7px;
            background: #fff;
        }

        .checkbox-item input {
            width: 17px;
            height: 17px;
        }

        .child-error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }

        .error-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 15px 18px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .success-box {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            padding: 15px 18px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .error-input {
            border-color: #dc2626 !important;
        }

        .parent-reg-submit-wrapper {
            text-align: center;
            margin-top: 35px;
        }

        .parent-reg-submit {
            border: 0;
            background: #2563eb;
            color: white;
            padding: 14px 35px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }

        .parent-reg-submit:hover {
            background: #1d4ed8;
        }

        .parent-reg-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .help-text {
            color: #6b7280;
            font-size: 13px;
            margin-top: 6px;
        }

        .academic-fields {
            display: none;
        }

        @media (max-width: 768px) {
            .parent-reg-container {
                padding: 22px;
            }

            .parent-reg-grid {
                grid-template-columns: 1fr;
            }

            .parent-reg-field.full {
                grid-column: auto;
            }

            .checkbox-group {
                grid-template-columns: 1fr;
            }

            .parent-reg-title {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

<div style="background-image: url(/global_assets/images/login_covereco.png)" class="parent-reg-wrapper">
    
    <div class="parent-reg-container">
        <div class="text-center" >
  <img width="200" 
                    src="https://madaure.vercel.app/assets/images/logo/logo.png"
                    alt="Logo"
                    class="student-reg-logo margin-auto parent-reg-title"
                   
                >
        </div>


        <h1 class="parent-reg-title">
            Inscription Parent
        </h1>

        <p class="parent-reg-subtitle">
            Veuillez remplir les informations ci-dessous.
        </p>

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="success-box">
                {{ session('success') }}
            </div>
        @endif

        {{-- GENERAL ERRORS --}}
        @if($errors->any())
            <div class="error-box">
                <strong>Veuillez corriger les erreurs suivantes :</strong>

                <ul style="margin-bottom:0; margin-top:10px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('parent.registration.store') }}"
            class="parent-reg-form"
            id="parent-reg-form"
            novalidate
        >

            @csrf

            {{-- ========================================================= --}}
            {{-- PARENT INFORMATION --}}
            {{-- ========================================================= --}}

            <div class="parent-reg-section">

                <div class="parent-reg-section-title">
                    Informations du parent
                </div>

                <div class="parent-reg-grid">

                    {{-- NAME --}}
                    <div class="parent-reg-field">

                        <label class="parent-reg-label">
                            Nom et prénom
                            <span class="required-star">*</span>
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="parent-reg-input @error('name') error-input @enderror"
                            value="{{ old('name') }}"
                            required
                        >

                        @error('name')
                            <div class="child-error">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- EMAIL --}}
                    <div class="parent-reg-field">

                        <label class="parent-reg-label">
                            Email
                            <span class="required-star">*</span>
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="parent-reg-input @error('email') error-input @enderror"
                            value="{{ old('email') }}"
                            required
                        >

                        @error('email')
                            <div class="child-error">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- PHONE --}}
                    <div class="parent-reg-field">

                        <label class="parent-reg-label">
                            Téléphone
                            <span class="required-star">*</span>
                        </label>

                        <input
                            type="text"
                            name="phone"
                            class="parent-reg-input @error('phone') error-input @enderror"
                            value="{{ old('phone') }}"
                            required
                        >

                        @error('phone')
                            <div class="child-error">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- PHONE 2 --}}
                    <div class="parent-reg-field">

                        <label class="parent-reg-label">
                            Deuxième téléphone
                        </label>

                        <input
                            type="text"
                            name="phone2"
                            class="parent-reg-input"
                            value="{{ old('phone2') }}"
                        >

                    </div>

                    {{-- REGISTRATION DATE --}}
                    <div class="parent-reg-field">

                        <label class="parent-reg-label">
                            Date d'inscription
                            <span class="required-star">*</span>
                        </label>

                        <input
                            type="date"
                            name="registration_date"
                            class="parent-reg-input @error('registration_date') error-input @enderror"
                            value="{{ old('registration_date', date('Y-m-d')) }}"
                            required
                        >

                        @error('registration_date')
                            <div class="child-error">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- NUMBER OF CHILDREN --}}
                    <div class="parent-reg-field children-count-wrapper">

                        <label class="parent-reg-label">
                            Nombre d'enfants
                            <span class="required-star">*</span>
                        </label>

                        <select
                            id="children-count-select"
                            class="parent-reg-select"
                            required
                        >
                            <option value="">Sélectionnez...</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="Autre">Autre</option>
                        </select>

                        <input
                            type="number"
                            id="children-count-custom"
                            class="parent-reg-input"
                            placeholder="Indiquez le nombre d'enfants"
                            min="1"
                            style="display:none; margin-top:10px;"
                        >

                        {{-- IMPORTANT --}}
                        <input
                            type="hidden"
                            name="number_of_children"
                            id="number_of_children_hidden"
                            value="{{ old('number_of_children') }}"
                        >

                        <div class="help-text">
                            Sélectionnez le nombre d'enfants à inscrire.
                        </div>

                    </div>

                    {{-- ADDRESS --}}
                    <div class="parent-reg-field full">

                        <label class="parent-reg-label">
                            Adresse
                            <span class="required-star">*</span>
                        </label>

                        <textarea
                            name="address"
                            class="parent-reg-textarea @error('address') error-input @enderror"
                            required
                        >{{ old('address') }}</textarea>

                        @error('address')
                            <div class="child-error">{{ $message }}</div>
                        @enderror

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- CHILDREN --}}
            {{-- ========================================================= --}}

            <div class="parent-reg-section">

                <div class="parent-reg-section-title">
                    Informations des enfants
                </div>

                <div id="children-container"></div>

            </div>


            {{-- ========================================================= --}}
            {{-- OTHER PARENT INFORMATION --}}
            {{-- ========================================================= --}}

            <div class="parent-reg-section">

                <div class="parent-reg-section-title">
                    Informations supplémentaires
                </div>

                <div class="parent-reg-grid">

                    {{-- HOW DID YOU HEAR --}}
                    <div class="parent-reg-field full">

                        <label class="parent-reg-label">
                            Comment avez-vous connu notre établissement ?
                            <span class="required-star">*</span>
                        </label>

                        <select
                            name="how_did_you_hear"
                            class="parent-reg-select @error('how_did_you_hear') error-input @enderror"
                            required
                        >

                            <option value="">
                                Sélectionnez...
                            </option>

                            <option
                                value="Facebook"
                                {{ old('how_did_you_hear') == 'Facebook' ? 'selected' : '' }}
                            >
                                Facebook
                            </option>

                            <option
                                value="Instagram"
                                {{ old('how_did_you_hear') == 'Instagram' ? 'selected' : '' }}
                            >
                                Instagram
                            </option>

                            <option
                                value="TikTok"
                                {{ old('how_did_you_hear') == 'TikTok' ? 'selected' : '' }}
                            >
                                TikTok
                            </option>

                            <option
                                value="Google"
                                {{ old('how_did_you_hear') == 'Google' ? 'selected' : '' }}
                            >
                                Google
                            </option>

                            <option
                                value="Ami ou famille"
                                {{ old('how_did_you_hear') == 'Ami ou famille' ? 'selected' : '' }}
                            >
                                Ami ou famille
                            </option>

                            <option
                                value="Autre"
                                {{ old('how_did_you_hear') == 'Autre' ? 'selected' : '' }}
                            >
                                Autre
                            </option>

                        </select>

                        @error('how_did_you_hear')
                            <div class="child-error">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- ADDITIONAL INFORMATION --}}
                    <div class="parent-reg-field full">

                        <label class="parent-reg-label">
                            Informations supplémentaires
                        </label>

                        <textarea
                            name="additional_information"
                            class="parent-reg-textarea @error('additional_information') error-input @enderror"
                            placeholder="Informations supplémentaires..."
                        >{{ old('additional_information') }}</textarea>

                        @error('additional_information')
                            <div class="child-error">{{ $message }}</div>
                        @enderror

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- PASSWORD --}}
            {{-- ========================================================= --}}

            <div class="parent-reg-section">

                <div class="parent-reg-section-title">
                    Sécurité du compte
                </div>

                <div class="parent-reg-grid">

                    {{-- PASSWORD --}}
                    <div class="parent-reg-field">

                        <label class="parent-reg-label">
                            Mot de passe
                            <span class="required-star">*</span>
                        </label>

                        <div class="password-wrapper">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="parent-reg-input @error('password') error-input @enderror"
                                required
                            >
                            <button
                                type="button"
                                class="toggle-password"
                                data-target="password"
                                aria-label="Afficher le mot de passe"
                            >
                                <span class="eye-icon">👁</span>
                            </button>
                        </div>

                        @error('password')
                            <div class="child-error">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- CONFIRM PASSWORD --}}
                    <div class="parent-reg-field">

                        <label class="parent-reg-label">
                            Confirmer le mot de passe
                            <span class="required-star">*</span>
                        </label>

                        <div class="password-wrapper">
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="parent-reg-input"
                                required
                            >
                            <button
                                type="button"
                                class="toggle-password"
                                data-target="password_confirmation"
                                aria-label="Afficher le mot de passe"
                            >
                                <span class="eye-icon">👁</span>
                            </button>
                        </div>

                        <div
                            id="password-match-message"
                            class="help-text"
                        ></div>

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- SUBMIT --}}
            {{-- ========================================================= --}}

            <div class="parent-reg-submit-wrapper">

                <button
                    type="submit"
                    class="parent-reg-submit"
                    id="parent-reg-submit"
                >
                    Envoyer mon inscription
                </button>

            </div>

        </form>

    </div>

</div>


<script>

    /*
    |--------------------------------------------------------------------------
    | OLD DATA
    |--------------------------------------------------------------------------
    */

    const OLD_CHILDREN = @json(old('children', []));
    const OLD_NUMBER_OF_CHILDREN = @json(old('number_of_children'));


    /*
    |--------------------------------------------------------------------------
    | ACADEMIC LEVELS
    |--------------------------------------------------------------------------
    */

    const ACADEMIC_LEVELS = [
        'Premiere-generale',
        'Terminale-generale'
    ];


    /*
    |--------------------------------------------------------------------------
    | AVAILABLE OPTIONS
    |--------------------------------------------------------------------------
    */

    const SPECIALTIES = [
        'Mathématiques',
        'Physique - Chimie',
        'SVT',
        'SES',
        'HGGSP',
        'LLCER',
        
    ];

    const LANGUAGES = [
        'Arab',
        'Anglais',
        'Espagnol',
       
    ];


    /*
    |--------------------------------------------------------------------------
    | ELEMENTS
    |--------------------------------------------------------------------------
    */

    const childrenSelect =
        document.getElementById('children-count-select');

    const childrenCustom =
        document.getElementById('children-count-custom');

    const childrenHidden =
        document.getElementById('number_of_children_hidden');

    const childrenContainer =
        document.getElementById('children-container');


    /*
    |--------------------------------------------------------------------------
    | CURRENT CHILD DATA
    |--------------------------------------------------------------------------
    */

    function currentChildrenData() {

        const cards =
            childrenContainer.querySelectorAll('.child-card');

        const result = [];

        cards.forEach((card, index) => {

            const child = {};

            card.querySelectorAll('input, select, textarea')
                .forEach(input => {

                    if (!input.name) {
                        return;
                    }

                    const match =
                        input.name.match(
                            /children\[(\d+)\]\[([^\]]+)\](?:\[\])?/
                        );

                    if (!match) {
                        return;
                    }

                    const field = match[2];

                    if (input.type === 'checkbox') {

                        if (!child[field]) {
                            child[field] = [];
                        }

                        if (input.checked) {
                            child[field].push(input.value);
                        }

                    } else {

                        child[field] = input.value;

                    }

                });

            result.push(child);

        });

        return result;
    }


    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(value) {

        if (value === null || value === undefined) {
            return '';
        }

        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE CHECKBOXES
    |--------------------------------------------------------------------------
    */

    function createCheckboxes(
        name,
        values,
        selectedValues = []
    ) {

        if (!Array.isArray(selectedValues)) {
            selectedValues = [];
        }

        return values.map(value => {

            const checked =
                selectedValues.includes(value)
                    ? 'checked'
                    : '';

            return `
                <label class="checkbox-item">

                    <input
                        type="checkbox"
                        name="${name}[]"
                        value="${escapeHtml(value)}"
                        ${checked}
                    >

                    <span>
                        ${escapeHtml(value)}
                    </span>

                </label>
            `;

        }).join('');
    }


    /*
    |--------------------------------------------------------------------------
    | RENDER CHILDREN
    |--------------------------------------------------------------------------
    */

    function renderChildren(count, existingData = []) {

        count = parseInt(count);

        if (isNaN(count) || count < 1) {

            childrenContainer.innerHTML = '';

            return;
        }

        let html = '';

        for (let i = 0; i < count; i++) {

            const child =
                existingData[i] || {};

            const specialties =
                Array.isArray(child.terminal_specialties)
                    ? child.terminal_specialties
                    : [];

            const languages =
                Array.isArray(child.languages)
                    ? child.languages
                    : [];

            const requestedLevel =
                child.requested_level || '';

            const isAcademic =
                ACADEMIC_LEVELS.includes(requestedLevel);

            html += `

                <div
                    class="child-card"
                    data-child-index="${i}"
                >

                    <div class="child-card-title">
                        Enfant ${i + 1}
                    </div>


                    <div class="parent-reg-grid">


                        {{-- PREVIOUS SCHOOL --}}
                        <div class="parent-reg-field">

                            <label class="parent-reg-label">
                                Établissement précédent
                                <span class="required-star">*</span>
                            </label>

                            <input
                                type="text"
                                name="children[${i}][previous_school]"
                                class="parent-reg-input"
                                value="${escapeHtml(child.previous_school || '')}"
                                required
                            >

                        </div>


                        {{-- STUDIED PROGRAM --}}
                        <div class="parent-reg-field">

                            <label class="parent-reg-label">
                                Programme étudié
                                <span class="required-star">*</span>
                            </label>

                            <input
                                type="text"
                                name="children[${i}][studied_program]"
                                class="parent-reg-input"
                                value="${escapeHtml(child.studied_program || '')}"
                                required
                            >

                        </div>


                        {{-- REQUESTED LEVEL --}}
                       <div class="parent-reg-field">

                            <label class="parent-reg-label">
                                Niveau demandé
                                <span class="required-star">*</span>
                            </label>

                            <select
                                name="children[${i}][requested_level]"
                                class="parent-reg-select requested-level"
                                required
                            >

                                <option value="">
                                    Sélectionnez...
                                </option>

                                <option
                                    value="Sixieme"
                                    ${requestedLevel === 'Sixieme' ? 'selected' : ''}
                                >
                                    Sixième
                                </option>

                                <option
                                    value="Cinquieme"
                                    ${requestedLevel === 'Cinquieme' ? 'selected' : ''}
                                >
                                    Cinquième
                                </option>

                                <option
                                    value="Quatrieme"
                                    ${requestedLevel === 'Quatrieme' ? 'selected' : ''}
                                >
                                    Quatrième
                                </option>

                                <option
                                    value="Troisieme"
                                    ${requestedLevel === 'Troisieme' ? 'selected' : ''}
                                >
                                    Troisième
                                </option>

                                <option
                                    value="Seconde"
                                    ${requestedLevel === 'Seconde' ? 'selected' : ''}
                                >
                                    Seconde
                                </option>

                                <option
                                    value="Premiere-generale"
                                    ${requestedLevel === 'Premiere-generale' ? 'selected' : ''}
                                >
                                    Première générale
                                </option>

                                <option
                                    value="Premiere-STMG"
                                    ${requestedLevel === 'Premiere-STMG' ? 'selected' : ''}
                                >
                                    Première STMG
                                </option>

                                <option
                                    value="Terminale-generale"
                                    ${requestedLevel === 'Terminale-generale' ? 'selected' : ''}
                                >
                                    Terminale générale
                                </option>

                                <option
                                    value="Terminale-STMG"
                                    ${requestedLevel === 'Terminale-STMG' ? 'selected' : ''}
                                >
                                    Terminale STMG
                                </option>

                            </select>

                        </div>


                        {{-- STUDENT NAME --}}
                        <div class="parent-reg-field">

                            <label class="parent-reg-label">
                                Nom et prénom de l'enfant
                                <span class="required-star">*</span>
                            </label>

                            <input
                                type="text"
                                name="children[${i}][student_name]"
                                class="parent-reg-input"
                                value="${escapeHtml(child.student_name || '')}"
                                required
                            >

                        </div>


                        {{-- DATE OF BIRTH --}}
                        <div class="parent-reg-field">

                            <label class="parent-reg-label">
                                Date de naissance
                                <span class="required-star">*</span>
                            </label>

                            <input
                                type="date"
                                name="children[${i}][student_date_of_birth]"
                                class="parent-reg-input"
                                value="${escapeHtml(child.student_date_of_birth || '')}"
                                required
                            >

                        </div>


                        {{-- PLACE OF BIRTH --}}
                        <div class="parent-reg-field">

                            <label class="parent-reg-label">
                                Lieu de naissance
                                <span class="required-star">*</span>
                            </label>

                            <input
                                type="text"
                                name="children[${i}][student_place_of_birth]"
                                class="parent-reg-input"
                                value="${escapeHtml(child.student_place_of_birth || '')}"
                                required
                            >

                        </div>


                        {{-- STUDENT ADDRESS --}}
                        <div class="parent-reg-field full">

                            <label class="parent-reg-label">
                                Adresse de l'enfant
                                <span class="required-star">*</span>
                            </label>

                            <textarea
                                name="children[${i}][student_address]"
                                class="parent-reg-textarea"
                                required
                            >${escapeHtml(child.student_address || '')}</textarea>

                        </div>


                        {{-- STUDENT STATUS --}}
                        <div class="parent-reg-field">

                            <label class="parent-reg-label">
                                Situation de l'enfant
                                <span class="required-star">*</span>
                            </label>

                            <select
                                name="children[${i}][student_status]"
                                class="parent-reg-select"
                                required
                            >

                                <option value="">
                                    Sélectionnez...
                                </option>

                                <option
                                    value="Nouveau"
                                    ${child.student_status === 'Nouveau' ? 'selected' : ''}
                                >
                                    Nouveau
                                </option>

                                <option
                                    value="Ancien élève"
                                    ${child.student_status === 'Ancien élève' ? 'selected' : ''}
                                >
                                    Ancien élève
                                </option>

                                <option
                                    value="Transfert"
                                    ${child.student_status === 'Transfert' ? 'selected' : ''}
                                >
                                    Transfert
                                </option>

                            </select>

                        </div>


                        {{-- EDUCATIONAL NEEDS --}}
                        <div class="parent-reg-field">

                            <label class="parent-reg-label">
                                Besoins éducatifs particuliers
                                <span class="required-star">*</span>
                            </label>

                            <textarea
                                name="children[${i}][educational_needs]"
                                class="parent-reg-textarea"
                                required
                            >${escapeHtml(child.educational_needs || '')}</textarea>

                        </div>


                        {{-- DROPPED SUBJECT --}}
                        <div
                            class="parent-reg-field academic-fields"
                            style="display:${isAcademic ? 'block' : 'none'};"
                        >

                            <label class="parent-reg-label">
                                Matière abandonnée en Première
                                <span class="required-star">*</span>
                            </label>

                            <input
                                type="text"
                                name="children[${i}][dropped_subject]"
                                class="parent-reg-input dropped-subject"
                                value="${escapeHtml(child.dropped_subject || '')}"
                                ${isAcademic ? 'required' : ''}
                            >

                        </div>


                        {{-- SPECIALTIES --}}
                        <div
                            class="parent-reg-field full academic-fields"
                            style="display:${isAcademic ? 'block' : 'none'};"
                        >

                            <label class="parent-reg-label">
                                Spécialités
                                <span class="required-star">*</span>
                            </label>

                            <div class="checkbox-group specialties-group">

                                ${createCheckboxes(
                                    `children[${i}][terminal_specialties]`,
                                    SPECIALTIES,
                                    specialties
                                )}

                            </div>

                            <div class="help-text">
                                Veuillez sélectionner exactement 2 spécialités.
                            </div>

                        </div>


                        {{-- LANGUAGES --}}
                        <div
                            class="parent-reg-field full academic-fields"
                            style="display:${isAcademic ? 'block' : 'none'};"
                        >

                            <label class="parent-reg-label">
                                Langues
                                <span class="required-star">*</span>
                            </label>

                            <div class="checkbox-group languages-group">

                                ${createCheckboxes(
                                    `children[${i}][languages]`,
                                    LANGUAGES,
                                    languages
                                )}

                            </div>

                            <div class="help-text">
                                Veuillez sélectionner exactement 2 langues.
                            </div>

                        </div>


                        {{-- EXTRACURRICULAR ACTIVITIES --}}
                        <div class="parent-reg-field full">

                            <label class="parent-reg-label">
                                Activités extrascolaires
                            </label>

                            <textarea
                                name="children[${i}][extracurricular_activities]"
                                class="parent-reg-textarea"
                            >${escapeHtml(child.extracurricular_activities || '')}</textarea>

                        </div>


                        {{-- INTERESTED CLUBS --}}
                        <div class="parent-reg-field full">

                            <label class="parent-reg-label">
                                Clubs ou activités qui l'intéressent
                            </label>

                            <textarea
                                name="children[${i}][interested_clubs]"
                                class="parent-reg-textarea"
                            >${escapeHtml(child.interested_clubs || '')}</textarea>

                        </div>

                    </div>

                </div>

            `;
        }

        childrenContainer.innerHTML = html;

        attachLevelListeners();

        limitAcademicCheckboxes();

    }


    /*
    |--------------------------------------------------------------------------
    | REQUESTED LEVEL LISTENERS
    |--------------------------------------------------------------------------
    */

    function attachLevelListeners() {

        document
            .querySelectorAll('.requested-level')
            .forEach(select => {

                select.addEventListener('change', function () {

                    const card =
                        this.closest('.child-card');

                    if (!card) {
                        return;
                    }

                    updateAcademicFields(
                        card,
                        this.value
                    );

                });

            });

    }


    /*
    |--------------------------------------------------------------------------
    | SHOW / HIDE ACADEMIC FIELDS
    |--------------------------------------------------------------------------
    */

    function updateAcademicFields(card, level) {

        const academicFields =
            card.querySelectorAll('.academic-fields');

        const isAcademic =
            ACADEMIC_LEVELS.includes(level);

        academicFields.forEach(field => {

            field.style.display =
                isAcademic ? 'block' : 'none';

        });

        const droppedSubject =
            card.querySelector('.dropped-subject');

        if (droppedSubject) {

            droppedSubject.required =
                isAcademic;

            if (!isAcademic) {
                droppedSubject.value = '';
            }

        }

        if (!isAcademic) {

            card
                .querySelectorAll(
                    'input[name*="[terminal_specialties]"], input[name*="[languages]"]'
                )
                .forEach(input => {

                    input.checked = false;

                });

        }

    }


    /*
    |--------------------------------------------------------------------------
    | LIMIT ACADEMIC CHECKBOXES
    |--------------------------------------------------------------------------
    */

    function limitAcademicCheckboxes() {

        document
            .querySelectorAll('.specialties-group input[type="checkbox"]')
            .forEach(checkbox => {

                checkbox.addEventListener('change', function () {

                    const group =
                        this.closest('.specialties-group');

                    const checked =
                        group.querySelectorAll(
                            'input[type="checkbox"]:checked'
                        );

                    if (checked.length > 3) {

                        this.checked = false;

                        alert(
                            'Vous pouvez sélectionner exactement trois spécialités.'
                        );

                    }

                });

            });


        document
            .querySelectorAll('.languages-group input[type="checkbox"]')
            .forEach(checkbox => {

                checkbox.addEventListener('change', function () {

                    const group =
                        this.closest('.languages-group');

                    const checked =
                        group.querySelectorAll(
                            'input[type="checkbox"]:checked'
                        );

                    if (checked.length > 2) {

                        this.checked = false;

                        alert(
                            'Vous pouvez sélectionner exactement deux langues.'
                        );

                    }

                });

            });

    }


    /*
    |--------------------------------------------------------------------------
    | CHILDREN COUNT
    |--------------------------------------------------------------------------
    */

    childrenSelect.addEventListener('change', function () {

        const value = this.value;

        if (value === 'Autre') {

            childrenCustom.style.display = 'block';

            childrenCustom.focus();

            childrenHidden.value =
                childrenCustom.value || '';

            return;
        }

        childrenCustom.style.display = 'none';

        const count =
            parseInt(value);

        if (!isNaN(count) && count > 0) {

            childrenHidden.value =
                count;

            renderChildren(
                count,
                currentChildrenData()
            );

        } else {

            childrenHidden.value = '';

            childrenContainer.innerHTML = '';

        }

    });


    /*
    |--------------------------------------------------------------------------
    | CUSTOM CHILDREN COUNT
    |--------------------------------------------------------------------------
    */

    childrenCustom.addEventListener('input', function () {

        let count =
            parseInt(this.value);

        if (isNaN(count) || count < 1) {

            childrenHidden.value = '';

            childrenContainer.innerHTML = '';

            return;
        }

        childrenHidden.value =
            count;

        renderChildren(
            count,
            currentChildrenData()
        );

    });


    /*
    |--------------------------------------------------------------------------
    | PASSWORD MATCH
    |--------------------------------------------------------------------------
    */

    const password =
        document.getElementById('password');

    const passwordConfirmation =
        document.getElementById('password_confirmation');

    const passwordMatchMessage =
        document.getElementById('password-match-message');


    function checkPasswordsMatch() {

        if (!passwordConfirmation.value) {

            passwordMatchMessage.textContent = '';

            return true;
        }

        if (
            password.value !==
            passwordConfirmation.value
        ) {

            passwordMatchMessage.textContent =
                'Les mots de passe ne correspondent pas.';

            passwordMatchMessage.style.color =
                '#dc2626';

            return false;

        }

        passwordMatchMessage.textContent =
            'Les mots de passe correspondent.';

        passwordMatchMessage.style.color =
            '#059669';

        return true;
    }


    password.addEventListener(
        'input',
        checkPasswordsMatch
    );

    passwordConfirmation.addEventListener(
        'input',
        checkPasswordsMatch
    );


    /*
    |--------------------------------------------------------------------------
    | FORM SUBMIT
    |--------------------------------------------------------------------------
    */

    const form =
        document.getElementById('parent-reg-form');

    const submitButton =
        document.getElementById('parent-reg-submit');


    form.addEventListener('submit', function (event) {

        let valid = true;


        /*
        |--------------------------------------------------------------------------
        | CHILDREN COUNT
        |--------------------------------------------------------------------------
        */

        const count =
            parseInt(childrenHidden.value);

        if (
            isNaN(count) ||
            count < 1
        ) {

            valid = false;

            alert(
                'Veuillez sélectionner le nombre d\'enfants.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | PASSWORD MATCH
        |--------------------------------------------------------------------------
        */

        if (!checkPasswordsMatch()) {

            valid = false;

        }


        /*
        |--------------------------------------------------------------------------
        | ACADEMIC VALIDATION
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll('.child-card')
            .forEach(card => {

                const levelSelect =
                    card.querySelector('.requested-level');

                if (!levelSelect) {
                    return;
                }

                const level =
                    levelSelect.value;

                if (
                    ACADEMIC_LEVELS.includes(level)
                ) {

                    const specialties =
                        card.querySelectorAll(
                            '.specialties-group input[type="checkbox"]:checked'
                        );

                    const languages =
                        card.querySelectorAll(
                            '.languages-group input[type="checkbox"]:checked'
                        );

                    if (specialties.length !== 2) {

                        valid = false;

                        alert(
                            'Pour une Première ou Terminale générale, veuillez sélectionner exactement 2 spécialités.'
                        );

                        return;

                    }

                    if (languages.length !== 2) {

                        valid = false;

                        alert(
                            'Pour une Première ou Terminale générale, veuillez sélectionner exactement 2 langues.'
                        );

                        return;

                    }

                }

            });


        /*
        |--------------------------------------------------------------------------
        | STOP SUBMISSION
        |--------------------------------------------------------------------------
        */

        if (!valid) {

            event.preventDefault();

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | DISABLE BUTTON
        |--------------------------------------------------------------------------
        */

        submitButton.disabled = true;

        submitButton.textContent =
            'Envoi en cours...';

    });


    /*
    |--------------------------------------------------------------------------
    | RESTORE OLD FORM DATA
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            let oldCount =
                parseInt(OLD_NUMBER_OF_CHILDREN);

            if (
                !isNaN(oldCount) &&
                oldCount > 0
            ) {

                if (
                    oldCount === 1 ||
                    oldCount === 2 ||
                    oldCount === 3
                ) {

                    childrenSelect.value =
                        String(oldCount);

                    childrenCustom.style.display =
                        'none';

                } else {

                    childrenSelect.value =
                        'Autre';

                    childrenCustom.style.display =
                        'block';

                    childrenCustom.value =
                        oldCount;

                }

                childrenHidden.value =
                    oldCount;

                renderChildren(
                    oldCount,
                    OLD_CHILDREN
                );

            }

        }
    );

</script>
<script>
    document.querySelectorAll('.toggle-password').forEach(button => {
    button.addEventListener('click', function () {
        const targetId = this.getAttribute('data-target');
        const input = document.getElementById(targetId);
        if (!input) return;

        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';

        // Toggle the "visible" state for styling (eye slash, etc.)
        this.classList.toggle('is-visible', isPassword);

        // Update accessibility label
        this.setAttribute(
            'aria-label',
            isPassword ? 'Masquer le mot de passe' : 'Afficher le mot de passe'
        );
    });
});
</script>
</body>
</html>

