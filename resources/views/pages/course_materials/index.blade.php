@extends('layouts.master')

@section('page_title', 'Supports de cours')

@section('content')

 {{-- =========================
FILTERS
========================= --}}

<div class="card mb-4 border-0 shadow-sm">

    <div class="card-header bg-white border-bottom">
        <div class="d-flex align-items-center">
            <div class="mr-3">
                <span class="d-inline-flex align-items-center justify-content-center"
                      style="width:42px;height:42px;border-radius:10px;background:#eef4ff;">
                    <i class="icon-filter3 text-primary"></i>
                </span>
            </div>

            <div>
                <h5 class="mb-0 font-weight-semibold">
                    Filtrer les supports de cours
                </h5>

                <small class="text-muted">
                    Utilisez les filtres pour trouver rapidement un support
                </small>
            </div>
        </div>
    </div>


    <div class="card-body">

        <div class="row">

            {{-- Année --}}
            <div class="col-md-4 mb-3">

                <label class="font-weight-semibold text-dark">
                    <i class="icon-calendar mr-1 text-primary"></i>
                    Année
                </label>

                <select id="filterYear"
                        class="form-control border-light shadow-sm"
                        style="border-radius:8px;">

                    <option value="">
                        Toutes les années
                    </option>

                    @foreach(
                        $materials->pluck('created_at')
                            ->map(fn($date) => $date->format('Y'))
                            ->unique()
                            ->sortDesc()
                        as $year
                    )

                        <option value="{{ $year }}">
                            {{ $year }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Enseignant --}}
            <div class="col-md-4 mb-3">

                <label class="font-weight-semibold text-dark">
                    <i class="icon-user-tie mr-1 text-primary"></i>
                    Enseignant
                </label>

                <select id="filterTeacher"
                        class="form-control border-light shadow-sm"
                        style="border-radius:8px;">

                    <option value="">
                        Tous les enseignants
                    </option>

                    @foreach(
                        $materials
                            ->map(fn($material) => $material->teacher->name ?? 'N/A')
                            ->unique()
                            ->sort()
                        as $teacher
                    )

                        <option value="{{ $teacher }}">
                            {{ $teacher }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Classe --}}
            <div class="col-md-4 mb-3">

                <label class="font-weight-semibold text-dark">
                    <i class="icon-users mr-1 text-primary"></i>
                    Classe
                </label>

                <select id="filterClass"
                        class="form-control border-light shadow-sm"
                        style="border-radius:8px;">

                    <option value="">
                        Toutes les classes
                    </option>

                    @foreach(
                        $materials
                            ->map(fn($material) => $material->my_class->name ?? 'N/A')
                            ->unique()
                            ->sort()
                        as $class
                    )

                        <option value="{{ $class }}">
                            {{ $class }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Enfant : uniquement pour les parents --}}
            @if(Auth::user()->user_type === 'parent')

                <div class="col-md-4 mb-3">

                    <label class="font-weight-semibold text-dark">
                        <i class="icon-user mr-1 text-primary"></i>
                        Enfant
                    </label>

                    <select id="filterChild"
                            class="form-control border-light shadow-sm"
                            style="border-radius:8px;">

                        <option value="">
                            Tous les enfants
                        </option>

                        @foreach($parentChildren as $child)

                            <option value="{{ $child->id }}"
                                    data-class-id="{{ $child->my_class_id }}">

                                {{ $child->user->name ?? 'N/A' }}

                            </option>

                        @endforeach

                    </select>

                </div>

            @endif

        </div>

    </div>

</div>

    {{-- =========================
COURSE MATERIALS
========================= --}}

    <div class="card">


        <div class="card-header">
            <h5 class="mb-0">
                <i class="icon-book"></i>
                Supports de cours
            </h5>
        </div>

        <div class="card-body">

            @if ($materials->count())

                <div class="row" id="materialsList">

                    @foreach ($materials as $material)
                        <div class="col-md-6 col-xl-4 mb-4 material-item"
                            data-year="{{ $material->created_at->format('Y') }}"
                            data-teacher="{{ $material->teacher->name ?? 'N/A' }}"
                            data-class="{{ $material->my_class->name ?? 'N/A' }}"
                            data-class-id="{{ $material->class_id }}">

                            <div class="card border h-100">

                                <div class="card-body">

                                    <div class="d-flex justify-content-between">

                                        <h5 class="font-weight-semibold">
                                            {{ $material->title }}
                                        </h5>

                                        <i class="icon-file-text2 icon-2x text-primary"></i>

                                    </div>

                                    <div class="mt-2">

                                        <span class="badge badge-primary">
                                            {{ $material->my_class->name ?? 'N/A' }}
                                        </span>

                                    </div>

                                    @if ($material->description)
                                        <p class="text-muted mt-3">
                                            {{ $material->description }}
                                        </p>
                                    @endif

                                    <hr>

                                    <small class="text-muted d-block">
                                        <strong>Enseignant :</strong>
                                        {{ $material->teacher->name ?? 'N/A' }}
                                    </small>

                                    <small class="text-muted d-block mt-1">
                                        <strong>Fichier :</strong>
                                        {{ $material->file_name }}
                                    </small>

                                    <small class="text-muted d-block mt-1">
                                        <strong>Date d'ajout :</strong>
                                        {{ $material->created_at->format('d/m/Y') }}
                                    </small>

                                </div>

                                <div class="card-footer bg-white">

                                    <a href="{{ route('course_materials.download', ['id' => Qs::hash($material->id)]) }}"
                                        class="btn btn-primary btn-block" target="_blank">

                                        <i class="icon-download"></i>
                                        Voir / Télécharger

                                    </a>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>


                {{-- Aucun résultat --}}
                <div id="noFilterResults" class="text-center py-5" style="display:none;">

                    <i class="icon-search4 icon-3x text-muted"></i>

                    <h5 class="mt-3">
                        Aucun support trouvé
                    </h5>

                    <p class="text-muted">
                        Essayez de modifier vos filtres.
                    </p>

                </div>
            @else
                <div class="text-center py-5">

                    <i class="icon-book icon-3x text-muted"></i>

                    <h5 class="mt-3">
                        Aucun support de cours disponible
                    </h5>

                    <p class="text-muted">
                        Votre enseignant n'a pas encore ajouté de support de cours.
                    </p>

                </div>

            @endif

        </div>


    </div>

    <script>
        $(document).ready(function() {

            function filterMaterials() {

                let year = $('#filterYear').val();
                let teacher = $('#filterTeacher').val();
                let className = $('#filterClass').val();

                let child = $('#filterChild').length ?
                    $('#filterChild').val() :
                    '';

                let visibleCount = 0;

                $('.material-item').each(function() {

                    let itemYear =
                        $(this).data('year').toString();

                    let itemTeacher =
                        $(this).data('teacher').toString();

                    let itemClass =
                        $(this).data('class').toString();

                    let itemClassId =
                        $(this).data('class-id').toString();


                    let matchesYear = !year || itemYear === year;

                    let matchesTeacher = !teacher || itemTeacher === teacher;

                    let matchesClass = !className || itemClass === className;

                    let matchesChild = true;

                    if (child) {

                        let selectedChildClassId =
                            $('#filterChild option:selected').data('class-id');

                        matchesChild =
                            itemClassId === selectedChildClassId.toString();
                    }


                    if (
                        matchesYear &&
                        matchesTeacher &&
                        matchesClass &&
                        matchesChild
                    ) {

                        $(this).show();
                        visibleCount++;

                    } else {

                        $(this).hide();

                    }

                });


                if (visibleCount === 0) {

                    $('#noFilterResults').show();

                } else {

                    $('#noFilterResults').hide();

                }

            }


            $('#filterYear, #filterTeacher, #filterClass, #filterChild')
                .on('change', filterMaterials);

        });
    </script>

@endsection
