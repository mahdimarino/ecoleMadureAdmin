@extends('layouts.master')

@section('page_title', 'Course Materials')

@section('content')

<div class="card">

    <div class="card-header">
        <h5 class="mb-0">
            <i class="icon-book"></i>
            Course Materials
        </h5>
    </div>

    <div class="card-body">

        @if($materials->count())

            <div class="row">

                @foreach($materials as $material)

                    <div class="col-md-6 col-xl-4 mb-4">

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

                                @if($material->description)

                                    <p class="text-muted mt-3">
                                        {{ $material->description }}
                                    </p>

                                @endif

                                <hr>

                                <small class="text-muted d-block">
                                    <strong>Teacher:</strong>
                                    {{ $material->teacher->name ?? 'N/A' }}
                                </small>

                                <small class="text-muted d-block mt-1">
                                    <strong>File:</strong>
                                    {{ $material->file_name }}
                                </small>

                                <small class="text-muted d-block mt-1">
                                    <strong>Uploaded:</strong>
                                    {{ $material->created_at->format('d/m/Y') }}
                                </small>

                            </div>

                            <div class="card-footer bg-white">

                                <a href="{{ route('course_materials.download', $material->id) }}"
                                   class="btn btn-primary btn-block"
                                   target="_blank">

                                    <i class="icon-download"></i>
                                    View / Download

                                </a>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="text-center py-5">

                <i class="icon-book icon-3x text-muted"></i>

                <h5 class="mt-3">
                    No course materials available
                </h5>

                <p class="text-muted">
                    Your teacher has not uploaded any course materials yet.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection