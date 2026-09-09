@extends('layouts.master')

@section('content')

<div class="content-wrapper">

    <div class="content">

        {{-- PAGE HEADER --}}
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">

                <div class="page-title">
                    <h4>
                        <span class="font-weight-semibold">
                            Student Application
                        </span>
                    </h4>
                </div>

                <div>
                    <a href="{{ route('student-applications.index') }}"
                       class="btn btn-light">
                        ← Back to Applications
                    </a>
                </div>

            </div>
        </div>

        <div class="container-fluid mt-3">

            {{-- SUCCESS --}}
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


            {{-- APPLICATION HEADER --}}
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <div>
                        <h5 class="mb-1">
                            {{ $application->full_name }}
                        </h5>

                        <span class="text-muted">
                            {{ $application->application_number }}
                        </span>
                    </div>


                    {{-- STATUS --}}
                    <div>

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

                    </div>

                </div>


                <div class="card-body">

                    <div class="row">

                        {{-- PHOTO --}}
                        <div class="col-md-3 text-center mb-4">

                            @if($application->photo)

                                <img
                                    src="{{ asset('storage/' . $application->photo) }}"
                                    alt="Student Photo"
                                    class="img-fluid rounded"
                                    style="max-width: 200px;">

                            @else

                                <div
                                    class="border rounded d-flex align-items-center justify-content-center mx-auto"
                                    style="width: 180px; height: 180px;">

                                    <span class="text-muted">
                                        No photo
                                    </span>

                                </div>

                            @endif

                        </div>


                        {{-- STUDENT INFORMATION --}}
                        <div class="col-md-9">

                            <h5 class="mb-3">
                                Student Information
                            </h5>

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <strong>Full Name</strong>

                                    <div>
                                        {{ $application->full_name ?: '-' }}
                                    </div>

                                </div>


                                <div class="col-md-3 mb-3">

                                    <strong>First Name</strong>

                                    <div>
                                        {{ $application->first_name ?: '-' }}
                                    </div>

                                </div>


                                <div class="col-md-3 mb-3">

                                    <strong>Last Name</strong>

                                    <div>
                                        {{ $application->last_name ?: '-' }}
                                    </div>

                                </div>


                                <div class="col-md-4 mb-3">

                                    <strong>Date of Birth</strong>

                                    <div>

                                        {{ $application->date_of_birth
                                            ? $application->date_of_birth->format('d/m/Y')
                                            : '-' }}

                                    </div>

                                </div>


                                <div class="col-md-4 mb-3">

                                    <strong>Gender</strong>

                                    <div>
                                        {{ $application->gender ?: '-' }}
                                    </div>

                                </div>


                                <div class="col-md-4 mb-3">

                                    <strong>Nationality</strong>

                                    <div>
                                        {{ $application->nationality ?: '-' }}
                                    </div>

                                </div>


                                <div class="col-md-6 mb-3">

                                    <strong>Place of Birth</strong>

                                    <div>
                                        {{ $application->place_of_birth ?: '-' }}
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <hr>


                    {{-- EDUCATION --}}
                    <h5 class="mb-3">
                        Education
                    </h5>

                    <div class="row">

                        <div class="col-md-4 mb-3">

                            <strong>Program</strong>

                            <div>
                                {{ $application->program ?: '-' }}
                            </div>

                        </div>


                        <div class="col-md-4 mb-3">

                            <strong>Requested Level</strong>

                            <div>
                                {{ $application->requested_level ?: '-' }}
                            </div>

                        </div>


                        <div class="col-md-4 mb-3">

                            <strong>Academic Year</strong>

                            <div>
                                {{ $application->academic_year ?: '-' }}
                            </div>

                        </div>


                        <div class="col-md-6 mb-3">

                            <strong>Current School</strong>

                            <div>
                                {{ $application->current_school ?: '-' }}
                            </div>

                        </div>


                        <div class="col-md-6 mb-3">

                            <strong>Current Level</strong>

                            <div>
                                {{ $application->current_level ?: '-' }}
                            </div>

                        </div>


                        <div class="col-md-6 mb-3">

                            <strong>Previous School</strong>

                            <div>
                                {{ $application->previous_school ?: '-' }}
                            </div>

                        </div>


                        <div class="col-md-6 mb-3">

                            <strong>Desired Start Date</strong>

                            <div>

                                {{ $application->desired_start_date
                                    ? $application->desired_start_date->format('d/m/Y')
                                    : '-' }}

                            </div>

                        </div>


                        <div class="col-md-12 mb-3">

                            <strong>Academic Notes</strong>

                            <div>
                                {{ $application->academic_notes ?: '-' }}
                            </div>

                        </div>

                    </div>

                    <hr>


                    {{-- PARENT --}}
                    <h5 class="mb-3">
                        Parent / Guardian
                    </h5>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <strong>Name</strong>

                            <div>
                                {{ $application->parent_name ?: '-' }}
                            </div>

                        </div>


                        <div class="col-md-6 mb-3">

                            <strong>Relationship</strong>

                            <div>
                                {{ $application->parent_relationship ?: '-' }}
                            </div>

                        </div>


                        <div class="col-md-4 mb-3">

                            <strong>Phone</strong>

                            <div>
                                {{ $application->parent_phone ?: '-' }}
                            </div>

                        </div>


                        <div class="col-md-4 mb-3">

                            <strong>WhatsApp</strong>

                            <div>
                                {{ $application->parent_whatsapp ?: '-' }}
                            </div>

                        </div>


                        <div class="col-md-4 mb-3">

                            <strong>Email</strong>

                            <div>
                                {{ $application->parent_email ?: '-' }}
                            </div>

                        </div>


                        <div class="col-md-6 mb-3">

                            <strong>Occupation</strong>

                            <div>
                                {{ $application->parent_occupation ?: '-' }}
                            </div>

                        </div>


                        <div class="col-md-6 mb-3">

                            <strong>Address</strong>

                            <div>
                                {{ $application->parent_address ?: '-' }}
                            </div>

                        </div>

                    </div>

                    <hr>


                    {{-- EMERGENCY --}}
                    <h5 class="mb-3">
                        Emergency Contact
                    </h5>

                    <div class="row">

                        <div class="col-md-4 mb-3">

                            <strong>Name</strong>

                            <div>
                                {{ $application->emergency_name ?: '-' }}
                            </div>

                        </div>


                        <div class="col-md-4 mb-3">

                            <strong>Relationship</strong>

                            <div>
                                {{ $application->emergency_relationship ?: '-' }}
                            </div>

                        </div>


                        <div class="col-md-4 mb-3">

                            <strong>Phone</strong>

                            <div>
                                {{ $application->emergency_phone ?: '-' }}
                            </div>

                        </div>

                    </div>

                    <hr>


                    {{-- ADDRESS --}}
                    <h5 class="mb-3">
                        Address
                    </h5>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <strong>Address</strong>

                            <div>
                                {{ $application->address ?: '-' }}
                            </div>

                        </div>


                        <div class="col-md-3 mb-3">

                            <strong>City</strong>

                            <div>
                                {{ $application->city ?: '-' }}
                            </div>

                        </div>


                        <div class="col-md-3 mb-3">

                            <strong>Country</strong>

                            <div>
                                {{ $application->country ?: '-' }}
                            </div>

                        </div>

                    </div>

                    <hr>


                    {{-- ADDITIONAL --}}
                    <h5 class="mb-3">
                        Additional Information
                    </h5>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <strong>Medical Notes</strong>

                            <div>
                                {{ $application->medical_notes ?: '-' }}
                            </div>

                        </div>


                        <div class="col-md-6 mb-3">

                            <strong>How did you hear about us?</strong>

                            <div>
                                {{ $application->how_did_you_hear ?: '-' }}
                            </div>

                        </div>


                        <div class="col-md-12 mb-3">

                            <strong>Additional Comments</strong>

                            <div>
                                {{ $application->additional_comments ?: '-' }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ADMIN ACTIONS --}}
            <div class="card">

                <div class="card-header">

                    <h5 class="card-title">
                        Application Review
                    </h5>

                </div>

                <div class="card-body">

                    <form
                        method="POST"
                        action="{{ route('student-applications.status', $application->id) }}">

                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-md-4">

                                <label>
                                    Application Status
                                </label>

                                <select
                                    name="status"
                                    class="form-control">

                                    <option value="pending"
                                        {{ $application->status == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>

                                    <option value="reviewing"
                                        {{ $application->status == 'reviewing' ? 'selected' : '' }}>
                                        Reviewing
                                    </option>

                                    <option value="accepted"
                                        {{ $application->status == 'accepted' ? 'selected' : '' }}>
                                        Accepted
                                    </option>

                                    <option value="rejected"
                                        {{ $application->status == 'rejected' ? 'selected' : '' }}>
                                        Rejected
                                    </option>

                                </select>

                            </div>


                            <div class="col-md-8">

                                <label>
                                    Admin Notes
                                </label>

                                <textarea
                                    name="admin_notes"
                                    class="form-control"
                                    rows="3"
                                    placeholder="Add notes about this application...">{{ $application->admin_notes }}</textarea>

                            </div>

                        </div>

                        <div class="mt-3">

                            <button
                                type="submit"
                                class="btn btn-primary">

                                Update Application

                            </button>

                        </div>

                    </form>

                </div>

            </div>


            {{-- DELETE --}}
            <div class="card">

                <div class="card-body">

                    <form
                        method="POST"
                        action="{{ route('student-applications.destroy', $application->id) }}"
                        onsubmit="return confirm('Are you sure you want to delete this application?');">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger">

                            Delete Application

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection