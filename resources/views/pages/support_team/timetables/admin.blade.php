@extends('layouts.master')

@section('title', 'Timetable Management')

@section('content')

<div class="container-fluid">

    <div class="row">

        <div class="col-12">

            <div class="card">

                <div class="card-header">
                    <h4 class="mb-0">
                        Timetable Management
                    </h4>
                </div>

                <div class="card-body">

                    {{-- CLASS SELECT --}}
                    <form method="GET"
                          action="{{ route('admin-timetable.index') }}"
                          class="mb-4">

                        <div class="row">

                            <div class="col-md-6">

                                <label>
                                    Select Class
                                </label>

                                <select
                                    name="class_id"
                                    class="form-control"
                                    onchange="this.form.submit()"
                                >

                                    <option value="">
                                        -- Select Class --
                                    </option>

                                    @foreach($classes as $class)

                                        <option
                                            value="{{ $class->id }}"
                                            {{ (int)$selectedClassId === (int)$class->id ? 'selected' : '' }}
                                        >
                                            {{ $class->name }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </form>


                    @if($selectedClassId)

                        <hr>

                        <h5 class="mb-3">
                            Timetable
                        </h5>


                        {{-- EXISTING ROWS --}}
                        <div class="table-responsive">

                            <table class="table table-bordered table-striped">

                                <thead>

                                    <tr>

                                        <th width="15%">
                                            Day
                                        </th>

                                        <th width="12%">
                                            From
                                        </th>

                                        <th width="12%">
                                            To
                                        </th>

                                        <th>
                                            Subject
                                        </th>

                                        <th width="25%">
                                            Actions
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                @forelse($rows as $row)

                                    <tr>

                                        <form
                                            method="POST"
                                            action="{{ route('admin-timetable.update', $row->id) }}"
                                        >

                                            @csrf
                                            @method('PUT')

                                            <td>

                                                <select
                                                    name="day"
                                                    class="form-control"
                                                >

                                                    @foreach([
                                                        'Sunday',
                                                        'Monday',
                                                        'Tuesday',
                                                        'Wednesday',
                                                        'Thursday',
                                                        'Friday',
                                                        'Saturday'
                                                    ] as $day)

                                                        <option
                                                            value="{{ $day }}"
                                                            {{ $row->day == $day ? 'selected' : '' }}
                                                        >
                                                            {{ $day }}
                                                        </option>

                                                    @endforeach

                                                </select>

                                            </td>


                                            <td>

                                                <input
                                                    type="time"
                                                    name="time_from"
                                                    class="form-control"
                                                    value="{{ $row->time_slot ? date('H:i', $row->time_slot->timestamp_from) : '' }}"
                                                    required
                                                >

                                            </td>


                                            <td>

                                                <input
                                                    type="time"
                                                    name="time_to"
                                                    class="form-control"
                                                    value="{{ $row->time_slot ? date('H:i', $row->time_slot->timestamp_to) : '' }}"
                                                    required
                                                >

                                            </td>


                                            <td>

                                                <select
                                                    name="subject_id"
                                                    class="form-control"
                                                >

                                                    @foreach($subjects as $subject)

                                                        <option
                                                            value="{{ $subject->id }}"
                                                            {{ $row->subject_id == $subject->id ? 'selected' : '' }}
                                                        >
                                                            {{ $subject->name }}
                                                        </option>

                                                    @endforeach

                                                </select>

                                            </td>


                                            <td>

                                                <button
                                                    type="submit"
                                                    class="btn btn-primary btn-sm"
                                                >
                                                    Update
                                                </button>

                                        </form>


                                                <form
                                                    method="POST"
                                                    action="{{ route('admin-timetable.destroy', $row->id) }}"
                                                    style="display:inline-block"
                                                >

                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Delete this timetable row?')"
                                                    >
                                                        Delete
                                                    </button>

                                                </form>

                                            </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="5"
                                            class="text-center"
                                        >
                                            No timetable rows yet.
                                        </td>

                                    </tr>

                                @endforelse

                                </tbody>

                            </table>

                        </div>


                        {{-- ADD --}}
                        <hr>

                        <h5 class="mb-3">
                            Add Timetable Row
                        </h5>

                        <form
                            method="POST"
                            action="{{ route('admin-timetable.store') }}"
                        >

                            @csrf

                            <input
                                type="hidden"
                                name="class_id"
                                value="{{ $selectedClassId }}"
                            >


                            <div class="row">

                                {{-- DAY --}}
                                <div class="col-md-2">

                                    <label>
                                        Day
                                    </label>

                                    <select
                                        name="day"
                                        class="form-control"
                                        required
                                    >

                                        <option value="Sunday">
                                            Sunday
                                        </option>

                                        <option value="Monday">
                                            Monday
                                        </option>

                                        <option value="Tuesday">
                                            Tuesday
                                        </option>

                                        <option value="Wednesday">
                                            Wednesday
                                        </option>

                                        <option value="Thursday">
                                            Thursday
                                        </option>

                                        <option value="Friday">
                                            Friday
                                        </option>

                                        <option value="Saturday">
                                            Saturday
                                        </option>

                                    </select>

                                </div>


                                {{-- FROM --}}
                                <div class="col-md-2">

                                    <label>
                                        From
                                    </label>

                                    <input
                                        type="time"
                                        name="time_from"
                                        class="form-control"
                                        required
                                    >

                                </div>


                                {{-- TO --}}
                                <div class="col-md-2">

                                    <label>
                                        To
                                    </label>

                                    <input
                                        type="time"
                                        name="time_to"
                                        class="form-control"
                                        required
                                    >

                                </div>


                                {{-- SUBJECT --}}
                                <div class="col-md-3">

                                    <label>
                                        Subject
                                    </label>

                                    <select
                                        name="subject_id"
                                        class="form-control"
                                    >

                                        <option value="">
                                            -- Select Subject --
                                        </option>

                                        @foreach($subjects as $subject)

                                            <option
                                                value="{{ $subject->id }}"
                                            >
                                                {{ $subject->name }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                {{-- NEW SUBJECT --}}
                                <div class="col-md-3">

                                    <label>
                                        Or New Subject
                                    </label>

                                    <input
                                        type="text"
                                        name="new_subject"
                                        class="form-control"
                                        placeholder="Example: Mathematics"
                                    >

                                </div>

                            </div>


                            <div class="mt-3">

                                <button
                                    type="submit"
                                    class="btn btn-success"
                                >
                                    Add Timetable Row
                                </button>

                            </div>

                        </form>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection