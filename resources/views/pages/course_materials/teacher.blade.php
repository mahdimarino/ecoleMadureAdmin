@extends('layouts.master')

@section('page_title', 'Course Materials')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="icon-book"></i>
            My Course Materials
        </h5>

        <a href="{{ route('teacher.course_materials.create') }}"
           class="btn btn-primary">
            <i class="icon-plus3"></i>
            Add Course Material
        </a>
    </div>

    <div class="card-body">

        @if(session('flash_success'))
            <div class="alert alert-success">
                {{ session('flash_success') }}
            </div>
        @endif

        @if($materials->count())

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Teacher</th>
                            <th>Class</th>
                            <th>File</th>
                            <th>Size</th>
                            <th>Date</th>
                            <th width="180">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($materials as $material)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <strong>{{ $material->title }}</strong>

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
                                        ? number_format($material->file_size / 1024, 1) . ' KB'
                                        : 'N/A'
                                    }}
                                </td>

                                <td>
                                    {{ $material->created_at->format('d/m/Y') }}
                                </td>

                                <td>

                                    <a href="{{ route('course_materials.download', Qs::hash($material->id)) }}"
   class="btn btn-sm btn-info"
   target="_blank">
    <i class="icon-eye"></i>
</a>

                                  <a href="{{ route('teacher.course_materials.edit', ['id' => Qs::hash($material->id)]) }}"
   class="btn btn-sm btn-warning">
    <i class="icon-pencil"></i>
</a>

                                    <form action="{{ route('teacher.course_materials.destroy', ['id' => Qs::hash($material->id)]) }}"
                                          method="POST"
                                          style="display:inline-block;"
                                          onsubmit="return confirm('Are you sure you want to delete this material?');">

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

        @else

            <div class="text-center py-5">
                <i class="icon-book icon-3x text-muted"></i>

                <h5 class="mt-3">
                    No course materials yet
                </h5>

                <p class="text-muted">
                    Upload your first course material for your students.
                </p>

                <a href="{{ route('teacher.course_materials.create') }}"
                   class="btn btn-primary">
                    <i class="icon-plus3"></i>
                    Add Course Material
                </a>
            </div>

        @endif

    </div>
</div>

@endsection