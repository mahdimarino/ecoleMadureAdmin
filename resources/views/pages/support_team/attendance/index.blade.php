@extends('layouts.master')

@section('page_title', 'Student Attendance')

@section('content')

<div class="card">

    <div class="card-header header-elements-inline">

        <h6 class="card-title">
            Student Attendance
        </h6>

        <div class="header-elements">

            <form
                method="GET"
                action="{{ route('attendance.index') }}"
                class="form-inline"
            >

                <label class="mr-2">
                    Date
                </label>

                <input
                    type="date"
                    name="date"
                    value="{{ $date }}"
                    class="form-control mr-2"
                >

                <button
                    type="submit"
                    class="btn btn-light"
                >
                    View
                </button>

            </form>

        </div>

    </div>


    <div class="card-body">

        <table class="table datatable-button-html5-columns">

            <thead>

            <tr>

                <th>S/N</th>

                <th>Photo</th>

                <th>Student</th>

                <th>Class</th>

                {{-- <th>Section</th> --}}

                <th>Parent</th>

                <th>Status</th>

                <th>Action</th>

            </tr>

            </thead>


            <tbody>

            @foreach($students as $student)

                @php
                    $record = $attendance->get($student->id);
                @endphp

                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>


                    <td>

                        <img
                            class="rounded-circle"
                            style="height:40px;width:40px;"
                            src="{{ $student->user->photo }}"
                            alt="photo"
                        >

                    </td>


                    <td>
                        {{ $student->user->name }}
                    </td>


                    <td>
                        {{ optional($student->my_class)->name ?? '-' }}
                    </td>


                    {{-- <td>
                        {{ optional($student->section)->name ?? '-' }}
                    </td> --}}


                    <td>

                        {{ optional($student->my_parent)->name
                            ?? 'No parent linked' }}

                    </td>


                    <td>

                        @if($record && $record->status === 'absent')

                            <span class="badge badge-danger">
                                Absent
                            </span>

                        @else

                            <span class="badge badge-success">
                                Present
                            </span>

                        @endif

                    </td>


                    <td>

                        @if(!$record || $record->status !== 'absent')

                            <button
                                type="button"
                                class="btn btn-sm btn-danger"
                                data-toggle="modal"
                                data-target="#absenceModal"

                                data-student-id="{{ $student->id }}"

                                data-student-name="{{ $student->user->name }}"

                                data-date="{{ $date }}"
                            >

                                <i class="icon-cross2 mr-1"></i>

                                Mark absent

                            </button>

                        @else

                            <span class="text-muted">
                                Already marked absent
                            </span>

                        @endif

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>

</div>


{{-- ========================================================= --}}
{{-- ABSENCE MODAL --}}
{{-- ========================================================= --}}

<div
    class="modal fade"
    id="absenceModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="absenceModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog" role="document">

        <form
            method="POST"
            action="{{ route('attendance.mark_absent') }}"
            class="modal-content"
        >

            @csrf


            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="absenceModalLabel"
                >
                    Mark Student Absent
                </h5>

                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                >

                    <span>
                        &times;
                    </span>

                </button>

            </div>


            <div class="modal-body">

                <input
                    type="hidden"
                    name="student_id"
                    id="absence_student_id"
                >


                <div class="form-group">

                    <label>
                        Student
                    </label>

                    <input
                        type="text"
                        id="absence_student_name"
                        class="form-control"
                        readonly
                    >

                </div>


                <div class="form-group">

                    <label>
                        Date
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="date"
                        name="date"
                        id="absence_date"
                        class="form-control"
                        value="{{ $date }}"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Note
                        <small class="text-muted">
                            Optional
                        </small>
                    </label>

                    <textarea
                        name="note"
                        id="absence_note"
                        class="form-control"
                        rows="4"
                        maxlength="2000"
                        placeholder="Add a note about the absence..."
                    ></textarea>

                </div>


                <div class="alert alert-warning">

                    <i class="icon-warning22 mr-1"></i>

                    The parent will receive an email and a notification
                    in their account after submission.

                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-dismiss="modal"
                >
                    Cancel
                </button>


                <button
                    type="submit"
                    class="btn btn-danger"
                >

                    <i class="icon-checkmark3 mr-1"></i>

                    Submit as absent

                </button>

            </div>

        </form>

    </div>

</div>

@endsection


@section('scripts')

<script>

$(function () {

    $('#absenceModal').on(
        'show.bs.modal',
        function (event) {

            var button = $(event.relatedTarget);

            $('#absence_student_id')
                .val(
                    button.data('student-id')
                );

            $('#absence_student_name')
                .val(
                    button.data('student-name')
                );

            $('#absence_date')
                .val(
                    button.data('date')
                );

            $('#absence_note')
                .val('');

        }
    );

});

</script>

@endsection