
@extends('layouts.master')
@section('page_title', 'Admettre un élève')
@section('content')

<div class="card">
    <div class="card-header bg-white header-elements-inline">
        <h6 class="card-title">Veuillez remplir le formulaire ci-dessous pour inscrire un nouvel élève</h6>

        {!! Qs::getPanelOptions() !!}
    </div>

    <form id="ajax-reg"
          method="post"
          enctype="multipart/form-data"
          class="wizard-form steps-validation"
          action="{{ route('students.store') }}"
          data-fouc>

        @csrf

        {{-- Informations personnelles --}}
        <h6>Informations personnelles</h6>

        <fieldset>

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nom complet : <span class="text-danger">*</span></label>
                        <input
                            value="{{ old('name') }}"
                            required
                            type="text"
                            name="name"
                            placeholder="Nom complet"
                            class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Adresse : <span class="text-danger">*</span></label>
                        <input
                            value="{{ old('address') }}"
                            class="form-control"
                            placeholder="Adresse"
                            name="address"
                            type="text"
                            required>
                    </div>
                </div>

            </div>


            <div class="row">

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Adresse e-mail :</label>
                        <input
                            type="email"
                            value="{{ old('email') }}"
                            name="email"
                            class="form-control"
                            placeholder="Adresse e-mail">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="gender">
                            Sexe : <span class="text-danger">*</span>
                        </label>

                        <select
                            class="select form-control"
                            id="gender"
                            name="gender"
                            required
                            data-fouc
                            data-placeholder="Choisir...">

                            <option value=""></option>

                            <option
                                {{ (old('gender') == 'Male') ? 'selected' : '' }}
                                value="Male">
                                Masculin
                            </option>

                            <option
                                {{ (old('gender') == 'Female') ? 'selected' : '' }}
                                value="Female">
                                Féminin
                            </option>

                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Téléphone :</label>
                        <input
                            value="{{ old('phone') }}"
                            type="text"
                            name="phone"
                            class="form-control"
                            placeholder="Numéro de téléphone">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Téléphone secondaire :</label>
                        <input
                            value="{{ old('phone2') }}"
                            type="text"
                            name="phone2"
                            class="form-control"
                            placeholder="Numéro secondaire">
                    </div>
                </div>

            </div>


            <div class="row">

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Date de naissance :</label>

                        <input
                            name="dob"
                            value="{{ old('dob') }}"
                            type="text"
                            class="form-control date-pick"
                            placeholder="Sélectionner une date...">
                    </div>
                </div>

                {{-- Valeurs par défaut --}}
                <input type="hidden" name="nal_id" id="nal_id" value="3">
                <input type="hidden" name="state_id" id="state_id" value="1">
                <input type="hidden" name="lga_id" id="lga_id" value="13">

            </div>


            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="bg_id">Groupe sanguin :</label>

                        <select
                            class="select form-control"
                            id="bg_id"
                            name="bg_id"
                            data-fouc
                            data-placeholder="Choisir...">

                            <option value=""></option>

                            @foreach(App\Models\BloodGroup::all() as $bg)
                                <option
                                    {{ (old('bg_id') == $bg->id ? 'selected' : '') }}
                                    value="{{ $bg->id }}">
                                    {{ $bg->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label class="d-block">Photo d'identité :</label>

                        <input
                            accept="image/*"
                            type="file"
                            name="photo"
                            class="form-input-styled"
                            data-fouc>

                        <span class="form-text text-muted">
                            Images acceptées : JPEG, PNG. Taille maximale : 2 Mo
                        </span>
                    </div>
                </div>

            </div>


            {{-- Mot de passe --}}
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label>
                            Mot de passe : <span class="text-danger">*</span>
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Mot de passe"
                            required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>
                            Confirmer le mot de passe : <span class="text-danger">*</span>
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            placeholder="Confirmer le mot de passe"
                            required>
                    </div>
                </div>

            </div>

        </fieldset>


        {{-- Informations scolaires --}}
        <h6>Informations scolaires</h6>

        <fieldset>

            <div class="row">

                <div class="col-md-3">
                    <div class="form-group">

                        <label for="my_class_id">
                            Classe : <span class="text-danger">*</span>
                        </label>

                        <select
                            onchange="getClassSections(this.value)"
                            data-placeholder="Choisir..."
                            required
                            name="my_class_id"
                            id="my_class_id"
                            class="select-search form-control">

                            <option value=""></option>

                            @foreach($my_classes as $c)
                                <option
                                    {{ (old('my_class_id') == $c->id ? 'selected' : '') }}
                                    value="{{ $c->id }}">
                                    {{ $c->name }}
                                </option>
                            @endforeach

                        </select>

                    </div>
                </div>


                <div class="col-md-3">
    <div class="form-group">

        <label for="section_id">
            Section : <span class="text-danger">*</span>
        </label>

        <select
            data-placeholder="Choisir une section..."
            required
            name="section_id"
            id="section_id"
            class="select-search form-control">

            <option value="">Choisir une classe d'abord</option>

        </select>

    </div>
</div>


                <div class="col-md-3">
                    <div class="form-group">

                        <label for="my_parent_id">Parent :</label>

                        <select
                            data-placeholder="Choisir..."
                            name="my_parent_id"
                            id="my_parent_id"
                            class="select-search form-control">

                            <option value=""></option>

                            @foreach($parents as $p)
                                <option
                                    {{ (old('my_parent_id') == Qs::hash($p->id)) ? 'selected' : '' }}
                                    value="{{ Qs::hash($p->id) }}">
                                    {{ $p->name }}
                                </option>
                            @endforeach

                        </select>

                    </div>
                </div>


                <div class="col-md-3">
                    <div class="form-group">

                        <label for="year_admitted">
                            Année d'inscription :
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            data-placeholder="Choisir..."
                            required
                            name="year_admitted"
                            id="year_admitted"
                            class="select-search form-control">

                            <option value=""></option>

                            @for($y=date('Y', strtotime('- 10 years')); $y<=date('Y'); $y++)

                                <option
                                    {{ (old('year_admitted') == $y) ? 'selected' : '' }}
                                    value="{{ $y }}">
                                    {{ $y }}
                                </option>

                            @endfor

                        </select>

                    </div>
                </div>

            </div>

        </fieldset>

    </form>
</div>

@endsection
