@extends('layouts.master')
@section('page_title', 'Import Schedule')
@section('content')

    <div class="card">
        <div class="card-header bg-white header-elements-inline">
            <h6 class="card-title">Import Emploi du Temps</h6>
        </div>

        <div class="card-body">

            {{-- STEP 1: choose the class --}}
            <form method="get" action="{{ route('timetables.import') }}" class="mb-4">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <div class="form-group mb-0">
                            <label for="class_id">Class: <span class="text-danger">*</span></label>
                            <select onchange="this.form.submit()" required name="class_id" id="class_id" class="select-search form-control">
                                <option value="">Choose a class...</option>
                                @foreach($classes as $c)
                                    <option {{ ($selected_class && $selected_class->id == $c->id) ? 'selected' : '' }} value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </form>

            @if($selected_class)

                @if($subjects->isEmpty())
                    <div class="alert alert-warning border-0">
                        You don't have any subjects assigned for <strong>{{ $selected_class->name }}</strong>, so there's nothing to import a schedule against yet. Contact an administrator to get assigned to a subject in this class first.
                    </div>
                @else

                    <hr>

                    <h6>Step 2 — Download the template, fill it in, then upload it</h6>

                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted">
                                The template lists the subjects you can use for <strong>{{ $selected_class->name }}</strong>:
                                <strong>{{ $subjects->pluck('name')->implode(', ') }}</strong>.
                            </p>

                            <a href="{{ route('timetables.import.template', ['class_id' => $selected_class->id]) }}" class="btn btn-light mb-4">
                                <i class="icon-file-download mr-2"></i> Download CSV Template
                            </a>

                            <form method="post" action="{{ route('timetables.import.store') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="class_id" value="{{ $selected_class->id }}">

                                <div class="form-group">
                                    <label>Filled-in CSV file: <span class="text-danger">*</span></label>
                                    <input required accept=".csv,text/csv" type="file" name="csv_file" class="form-input-styled" data-fouc>
                                    <span class="form-text text-muted">Columns: day, start_time, end_time, subject. Times use 24h HH:MM. Max file size 2Mb.</span>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    Import Schedule <i class="icon-file-upload ml-2"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    @if(session('import_skipped') && count(session('import_skipped')))
                        <hr>
                        <div class="alert alert-warning border-0">
                            <strong>{{ count(session('import_skipped')) }} row(s) were skipped:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach(session('import_skipped') as $line)
                                    <li>{{ $line }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                @endif

            @endif

        </div>
    </div>

@endsection