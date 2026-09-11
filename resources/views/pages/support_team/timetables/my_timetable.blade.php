@extends('layouts.master')

@section('title', 'My Timetable')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">

            <h4 class="mb-0">
                My Timetable
            </h4>

        </div>

        <div class="card-body">


            @if($classes->count() > 1)

                <form method="GET" class="mb-4">

                    <label>
                        Select Class
                    </label>

                    <select
                        name="class_id"
                        class="form-control"
                        onchange="this.form.submit()"
                    >

                        @foreach($classes as $class)

                            <option
                                value="{{ $class->id }}"
                                {{ (int)$selectedClassId === (int)$class->id ? 'selected' : '' }}
                            >
                                {{ $class->name }}
                            </option>

                        @endforeach

                    </select>

                </form>

            @endif


            @if($rows->count())

                <div class="table-responsive">

                    <table class="table table-bordered table-striped">

                        <thead>

                            <tr>

                                <th>
                                    Day
                                </th>

                                <th>
                                    From
                                </th>

                                <th>
                                    To
                                </th>

                                <th>
                                    Subject
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                        @php

                            $days = [
                                'Sunday' => 1,
                                'Monday' => 2,
                                'Tuesday' => 3,
                                'Wednesday' => 4,
                                'Thursday' => 5,
                                'Friday' => 6,
                                'Saturday' => 7,
                            ];

                            $rows = $rows->sortBy(function($row) use ($days) {

                                $day = $days[$row->day] ?? 99;

                                $time = $row->time_slot
                                    ? $row->time_slot->timestamp_from
                                    : 0;

                                return ($day * 100000) + $time;
                            });

                        @endphp


                        @foreach($rows as $row)

                            <tr>

                                <td>
                                    {{ $row->day }}
                                </td>

                                <td>

                                    @if($row->time_slot)

                                        {{ date('H:i', $row->time_slot->timestamp_from) }}

                                    @endif

                                </td>

                                <td>

                                    @if($row->time_slot)

                                        {{ date('H:i', $row->time_slot->timestamp_to) }}

                                    @endif

                                </td>

                                <td>

                                    {{ $row->subject->name ?? '-' }}

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="alert alert-info">

                    No timetable available for this class.

                </div>

            @endif

        </div>

    </div>

</div>

@endsection