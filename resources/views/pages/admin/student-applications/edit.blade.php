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
                            Edit Student Application
                        </span>
                    </h4>
                </div>

                <div>
                    <a href="{{ route('student-applications.show', $application->id) }}"
                       class="btn btn-light">
                        ← Back to Application
                    </a>
                </div>

            </div>
        </div>


        <div class="container-fluid mt-3">

            {{-- ERRORS --}}
            @if($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form method="POST"
                  action="{{ route('student-applications.update', $application->id) }}"
      enctype="multipart/form-data">

                @csrf
                @method('PUT')


                {{-- APPLICATION INFORMATION --}}
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title">
                            Application Information
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-4 mb-3">

                                <label>Application Number</label>

                                <input type="text"
                                       class="form-control"
                                       value="{{ $application->application_number }}"
                                       readonly>

                            </div>

                            <div class="col-md-4 mb-3">

                                <label>Full Name</label>

                                <input type="text"
                                       name="full_name"
                                       class="form-control"
                                       value="{{ old('full_name', $application->full_name) }}">

                            </div>

                            <div class="col-md-4 mb-3">

                                <label>Nationality</label>

                                <input type="text"
                                       name="nationality"
                                       class="form-control"
                                       value="{{ old('nationality', $application->nationality) }}">

                            </div>

                        </div>

                    </div>

                </div>


                {{-- STUDENT INFORMATION --}}
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title">
                            Student Information
                        </h5>
                    </div>

                    {{-- STUDENT PHOTO --}}
<div class="card">

    <div class="card-header">
        <h5 class="card-title">
            Student Photo
        </h5>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-4">

                @if($application->photo)

                    <img
                        src="{{ asset('storage/' . $application->photo) }}"
                        alt="Student Photo"
                        class="img-fluid rounded mb-3"
                        style="max-width: 200px;">

                @else

                    <div
                        class="border rounded d-flex align-items-center justify-content-center mb-3"
                        style="width: 180px; height: 180px;">

                        <span class="text-muted">
                            No photo
                        </span>

                    </div>

                @endif

            </div>

            <div class="col-md-8">

                <label>
                    Replace Student Photo
                </label>

                <input type="file"
                       name="photo"
                       class="form-control"
                       accept="image/*">

                <small class="text-muted">
                    Leave empty to keep the current photo.
                </small>

            </div>

        </div>

    </div>

</div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-4 mb-3">

                                <label>First Name</label>

                                <input type="text"
                                       name="first_name"
                                       class="form-control"
                                       value="{{ old('first_name', $application->first_name) }}">

                            </div>


                            <div class="col-md-4 mb-3">

                                <label>Last Name</label>

                                <input type="text"
                                       name="last_name"
                                       class="form-control"
                                       value="{{ old('last_name', $application->last_name) }}">

                            </div>


                            <div class="col-md-4 mb-3">

                                <label>Date of Birth</label>

                                <input type="date"
                                       name="date_of_birth"
                                       class="form-control"
                                       value="{{ old('date_of_birth', $application->date_of_birth ? $application->date_of_birth->format('Y-m-d') : '') }}">

                            </div>


                            <div class="col-md-4 mb-3">

                                <label>Gender</label>

                                <select name="gender"
                                        class="form-control">

                                    <option value="">Select Gender</option>

                                    <option value="Male"
                                        {{ old('gender', $application->gender) == 'Male' ? 'selected' : '' }}>
                                        Male
                                    </option>

                                    <option value="Female"
                                        {{ old('gender', $application->gender) == 'Female' ? 'selected' : '' }}>
                                        Female
                                    </option>

                                </select>

                            </div>


                            <div class="col-md-4 mb-3">

                                <label>Place of Birth</label>

                                <input type="text"
                                       name="place_of_birth"
                                       class="form-control"
                                       value="{{ old('place_of_birth', $application->place_of_birth) }}">

                            </div>


                            <div class="col-md-4 mb-3">

                                <label>Nationality</label>

                                <input type="text"
                                       name="nationality"
                                       class="form-control"
                                       value="{{ old('nationality', $application->nationality) }}">

                            </div>

                        </div>

                    </div>

                </div>


                {{-- EDUCATION --}}
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title">
                            Education
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-4 mb-3">

                                <label>Program</label>

                                <input type="text"
                                       name="program"
                                       class="form-control"
                                       value="{{ old('program', $application->program) }}">

                            </div>


                            <div class="col-md-4 mb-3">

                                <label>Requested Level</label>

                                <input type="text"
                                       name="requested_level"
                                       class="form-control"
                                       value="{{ old('requested_level', $application->requested_level) }}">

                            </div>


                            <div class="col-md-4 mb-3">

                                <label>Academic Year</label>

                                <input type="text"
                                       name="academic_year"
                                       class="form-control"
                                       value="{{ old('academic_year', $application->academic_year) }}">

                            </div>


                            <div class="col-md-6 mb-3">

                                <label>Current School</label>

                                <input type="text"
                                       name="current_school"
                                       class="form-control"
                                       value="{{ old('current_school', $application->current_school) }}">

                            </div>


                            <div class="col-md-6 mb-3">

                                <label>Current Level</label>

                                <input type="text"
                                       name="current_level"
                                       class="form-control"
                                       value="{{ old('current_level', $application->current_level) }}">

                            </div>


                            <div class="col-md-6 mb-3">

                                <label>Previous School</label>

                                <input type="text"
                                       name="previous_school"
                                       class="form-control"
                                       value="{{ old('previous_school', $application->previous_school) }}">

                            </div>


                            <div class="col-md-6 mb-3">

                                <label>Desired Start Date</label>

                                <input type="date"
                                       name="desired_start_date"
                                       class="form-control"
                                       value="{{ old('desired_start_date', $application->desired_start_date ? $application->desired_start_date->format('Y-m-d') : '') }}">

                            </div>


                            <div class="col-md-12 mb-3">

                                <label>Academic Notes</label>

                                <textarea name="academic_notes"
                                          class="form-control"
                                          rows="4">{{ old('academic_notes', $application->academic_notes) }}</textarea>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- PARENT / GUARDIAN --}}
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title">
                            Parent / Guardian
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label>Name</label>

                                <input type="text"
                                       name="parent_name"
                                       class="form-control"
                                       value="{{ old('parent_name', $application->parent_name) }}">

                            </div>


                            <div class="col-md-6 mb-3">

                                <label>Relationship</label>

                                <input type="text"
                                       name="parent_relationship"
                                       class="form-control"
                                       value="{{ old('parent_relationship', $application->parent_relationship) }}">

                            </div>


                            <div class="col-md-4 mb-3">

                                <label>Phone</label>

                                <input type="text"
                                       name="parent_phone"
                                       class="form-control"
                                       value="{{ old('parent_phone', $application->parent_phone) }}">

                            </div>


                            <div class="col-md-4 mb-3">

                                <label>WhatsApp</label>

                                <input type="text"
                                       name="parent_whatsapp"
                                       class="form-control"
                                       value="{{ old('parent_whatsapp', $application->parent_whatsapp) }}">

                            </div>


                            <div class="col-md-4 mb-3">

                                <label>Email</label>

                                <input type="email"
                                       name="parent_email"
                                       class="form-control"
                                       value="{{ old('parent_email', $application->parent_email) }}">

                            </div>


                            <div class="col-md-6 mb-3">

                                <label>Occupation</label>

                                <input type="text"
                                       name="parent_occupation"
                                       class="form-control"
                                       value="{{ old('parent_occupation', $application->parent_occupation) }}">

                            </div>


                            <div class="col-md-6 mb-3">

                                <label>Address</label>

                                <input type="text"
                                       name="parent_address"
                                       class="form-control"
                                       value="{{ old('parent_address', $application->parent_address) }}">

                            </div>

                        </div>

                    </div>

                </div>


                {{-- EMERGENCY CONTACT --}}
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title">
                            Emergency Contact
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-4 mb-3">

                                <label>Name</label>

                                <input type="text"
                                       name="emergency_name"
                                       class="form-control"
                                       value="{{ old('emergency_name', $application->emergency_name) }}">

                            </div>


                            <div class="col-md-4 mb-3">

                                <label>Relationship</label>

                                <input type="text"
                                       name="emergency_relationship"
                                       class="form-control"
                                       value="{{ old('emergency_relationship', $application->emergency_relationship) }}">

                            </div>


                            <div class="col-md-4 mb-3">

                                <label>Phone</label>

                                <input type="text"
                                       name="emergency_phone"
                                       class="form-control"
                                       value="{{ old('emergency_phone', $application->emergency_phone) }}">

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ADDRESS --}}
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title">
                            Address
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label>Address</label>

                                <input type="text"
                                       name="address"
                                       class="form-control"
                                       value="{{ old('address', $application->address) }}">

                            </div>


                            <div class="col-md-3 mb-3">

                                <label>City</label>

                                <input type="text"
                                       name="city"
                                       class="form-control"
                                       value="{{ old('city', $application->city) }}">

                            </div>


                            <div class="col-md-3 mb-3">

                                <label>Country</label>

                                <input type="text"
                                       name="country"
                                       class="form-control"
                                       value="{{ old('country', $application->country) }}">

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ADDITIONAL INFORMATION --}}
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title">
                            Additional Information
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label>Medical Notes</label>

                                <textarea name="medical_notes"
                                          class="form-control"
                                          rows="4">{{ old('medical_notes', $application->medical_notes) }}</textarea>

                            </div>


                            <div class="col-md-6 mb-3">

                                <label>How did you hear about us?</label>

                                <input type="text"
                                       name="how_did_you_hear"
                                       class="form-control"
                                       value="{{ old('how_did_you_hear', $application->how_did_you_hear) }}">

                            </div>


                            <div class="col-md-12 mb-3">

                                <label>Additional Comments</label>

                                <textarea name="additional_comments"
                                          class="form-control"
                                          rows="4">{{ old('additional_comments', $application->additional_comments) }}</textarea>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- BUTTONS --}}
                <div class="card">

                    <div class="card-body">

                        <button type="submit"
                                class="btn btn-primary">

                            Save Changes

                        </button>

                        <a href="{{ route('student-applications.show', $application->id) }}"
                           class="btn btn-light">

                            Cancel

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection