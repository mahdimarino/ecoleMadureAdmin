@extends('layouts.master')

@section('content')

<div class="content-wrapper">

    <div class="content">

        {{-- PAGE HEADER --}}
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title">
                    <h4>
                        <i class="icon-graduation mr-2"></i>
                        <span class="font-weight-semibold">
                            Student Applications
                        </span>
                    </h4>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-3">

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}

                    <button type="button"
                            class="close"
                            data-dismiss="alert">
                        &times;
                    </button>
                </div>
            @endif

            {{-- FILTERS --}}
            <div class="card">

                <div class="card-header">
                    <h5 class="card-title">
                        <i class="icon-filter4 mr-2"></i>
                        Filter Applications
                    </h5>
                </div>

                <div class="card-body">

                    <form method="GET"
                          action="{{ route('student-applications.index') }}">

                        <div class="row">

                            {{-- SEARCH --}}
                            <div class="col-md-4">
                                <label>Search</label>

                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    class="form-control"
                                    placeholder="Name, application number, parent..."
                                >
                            </div>

                            {{-- STATUS --}}
                            <div class="col-md-2">

                                <label>Status</label>

                                <select
                                    name="status"
                                    class="form-control">

                                    <option value="">
                                        All Statuses
                                    </option>

                                    <option value="pending"
                                        {{ request('status') == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>

                                    <option value="reviewing"
                                        {{ request('status') == 'reviewing' ? 'selected' : '' }}>
                                        Reviewing
                                    </option>

                                    <option value="accepted"
                                        {{ request('status') == 'accepted' ? 'selected' : '' }}>
                                        Accepted
                                    </option>

                                    <option value="rejected"
                                        {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                        Rejected
                                    </option>

                                </select>

                            </div>

                            {{-- PROGRAM --}}
                            <div class="col-md-2">

                                <label>Program</label>

                                <select
                                    name="program"
                                    class="form-control">

                                    <option value="">
                                        All Programs
                                    </option>

                                    @foreach($programs as $program)

                                        <option
                                            value="{{ $program }}"
                                            {{ request('program') == $program ? 'selected' : '' }}>

                                            {{ $program }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            {{-- LEVEL --}}
                            <div class="col-md-2">

                                <label>Level</label>

                                <select
                                    name="requested_level"
                                    class="form-control">

                                    <option value="">
                                        All Levels
                                    </option>

                                    @foreach($levels as $level)

                                        <option
                                            value="{{ $level }}"
                                            {{ request('requested_level') == $level ? 'selected' : '' }}>

                                            {{ $level }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            {{-- BUTTONS --}}
                            <div class="col-md-2">

                                <label>&nbsp;</label>

                                <div>

                                    <button
                                        type="submit"
                                        class="btn btn-primary">

                                        <i class="icon-search4 mr-1"></i>
                                        Search

                                    </button>

                                    <a
                                        href="{{ route('student-applications.index') }}"
                                        class="btn btn-light">

                                        Reset

                                    </a>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>


            {{-- APPLICATIONS TABLE --}}
            <div class="card">

                <div class="card-header">

                    <h5 class="card-title">
                        Student Applications
                    </h5>

                </div>

                <div class="table-responsive">

                    <table class="table table-striped table-hover">

                        <thead>

                            <tr>

                                <th>Application</th>

                                <th>Student</th>

                                <th>Program</th>

                                <th>Level</th>

                                <th>Parent / Guardian</th>

                                <th>Status</th>

                                <th>Date</th>

                                <th class="text-center">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($applications as $application)

                                <tr>

                                    {{-- APPLICATION --}}
                                    <td>

                                        <strong>
                                            {{ $application->application_number }}
                                        </strong>

                                    </td>

                                    {{-- STUDENT --}}
                                    <td>

                                        <strong>
                                            {{ $application->full_name }}
                                        </strong>

                                        @if($application->date_of_birth)

                                            <br>

                                            <small class="text-muted">

                                                DOB:
                                                {{ $application->date_of_birth->format('d/m/Y') }}

                                            </small>

                                        @endif

                                    </td>

                                    {{-- PROGRAM --}}
                                    <td>
                                        {{ $application->program ?: '-' }}
                                    </td>

                                    {{-- LEVEL --}}
                                    <td>
                                        {{ $application->requested_level ?: '-' }}
                                    </td>

                                    {{-- PARENT --}}
                                    <td>

                                        {{ $application->parent_name ?: '-' }}

                                        @if($application->parent_phone)

                                            <br>

                                            <small class="text-muted">

                                                {{ $application->parent_phone }}

                                            </small>

                                        @endif

                                    </td>

                                    {{-- STATUS --}}
                                    <td>

                                        @if($application->status === 'pending')

                                            <span class="badge badge-warning">
                                                Pending
                                            </span>

                                        @elseif($application->status === 'reviewing')

                                            <span class="badge badge-info">
                                                Reviewing
                                            </span>

                                        @elseif($application->status === 'accepted')

                                            <span class="badge badge-success">
                                                Accepted
                                            </span>

                                        @elseif($application->status === 'rejected')

                                            <span class="badge badge-danger">
                                                Rejected
                                            </span>

                                        @endif

                                    </td>

                                    {{-- DATE --}}
                                    <td>

                                        {{ $application->created_at->format('d/m/Y') }}

                                        <br>

                                        <small class="text-muted">

                                            {{ $application->created_at->format('H:i') }}

                                        </small>

                                    </td>

                                    {{-- ACTIONS --}}
                                    <td class="text-center">

                                        <a
                                            href="{{ route('student-applications.show', $application->id) }}"
                                            class="btn btn-sm btn-primary">

                                            <i class="icon-eye"></i>
                                            View

                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="8"
                                        class="text-center py-4">

                                        <i class="icon-folder-remove icon-2x d-block mb-2"></i>

                                        No student applications found.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- PAGINATION --}}
                <div class="card-footer">

                    {{ $applications->links() }}

                </div>

            </div>

        </div>

    </div>

</div>

@endsection