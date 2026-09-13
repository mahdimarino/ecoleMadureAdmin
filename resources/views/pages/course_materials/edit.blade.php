@extends('layouts.master')

@section('page_title', 'Edit Course Material')

@section('content')

<div class="card">

    <div class="card-header">
        <h5 class="mb-0">
            <i class="icon-pencil"></i>
            Edit Course Material
        </h5>
    </div>

    <div class="card-body">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('teacher.course_materials.update', $material->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label>
                            Title <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title', $material->title) }}"
                               required>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>
                            Class <span class="text-danger">*</span>
                        </label>

                        <select name="class_id"
                                class="form-control"
                                required>

                            @foreach($classes as $class)
                                <option value="{{ $class->id }}"
                                    {{ old('class_id', $material->class_id) == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                </div>

                <div class="col-md-12">

                    <div class="form-group">
                        <label>Description</label>

                        <textarea name="description"
                                  class="form-control"
                                  rows="4">{{ old('description', $material->description) }}</textarea>
                    </div>

                </div>

                <div class="col-md-12">

                    <div class="alert alert-info">

                        <strong>Current file:</strong>

                        {{ $material->file_name }}

                    </div>

                </div>

                <div class="col-md-12">

                    <div class="form-group">

                        <label>
                            Replace File
                        </label>

                        <input type="file"
                               name="file"
                               class="form-control"
                               accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.webp">

                        <small class="text-muted">
                            Leave empty if you don't want to replace the current file.
                            Maximum size: 20 MB.
                        </small>

                    </div>

                </div>

            </div>

            <div class="mt-3">

                <button type="submit"
                        class="btn btn-primary">
                    <i class="icon-check"></i>
                    Update Material
                </button>

                <a href="{{ route('teacher.course_materials') }}"
                   class="btn btn-light">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection