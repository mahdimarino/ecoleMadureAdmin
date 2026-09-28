@extends('layouts.master')

@section('page_title', 'Matériel de cours')

@section('content')

<div class="card">


<div class="card-header d-flex justify-content-between align-items-center">

    <h5 class="mb-0">
        <i class="icon-book"></i>
        Mes supports de cours
    </h5>

    <a href="{{ route('teacher.course_materials.create') }}"
       class="btn btn-primary">
        <i class="icon-plus3"></i>
        Ajouter un support
    </a>

</div>

<div class="card-body">

    @if(session('flash_success'))

        <div class="alert alert-success">
            {{ session('flash_success') }}
        </div>

    @endif


    @if($materials->count())

        {{-- Filtres --}}
        <div class="row mb-4">

            {{-- Année --}}
            <div class="col-md-4">

                <label class="font-weight-semibold">
                    Année
                </label>

                <select id="filterYear" class="form-control">

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
            <div class="col-md-4">

                <label class="font-weight-semibold">
                    Enseignant
                </label>

                <select id="filterTeacher" class="form-control">

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
            <div class="col-md-4">

                <label class="font-weight-semibold">
                    Classe
                </label>

                <select id="filterClass" class="form-control">

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

        </div>


        {{-- Tableau des supports --}}
        <div class="table-responsive">

            <table class="table table-bordered table-striped">

                <thead>

                    <tr>
                        <th>#</th>
                        <th>Titre</th>
                        <th>Enseignant</th>
                        <th>Classe</th>
                        <th>Fichier</th>
                        <th>Taille</th>
                        <th>Date</th>
                        <th width="180">Actions</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($materials as $material)

                        <tr class="material-item"

                            data-year="{{ $material->created_at->format('Y') }}"

                            data-teacher="{{ $material->teacher->name ?? 'N/A' }}"

                            data-class="{{ $material->my_class->name ?? 'N/A' }}">

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>

                                <strong>
                                    {{ $material->title }}
                                </strong>

                                @if($material->description)

                                    <br>

                                    <small class="text-muted">
                                        {{ $material->description }}
                                    </small>

                                @endif

                            </td>

                            <td>
                                {{ $material->teacher->name ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $material->my_class->name ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $material->file_name }}
                            </td>

                            <td>

                                {{ $material->file_size
                                    ? number_format($material->file_size / 1024, 1) . ' Ko'
                                    : 'N/A'
                                }}

                            </td>

                            <td>
                                {{ $material->created_at->format('d/m/Y') }}
                            </td>

                            <td>

                                {{-- Voir --}}
                                <a href="{{ route('course_materials.download', Qs::hash($material->id)) }}"
                                   class="btn btn-sm btn-info"
                                   target="_blank">

                                    <i class="icon-eye"></i>

                                </a>


                                {{-- Modifier --}}
                                <a href="{{ route('teacher.course_materials.edit', ['id' => Qs::hash($material->id)]) }}"
                                   class="btn btn-sm btn-warning">

                                    <i class="icon-pencil"></i>

                                </a>


                                {{-- Supprimer --}}
                                <form action="{{ route('teacher.course_materials.destroy', ['id' => Qs::hash($material->id)]) }}"
                                      method="POST"
                                      style="display:inline-block;"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce support ?');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-danger">

                                        <i class="icon-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- Aucun résultat après filtrage --}}
        <div id="noFilterResults"
             class="text-center py-5"
             style="display:none;">

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
                Aucun support de cours
            </h5>

            <p class="text-muted">
                Ajoutez votre premier support de cours pour vos élèves.
            </p>

            <a href="{{ route('teacher.course_materials.create') }}"
               class="btn btn-primary">

                <i class="icon-plus3"></i>
                Ajouter un support

            </a>

        </div>

    @endif

</div>


</div>

{{-- Script des filtres --}}

<script>

    $(document).ready(function () {

        function filterMaterials() {

            let year = $('#filterYear').val();
            let teacher = $('#filterTeacher').val();
            let className = $('#filterClass').val();

            let visibleCount = 0;

            $('.material-item').each(function () {

                let itemYear = $(this).data('year').toString();
                let itemTeacher = $(this).data('teacher').toString();
                let itemClass = $(this).data('class').toString();

                let matchesYear =
                    !year || itemYear === year;

                let matchesTeacher =
                    !teacher || itemTeacher === teacher;

                let matchesClass =
                    !className || itemClass === className;

                if (matchesYear && matchesTeacher && matchesClass) {

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


        $('#filterYear, #filterTeacher, #filterClass')
            .on('change', filterMaterials);

    });

</script>

@endsection
