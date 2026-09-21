@extends('layouts.master')

@section('page_title', 'Manage Users')

@section('content')

<div class="card">

```
<div class="card-header header-elements-inline">

    <h6 class="card-title">
        Manage Users
    </h6>

    {!! Qs::getPanelOptions() !!}

</div>


<div class="card-body">

    {{-- ========================================================= --}}
    {{-- TABS --}}
    {{-- ========================================================= --}}

    <ul class="nav nav-tabs nav-tabs-highlight">

        {{-- CREATE USER --}}
        <li class="nav-item">

            <a href="#new-user"
               class="nav-link active"
               data-toggle="tab">

                Create New User

            </a>

        </li>


        {{-- MANAGE USERS --}}
        <li class="nav-item dropdown">

            <a href="#"
               class="nav-link dropdown-toggle"
               data-toggle="dropdown">

                Manage Users

            </a>

            <div class="dropdown-menu dropdown-menu-right">

                @foreach ($user_types as $ut)

                    <a href="#ut-{{ Qs::hash($ut->id) }}"
                       class="dropdown-item"
                       data-toggle="tab">

                        {{ $ut->name }}s

                    </a>

                @endforeach


                {{-- STUDENT APPLICATIONS --}}
                <a href="#ut-student-applications"
                   class="dropdown-item"
                   data-toggle="tab">

                    Students

                    @if (isset($pending_applications) && $pending_applications > 0)

                        <span class="badge badge-warning ml-1">
                            {{ $pending_applications }}
                        </span>

                    @endif

                </a>

            </div>

        </li>

    </ul>


    <div class="tab-content">


        {{-- ========================================================= --}}
        {{-- CREATE NEW USER --}}
        {{-- ========================================================= --}}

        <div class="tab-pane fade show active"
             id="new-user">

            <form method="post"
                  enctype="multipart/form-data"
                  class="wizard-form steps-validation ajax-store"
                  action="{{ route('users.store') }}"
                  data-fouc>

                @csrf


                <h6>
                    Personal Data
                </h6>


                <fieldset>

                    {{-- ROW 1 --}}
                    <div class="row">

                        {{-- USER TYPE --}}
                        <div class="col-md-2">

                            <div class="form-group">

                                <label for="user_type">

                                    Select User:

                                    <span class="text-danger">*</span>

                                </label>


                                <select required
                                        data-placeholder="Select User"
                                        class="form-control select"
                                        name="user_type"
                                        id="user_type">

                                    @foreach ($user_types as $ut)

                                        <option value="{{ Qs::hash($ut->id) }}">

                                            {{ $ut->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>


                        {{-- FULL NAME --}}
                        <div class="col-md-4">

                            <div class="form-group">

                                <label>

                                    Full Name:

                                    <span class="text-danger">*</span>

                                </label>


                                <input value="{{ old('name') }}"
                                       required
                                       type="text"
                                       name="name"
                                       placeholder="Full Name"
                                       class="form-control">

                            </div>

                        </div>


                        {{-- ADDRESS --}}
                        <div class="col-md-6">

                            <div class="form-group">

                                <label>

                                    Address:

                                    <span class="text-danger">*</span>

                                </label>


                                <input value="{{ old('address') }}"
                                       class="form-control"
                                       placeholder="Address"
                                       name="address"
                                       type="text"
                                       required>

                            </div>

                        </div>

                    </div>


                    {{-- ROW 2 --}}
                    <div class="row">

                        {{-- EMAIL --}}
                        <div class="col-md-3">

                            <div class="form-group">

                                <label>
                                    Email address:
                                </label>


                                <input value="{{ old('email') }}"
                                       type="email"
                                       name="email"
                                       class="form-control"
                                       placeholder="your@email.com">

                            </div>

                        </div>


                        {{-- USERNAME --}}
                        <div class="col-md-3">

                            <div class="form-group">

                                <label>
                                    Username:
                                </label>


                                <input value="{{ old('username') }}"
                                       type="text"
                                       name="username"
                                       class="form-control"
                                       placeholder="Username">

                            </div>

                        </div>


                        {{-- PHONE --}}
                        <div class="col-md-3">

                            <div class="form-group">

                                <label>
                                    Phone:
                                </label>


                                <input value="{{ old('phone') }}"
                                       type="text"
                                       name="phone"
                                       class="form-control"
                                       placeholder="+2341234567">

                            </div>

                        </div>


                        {{-- TELEPHONE --}}
                        <div class="col-md-3">

                            <div class="form-group">

                                <label>
                                    Telephone:
                                </label>


                                <input value="{{ old('phone2') }}"
                                       type="text"
                                       name="phone2"
                                       class="form-control"
                                       placeholder="+2341234567">

                            </div>

                        </div>

                    </div>


                    {{-- ROW 3 --}}
                    <div class="row">

                        {{-- EMPLOYMENT DATE --}}
                        <div class="col-md-3">

                            <div class="form-group">

                                <label>
                                    Date of Employment:
                                </label>


                                <input autocomplete="off"
                                       name="emp_date"
                                       value="{{ old('emp_date') }}"
                                       type="text"
                                       class="form-control date-pick"
                                       placeholder="Select Date...">

                            </div>

                        </div>


                        {{-- PASSWORD --}}
                        <div class="col-md-3">

                            <div class="form-group">

                                <label for="password">
                                    Password:
                                </label>


                                <input id="password"
                                       type="password"
                                       name="password"
                                       class="form-control">

                            </div>

                        </div>


                        {{-- GENDER --}}
                        <div class="col-md-3">

                            <div class="form-group">

                                <label for="gender">

                                    Gender:

                                    <span class="text-danger">*</span>

                                </label>


                                <select class="select form-control"
                                        id="gender"
                                        name="gender"
                                        required
                                        data-fouc
                                        data-placeholder="Choose..">

                                    <option value=""></option>

                                    <option {{ old('gender') == 'Male' ? 'selected' : '' }}
                                            value="Male">

                                        Male

                                    </option>


                                    <option {{ old('gender') == 'Female' ? 'selected' : '' }}
                                            value="Female">

                                        Female

                                    </option>

                                </select>

                            </div>

                        </div>


                        {{-- NATIONALITY --}}
                        <div class="col-md-3">

                            <div class="form-group">

                                <label for="nal_id">

                                    Nationality:

                                    <span class="text-danger">*</span>

                                </label>


                                <select data-placeholder="Choose..."
                                        required
                                        name="nal_id"
                                        id="nal_id"
                                        class="select-search form-control">

                                    <option value=""></option>

                                    @foreach ($nationals as $nal)

                                        <option {{ old('nal_id') == $nal->id ? 'selected' : '' }}
                                                value="{{ $nal->id }}">

                                            {{ $nal->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>


                    {{-- ROW 4 --}}
                    <div class="row">

                        {{-- BLOOD GROUP --}}
                        <div class="col-md-4">

                            <div class="form-group">

                                <label for="bg_id">
                                    Blood Group:
                                </label>


                                <select class="select form-control"
                                        id="bg_id"
                                        name="bg_id"
                                        data-fouc
                                        data-placeholder="Choose..">

                                    <option value=""></option>

                                    @foreach ($blood_groups as $bg)

                                        <option {{ old('bg_id') == $bg->id ? 'selected' : '' }}
                                                value="{{ $bg->id }}">

                                            {{ $bg->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>


                    {{-- PHOTO --}}
                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label class="d-block">
                                    Upload Passport Photo:
                                </label>


                                <input accept="image/*"
                                       type="file"
                                       name="photo"
                                       class="form-input-styled"
                                       data-fouc>


                                <span class="form-text text-muted">

                                    Accepted Images: jpeg, png.
                                    Max file size 2Mb

                                </span>

                            </div>

                        </div>

                    </div>

                </fieldset>

            </form>

        </div>


        {{-- ========================================================= --}}
        {{-- NORMAL USER LISTS --}}
        {{-- ========================================================= --}}

        @foreach ($user_types as $ut)

            <div class="tab-pane fade"
                 id="ut-{{ Qs::hash($ut->id) }}">

                <table class="table datatable-button-html5-columns">

                    <thead>

                        <tr>

                            <th>S/N</th>

                            <th>Photo</th>

                            <th>Name</th>

                            <th>Username</th>

                            <th>Phone</th>

                            <th>Email</th>

                            @if (in_array($ut->title, ['teacher', 'student', 'parent']))

                                <th>
                                    Status
                                </th>

                            @endif

                            <th>
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach ($users->where('user_type', $ut->title) as $u)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>

                                    <img class="rounded-circle"
                                         style="height:40px;width:40px;"
                                         src="{{ $u->photo }}"
                                         alt="photo">

                                </td>


                                <td>
                                    {{ $u->name }}
                                </td>


                                <td>
                                    {{ $u->username }}
                                </td>


                                <td>
                                    {{ $u->phone }}
                                </td>


                                <td>
                                    {{ $u->email }}
                                </td>


                                {{-- STATUS --}}
                                @if (in_array($ut->title, ['teacher', 'student', 'parent']))

                                    <td>

                                        @if ($u->is_approved)

                                            <span class="badge badge-success">
                                                Approved
                                            </span>

                                        @else

                                            <span class="badge badge-warning">
                                                Pending Approval
                                            </span>

                                        @endif

                                    </td>

                                @endif


                                {{-- ACTION --}}
                                <td class="text-center">

                                    <div class="list-icons">

                                        <div class="dropdown">

                                            <a href="#"
                                               class="list-icons-item"
                                               data-toggle="dropdown">

                                                <i class="icon-menu9"></i>

                                            </a>


                                            <div class="dropdown-menu dropdown-menu-left">


                                                {{-- ================================================= --}}
                                                {{-- VIEW PROFILE --}}
                                                {{-- ================================================= --}}

                                                @if ($ut->title === 'parent')

                                                    <button type="button"
                                                            class="dropdown-item"
                                                            data-toggle="modal"
                                                            data-target="#viewParentProfileModal{{ $u->id }}">

                                                        <i class="icon-eye"></i>

                                                        View Profile

                                                    </button>

                                                @else

                                                    <a href="{{ route('users.show', Qs::hash($u->id)) }}"
                                                       class="dropdown-item">

                                                        <i class="icon-eye"></i>

                                                        View Profile

                                                    </a>

                                                @endif


                                                {{-- ================================================= --}}
                                                {{-- EDIT --}}
                                                {{-- ================================================= --}}

                                                <a href="{{ route('users.edit', Qs::hash($u->id)) }}"
                                                   class="dropdown-item">

                                                    <i class="icon-pencil"></i>

                                                    Edit

                                                </a>


                                                {{-- ================================================= --}}
                                                {{-- TEACHER / STUDENT / PARENT APPROVAL --}}
                                                {{-- ================================================= --}}

                                                @if ($ut->title === 'teacher')

                                                    @if ($u->is_approved)

                                                        <span class="dropdown-item text-success">

                                                            <i class="icon-check"></i>

                                                            Approved

                                                        </span>

                                                    @else

                                                        <form method="POST"
                                                              action="{{ route('users.approveTeacher', $u->id) }}">

                                                            @csrf

                                                            @method('PATCH')

                                                            <button type="submit"
                                                                    class="dropdown-item text-success">

                                                                <i class="icon-check"></i>

                                                                Approve Teacher

                                                            </button>

                                                        </form>

                                                    @endif


                                                @elseif($ut->title === 'student')

                                                    @if ($u->is_approved)

                                                        <span class="dropdown-item text-success">

                                                            <i class="icon-check"></i>

                                                            Approved

                                                        </span>

                                                    @else

                                                        <button type="button"
                                                                class="dropdown-item text-success approve-student-btn"
                                                                data-user-id="{{ $u->id }}"
                                                                data-user-name="{{ $u->name }}">

                                                            <i class="icon-check"></i>

                                                            Approve Student

                                                        </button>

                                                    @endif


                                                @elseif($ut->title === 'parent')

                                                    @if ($u->is_approved)

                                                        <span class="dropdown-item text-success">

                                                            <i class="icon-check"></i>

                                                            Approved

                                                        </span>

                                                    @else

                                                        <button type="button"
                                                                class="dropdown-item text-success approve-parent-btn"
                                                                data-user-id="{{ $u->id }}"
                                                                data-user-name="{{ $u->name }}">

                                                            <i class="icon-check"></i>

                                                            Approve Parent

                                                        </button>

                                                    @endif

                                                @endif


                                                {{-- ================================================= --}}
                                                {{-- SUPER ADMIN ACTIONS --}}
                                                {{-- ================================================= --}}

                                                @if (Qs::userIsSuperAdmin())

                                                    {{-- RESET PASSWORD --}}

                                                    <a href="#"
                                                       class="dropdown-item"
                                                       data-toggle="modal"
                                                       data-target="#resetUserPasswordModal"
                                                       data-user-id="{{ Qs::hash($u->id) }}"
                                                       data-user-name="{{ $u->name }}">

                                                        <i class="icon-lock"></i>

                                                        Reset password

                                                    </a>


                                                    {{-- DELETE --}}

                                                    <a id="{{ Qs::hash($u->id) }}"
                                                       onclick="confirmDelete(this.id)"
                                                       href="#"
                                                       class="dropdown-item">

                                                        <i class="icon-trash"></i>

                                                        Delete

                                                    </a>


                                                    <form method="post"
                                                          id="item-delete-{{ Qs::hash($u->id) }}"
                                                          action="{{ route('users.destroy', Qs::hash($u->id)) }}"
                                                          class="hidden">

                                                        @csrf

                                                        @method('delete')

                                                    </form>

                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @endforeach


        {{-- ========================================================= --}}
        {{-- STUDENT APPLICATIONS --}}
        {{-- ========================================================= --}}

        <div class="tab-pane fade"
             id="ut-student-applications">

            <table class="table datatable-button-html5-columns">

                <thead>

                    <tr>

                        <th>S/N</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Application No.</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($student_applications as $app)

                        <tr data-application-id="{{ $app->id }}">

                            <td>
                                {{ $loop->iteration }}
                            </td>


                            <td>

                                <img class="rounded-circle"
                                     style="height:40px;width:40px;"
                                     src="{{ $app->photo
                                         ? asset('storage/' . $app->photo)
                                         : Qs::getDefaultUserImage() }}"
                                     alt="photo">

                            </td>


                            <td>
                                {{ $app->full_name }}
                            </td>


                            <td>
                                {{ $app->application_number }}
                            </td>


                            <td>
                                {{ $app->parent_phone }}
                            </td>


                            <td>
                                {{ $app->parent_email }}
                            </td>


                            <td class="application-status">

                                @if ($app->status === 'accepted')

                                    <span class="badge badge-success">
                                        Approved
                                    </span>

                                @elseif($app->status === 'rejected')

                                    <span class="badge badge-danger">
                                        Rejected
                                    </span>

                                @elseif($app->status === 'reviewing')

                                    <span class="badge badge-info">
                                        Reviewing
                                    </span>

                                @else

                                    <span class="badge badge-warning">
                                        Pending Approval
                                    </span>

                                @endif

                            </td>


                            <td class="text-center">

                                <div class="list-icons">

                                    <div class="dropdown">

                                        <a href="#"
                                           class="list-icons-item"
                                           data-toggle="dropdown">

                                            <i class="icon-menu9"></i>

                                        </a>


                                        <div class="dropdown-menu dropdown-menu-left">


                                            {{-- VIEW APPLICATION --}}

                                            <button type="button"
                                                    class="dropdown-item view-student-application-btn"
                                                    data-toggle="modal"
                                                    data-target="#viewStudentApplicationModal"

                                                    data-photo="{{ $app->photo
                                                        ? asset('storage/' . $app->photo)
                                                        : Qs::getDefaultUserImage() }}"

                                                    data-application-number="{{ $app->application_number }}"

                                                    data-full-name="{{ $app->full_name }}"

                                                    data-first-name="{{ $app->first_name }}"

                                                    data-last-name="{{ $app->last_name }}"

                                                    data-date-of-birth="{{ $app->date_of_birth }}"

                                                    data-gender="{{ $app->gender }}"

                                                    data-nationality="{{ $app->nationality }}"

                                                    data-place-of-birth="{{ $app->place_of_birth }}"

                                                    data-current-school="{{ $app->current_school }}"

                                                    data-current-level="{{ $app->current_level }}"

                                                    data-previous-school="{{ $app->previous_school }}"

                                                    data-address="{{ $app->address }}"

                                                    data-city="{{ $app->city }}"

                                                    data-country="{{ $app->country }}"

                                                    data-program="{{ $app->program }}"

                                                    data-requested-level="{{ $app->requested_level }}"

                                                    data-academic-year="{{ $app->academic_year }}"

                                                    data-desired-start-date="{{ $app->desired_start_date }}"

                                                    data-academic-notes="{{ $app->academic_notes }}"

                                                    data-parent-name="{{ $app->parent_name }}"

                                                    data-parent-relationship="{{ $app->parent_relationship }}"

                                                    data-parent-phone="{{ $app->parent_phone }}"

                                                    data-parent-whatsapp="{{ $app->parent_whatsapp }}"

                                                    data-parent-email="{{ $app->parent_email }}"

                                                    data-parent-occupation="{{ $app->parent_occupation }}"

                                                    data-parent-address="{{ $app->parent_address }}"

                                                    data-emergency-name="{{ $app->emergency_name }}"

                                                    data-emergency-relationship="{{ $app->emergency_relationship }}"

                                                    data-emergency-phone="{{ $app->emergency_phone }}"

                                                    data-medical-notes="{{ $app->medical_notes }}"

                                                    data-additional-comments="{{ $app->additional_comments }}"

                                                    data-how-did-you-hear="{{ $app->how_did_you_hear }}"

                                                    data-status="{{ $app->status }}"

                                                    data-admin-notes="{{ $app->admin_notes }}">

                                                <i class="icon-eye"></i>

                                                View Application

                                            </button>


                                            {{-- STUDENT APPROVAL --}}

                                            @if ($app->user_id)

                                                @if ($app->user && $app->user->is_approved)

                                                    <span class="dropdown-item text-success">

                                                        <i class="icon-check"></i>

                                                        Approved

                                                    </span>

                                                @else

                                                    <button type="button"
                                                            class="dropdown-item text-success approve-student-btn"
                                                            data-user-id="{{ $app->user_id }}"
                                                            data-user-name="{{ $app->full_name }}">

                                                        <i class="icon-check"></i>

                                                        Approve Student

                                                    </button>

                                                @endif

                                            @else

                                                <span class="dropdown-item text-warning">

                                                    <i class="icon-warning"></i>

                                                    No student user linked

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8"
                                class="text-center text-muted">

                                No student applications found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
```

</div>

{{-- ========================================================= --}}
{{-- VIEW PARENT PROFILE MODALS --}}
{{-- ========================================================= --}}

@foreach ($users->where('user_type', 'parent') as $parent)

```
@php

    $children = $parent->children;

    if (is_string($children)) {
        $children = json_decode($children, true);
    }

    if (!is_array($children)) {
        $children = [];
    }

@endphp


<div class="modal fade"
     id="viewParentProfileModal{{ $parent->id }}"
     tabindex="-1"
     role="dialog"
     aria-labelledby="viewParentProfileModalLabel{{ $parent->id }}"
     aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-scrollable"
         role="document">

        <div class="modal-content">


            {{-- HEADER --}}

            <div class="modal-header">

                <h5 class="modal-title"
                    id="viewParentProfileModalLabel{{ $parent->id }}">

                    <i class="icon-user mr-2"></i>

                    Parent Profile

                </h5>


                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">

                    <span aria-hidden="true">
                        &times;
                    </span>

                </button>

            </div>


            {{-- BODY --}}

            <div class="modal-body">


                {{-- ================================================= --}}
                {{-- PARENT INFORMATION --}}
                {{-- ================================================= --}}

                <div class="card mb-4">

                    <div class="card-header bg-light">

                        <h6 class="mb-0">

                            <i class="icon-user mr-2"></i>

                            Parent Information

                        </h6>

                    </div>


                    <div class="card-body">

                        <div class="row">


                            <div class="col-md-4 mb-3">

                                <strong>
                                    Full Name
                                </strong>

                                <p class="text-muted mb-0">

                                    {{ $parent->name ?: '-' }}

                                </p>

                            </div>


                            <div class="col-md-4 mb-3">

                                <strong>
                                    Email
                                </strong>

                                <p class="text-muted mb-0">

                                    {{ $parent->email ?: '-' }}

                                </p>

                            </div>


                            <div class="col-md-4 mb-3">

                                <strong>
                                    Phone
                                </strong>

                                <p class="text-muted mb-0">

                                    {{ $parent->phone ?: '-' }}

                                </p>

                            </div>


                            <div class="col-md-4 mb-3">

                                <strong>
                                    Telephone
                                </strong>

                                <p class="text-muted mb-0">

                                    {{ $parent->phone2 ?: '-' }}

                                </p>

                            </div>


                            <div class="col-md-4 mb-3">

                                <strong>
                                    Username
                                </strong>

                                <p class="text-muted mb-0">

                                    {{ $parent->username ?: '-' }}

                                </p>

                            </div>


                            <div class="col-md-4 mb-3">

                                <strong>
                                    Registration Date
                                </strong>

                                <p class="text-muted mb-0">

                                    {{ $parent->registration_date ?: '-' }}

                                </p>

                            </div>


                            <div class="col-md-4 mb-3">

                                <strong>
                                    Number of Children
                                </strong>

                                <p class="text-muted mb-0">

                                    {{ $parent->number_of_children ?? count($children) }}

                                </p>

                            </div>


                            <div class="col-md-4 mb-3">

                                <strong>
                                    Status
                                </strong>

                                <p class="mb-0">

                                    @if ($parent->is_approved)

                                        <span class="badge badge-success">
                                            Approved
                                        </span>

                                    @else

                                        <span class="badge badge-warning">
                                            Pending Approval
                                        </span>

                                    @endif

                                </p>

                            </div>


                            <div class="col-md-12 mb-3">

                                <strong>
                                    Address
                                </strong>

                                <p class="text-muted mb-0">

                                    {{ $parent->address ?: '-' }}

                                </p>

                            </div>


                            <div class="col-md-6 mb-3">

                                <strong>
                                    How did you hear about us?
                                </strong>

                                <p class="text-muted mb-0">

                                    {{ $parent->how_did_you_hear ?: '-' }}

                                </p>

                            </div>


                            <div class="col-md-12">

                                <strong>
                                    Additional Information
                                </strong>

                                <div class="border rounded p-3 mt-1 text-muted">

                                    {!! nl2br(e($parent->additional_information ?: '-')) !!}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- CHILDREN --}}
                {{-- ================================================= --}}

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5 class="mb-0">

                        <i class="icon-users mr-2"></i>

                        Children

                    </h5>


                    <span class="badge badge-primary">

                        {{ count($children) }}

                    </span>

                </div>


                @if (count($children) > 0)

                    @foreach ($children as $index => $child)

                        <div class="card border mb-4">


                            {{-- CHILD HEADER --}}

                            <div class="card-header bg-light">

                                <h6 class="mb-0">

                                    <i class="icon-user mr-2"></i>

                                    Child {{ $index + 1 }}

                                    @if (!empty($child['student_name']))

                                        :

                                        <strong>
                                            {{ $child['student_name'] }}
                                        </strong>

                                    @endif

                                </h6>

                            </div>


                            <div class="card-body">


                                {{-- ================================================= --}}
                                {{-- PERSONAL INFORMATION --}}
                                {{-- ================================================= --}}

                                <h6 class="font-weight-semibold mb-3">

                                    Personal Information

                                </h6>


                                <div class="row">


                                    <div class="col-md-4 mb-3">

                                        <strong>
                                            Student Name
                                        </strong>

                                        <p class="text-muted mb-0">

                                            {{ $child['student_name'] ?? '-' }}

                                        </p>

                                    </div>


                                    <div class="col-md-4 mb-3">

                                        <strong>
                                            Date of Birth
                                        </strong>

                                        <p class="text-muted mb-0">

                                            {{ $child['student_date_of_birth'] ?? '-' }}

                                        </p>

                                    </div>


                                    <div class="col-md-4 mb-3">

                                        <strong>
                                            Place of Birth
                                        </strong>

                                        <p class="text-muted mb-0">

                                            {{ $child['student_place_of_birth'] ?? '-' }}

                                        </p>

                                    </div>


                                    <div class="col-md-8 mb-3">

                                        <strong>
                                            Student Address
                                        </strong>

                                        <p class="text-muted mb-0">

                                            {{ $child['student_address'] ?? '-' }}

                                        </p>

                                    </div>


                                    <div class="col-md-4 mb-3">

                                        <strong>
                                            Student Status
                                        </strong>

                                        <p class="text-muted mb-0">

                                            {{ $child['student_status'] ?? '-' }}

                                        </p>

                                    </div>

                                </div>


                                <hr>


                                {{-- ================================================= --}}
                                {{-- ACADEMIC INFORMATION --}}
                                {{-- ================================================= --}}

                                <h6 class="font-weight-semibold mb-3">

                                    Academic Information

                                </h6>


                                <div class="row">


                                    <div class="col-md-4 mb-3">

                                        <strong>
                                            Previous School
                                        </strong>

                                        <p class="text-muted mb-0">

                                            {{ $child['previous_school'] ?? '-' }}

                                        </p>

                                    </div>


                                    <div class="col-md-4 mb-3">

                                        <strong>
                                            Studied Program
                                        </strong>

                                        <p class="text-muted mb-0">

                                            {{ $child['studied_program'] ?? '-' }}

                                        </p>

                                    </div>


                                    <div class="col-md-4 mb-3">

                                        <strong>
                                            Requested Level
                                        </strong>

                                        <p class="text-muted mb-0">

                                            {{ $child['requested_level'] ?? '-' }}

                                        </p>

                                    </div>


                                    <div class="col-md-4 mb-3">

                                        <strong>
                                            Dropped Subject
                                        </strong>

                                        <p class="text-muted mb-0">

                                            {{ $child['dropped_subject'] ?? '-' }}

                                        </p>

                                    </div>


                                    <div class="col-md-4 mb-3">

                                        <strong>
                                            Terminal Specialties
                                        </strong>

                                        <p class="text-muted mb-0">

                                            @if (!empty($child['terminal_specialties']) && is_array($child['terminal_specialties']))

                                                {{ implode(', ', $child['terminal_specialties']) }}

                                            @else

                                                -

                                            @endif

                                        </p>

                                    </div>


                                    <div class="col-md-4 mb-3">

                                        <strong>
                                            Languages
                                        </strong>

                                        <p class="text-muted mb-0">

                                            @if (!empty($child['languages']) && is_array($child['languages']))

                                                {{ implode(', ', $child['languages']) }}

                                            @else

                                                -

                                            @endif

                                        </p>

                                    </div>

                                </div>


                                <hr>


                                {{-- ================================================= --}}
                                {{-- OTHER INFORMATION --}}
                                {{-- ================================================= --}}

                                <h6 class="font-weight-semibold mb-3">

                                    Other Information

                                </h6>


                                <div class="row">


                                    <div class="col-md-12 mb-3">

                                        <strong>
                                            Educational Needs
                                        </strong>

                                        <div class="border rounded p-3 mt-1 text-muted">

                                            {!! nl2br(e($child['educational_needs'] ?? '-')) !!}

                                        </div>

                                    </div>


                                    <div class="col-md-6 mb-3">

                                        <strong>
                                            Extracurricular Activities
                                        </strong>

                                        <div class="border rounded p-3 mt-1 text-muted">

                                            {!! nl2br(e($child['extracurricular_activities'] ?? '-')) !!}

                                        </div>

                                    </div>


                                    <div class="col-md-6 mb-3">

                                        <strong>
                                            Interested Clubs
                                        </strong>

                                        <div class="border rounded p-3 mt-1 text-muted">

                                            {!! nl2br(e($child['interested_clubs'] ?? '-')) !!}

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                @else

                    <div class="alert alert-warning">

                        <i class="icon-warning mr-2"></i>

                        No children information found.

                    </div>

                @endif

            </div>


            {{-- FOOTER --}}

            <div class="modal-footer">

                <button type="button"
                        class="btn btn-light"
                        data-dismiss="modal">

                    Close

                </button>

            </div>

        </div>

    </div>

</div>
```

@endforeach

{{-- ========================================================= --}}
{{-- RESET PASSWORD MODAL --}}
{{-- ========================================================= --}}

<div class="modal fade"
     id="resetUserPasswordModal"
     tabindex="-1"
     role="dialog">

```
<div class="modal-dialog"
     role="document">

    <div class="modal-content">

        <form method="POST"
              action="{{ route('users.reset_pass') }}">

            @csrf

            <div class="modal-header">

                <h5 class="modal-title">
                    Réinitialiser le mot de passe
                </h5>

                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>


            <div class="modal-body">

                <input type="hidden"
                       name="user_id"
                       id="reset_user_id">


                <div class="form-group">

                    <label>
                        Utilisateur :
                    </label>

                    <strong id="reset_user_name"></strong>

                </div>


                <div class="form-group">

                    <label>

                        Nouveau mot de passe :

                        <span class="text-danger">*</span>

                    </label>


                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Nouveau mot de passe"
                           required
                           minlength="6">

                </div>


                <div class="form-group">

                    <label>

                        Confirmer le mot de passe :

                        <span class="text-danger">*</span>

                    </label>


                    <input type="password"
                           name="password_confirmation"
                           class="form-control"
                           placeholder="Confirmer le mot de passe"
                           required
                           minlength="6">

                </div>

            </div>


            <div class="modal-footer">

                <button type="button"
                        class="btn btn-light"
                        data-dismiss="modal">

                    Annuler

                </button>


                <button type="submit"
                        class="btn btn-primary">

                    <i class="icon-lock"></i>

                    Modifier le mot de passe

                </button>

            </div>

        </form>

    </div>

</div>
```

</div>

{{-- ========================================================= --}}
{{-- APPROVE STUDENT MODAL --}}
{{-- ========================================================= --}}

<div class="modal fade"
     id="approveStudentModal"
     tabindex="-1"
     role="dialog"
     aria-labelledby="approveStudentModalLabel"
     aria-hidden="true">

```
<div class="modal-dialog"
     role="document">

    <div class="modal-content">

        <form method="POST"
              id="approveStudentForm">

            @csrf

            @method('PATCH')


            <div class="modal-header">

                <h5 class="modal-title"
                    id="approveStudentModalLabel">

                    Approve Student

                </h5>


                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>


            <div class="modal-body">

                <input type="hidden"
                       name="student_id"
                       id="approve_student_id">


                <div class="form-group">

                    <label>
                        Student
                    </label>


                    <input type="text"
                           id="approve_student_name"
                           class="form-control bg-light"
                           readonly>

                </div>


                <div class="form-group">

                    <label>

                        Class

                        <span class="text-danger">*</span>

                    </label>


                    <select name="my_class_id"
                            id="approve_my_class_id"
                            class="form-control"
                            required>

                        <option value="">
                            Select Class
                        </option>

                        @foreach ($my_classes as $class)

                            <option value="{{ $class->id }}">

                                {{ $class->name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="form-group">

                    <label>

                        Section

                        <span class="text-danger">*</span>

                    </label>


                    <select name="section_id"
                            id="approve_section_id"
                            class="form-control"
                            required
                            disabled>

                        <option value="">
                            Select a class first
                        </option>

                    </select>

                </div>

            </div>


            <div class="modal-footer">

                <button type="button"
                        class="btn btn-light"
                        data-dismiss="modal">

                    Cancel

                </button>


                <button type="submit"
                        class="btn btn-success">

                    <i class="icon-check"></i>

                    Approve Student

                </button>

            </div>

        </form>

    </div>

</div>
```

</div>

{{-- ========================================================= --}}
{{-- VIEW STUDENT APPLICATION MODAL --}}
{{-- ========================================================= --}}

<div class="modal fade"
     id="viewStudentApplicationModal"
     tabindex="-1"
     role="dialog"
     aria-labelledby="viewStudentApplicationModalLabel"
     aria-hidden="true">

```
<div class="modal-dialog modal-xl"
     role="document">

    <div class="modal-content">

        <div class="modal-header">

            <h5 class="modal-title"
                id="viewStudentApplicationModalLabel">

                Student Application

            </h5>


            <button type="button"
                    class="close"
                    data-dismiss="modal">

                <span>&times;</span>

            </button>

        </div>


        <div class="modal-body">


            {{-- BASIC INFORMATION --}}

            <div class="row">

                <div class="col-md-3 text-center">

                    <img id="view_app_photo"
                         src=""
                         class="img-thumbnail mb-3"
                         style="width:180px;height:180px;object-fit:cover;"
                         alt="Student Photo">

                </div>


                <div class="col-md-9">

                    <h5 class="mb-3">
                        Personal Information
                    </h5>


                    <div class="row">

                        <div class="col-md-4">

                            <strong>Application No.</strong>

                            <p id="view_app_number"
                               class="text-muted"></p>

                        </div>


                        <div class="col-md-4">

                            <strong>Full Name</strong>

                            <p id="view_app_full_name"
                               class="text-muted"></p>

                        </div>


                        <div class="col-md-4">

                            <strong>First Name</strong>

                            <p id="view_app_first_name"
                               class="text-muted"></p>

                        </div>


                        <div class="col-md-4">

                            <strong>Last Name</strong>

                            <p id="view_app_last_name"
                               class="text-muted"></p>

                        </div>


                        <div class="col-md-4">

                            <strong>Date of Birth</strong>

                            <p id="view_app_dob"
                               class="text-muted"></p>

                        </div>


                        <div class="col-md-4">

                            <strong>Gender</strong>

                            <p id="view_app_gender"
                               class="text-muted"></p>

                        </div>


                        <div class="col-md-4">

                            <strong>Nationality</strong>

                            <p id="view_app_nationality"
                               class="text-muted"></p>

                        </div>


                        <div class="col-md-4">

                            <strong>Place of Birth</strong>

                            <p id="view_app_birth_place"
                               class="text-muted"></p>

                        </div>

                    </div>

                </div>

            </div>


            <hr>


            {{-- ACADEMIC INFORMATION --}}

            <h5 class="mb-3">
                Academic Information
            </h5>


            <div class="row">

                <div class="col-md-4">

                    <strong>Current School</strong>

                    <p id="view_app_current_school"
                       class="text-muted"></p>

                </div>


                <div class="col-md-4">

                    <strong>Current Level</strong>

                    <p id="view_app_current_level"
                       class="text-muted"></p>

                </div>


                <div class="col-md-4">

                    <strong>Previous School</strong>

                    <p id="view_app_previous_school"
                       class="text-muted"></p>

                </div>


                <div class="col-md-4">

                    <strong>Program</strong>

                    <p id="view_app_program"
                       class="text-muted"></p>

                </div>


                <div class="col-md-4">

                    <strong>Requested Level</strong>

                    <p id="view_app_requested_level"
                       class="text-muted"></p>

                </div>


                <div class="col-md-4">

                    <strong>Academic Year</strong>

                    <p id="view_app_academic_year"
                       class="text-muted"></p>

                </div>


                <div class="col-md-4">

                    <strong>Desired Start Date</strong>

                    <p id="view_app_start_date"
                       class="text-muted"></p>

                </div>

            </div>


            <div class="form-group">

                <strong>Academic Notes</strong>

                <div id="view_app_academic_notes"
                     class="border rounded p-2 text-muted">
                </div>

            </div>


            <hr>


            {{-- ADDRESS --}}

            <h5 class="mb-3">
                Address Information
            </h5>


            <div class="row">

                <div class="col-md-6">

                    <strong>Address</strong>

                    <p id="view_app_address"
                       class="text-muted"></p>

                </div>


                <div class="col-md-3">

                    <strong>City</strong>

                    <p id="view_app_city"
                       class="text-muted"></p>

                </div>


                <div class="col-md-3">

                    <strong>Country</strong>

                    <p id="view_app_country"
                       class="text-muted"></p>

                </div>

            </div>


            <hr>


            {{-- PARENT INFORMATION --}}

            <h5 class="mb-3">
                Parent / Guardian Information
            </h5>


            <div class="row">

                <div class="col-md-4">

                    <strong>Name</strong>

                    <p id="view_app_parent_name"
                       class="text-muted"></p>

                </div>


                <div class="col-md-4">

                    <strong>Relationship</strong>

                    <p id="view_app_parent_relationship"
                       class="text-muted"></p>

                </div>


                <div class="col-md-4">

                    <strong>Phone</strong>

                    <p id="view_app_parent_phone"
                       class="text-muted"></p>

                </div>


                <div class="col-md-4">

                    <strong>WhatsApp</strong>

                    <p id="view_app_parent_whatsapp"
                       class="text-muted"></p>

                </div>


                <div class="col-md-4">

                    <strong>Email</strong>

                    <p id="view_app_parent_email"
                       class="text-muted"></p>

                </div>


                <div class="col-md-4">

                    <strong>Occupation</strong>

                    <p id="view_app_parent_occupation"
                       class="text-muted"></p>

                </div>


                <div class="col-md-12">

                    <strong>Parent Address</strong>

                    <p id="view_app_parent_address"
                       class="text-muted"></p>

                </div>

            </div>


            <hr>


            {{-- EMERGENCY CONTACT --}}

            <h5 class="mb-3">
                Emergency Contact
            </h5>


            <div class="row">

                <div class="col-md-4">

                    <strong>Name</strong>

                    <p id="view_app_emergency_name"
                       class="text-muted"></p>

                </div>


                <div class="col-md-4">

                    <strong>Relationship</strong>

                    <p id="view_app_emergency_relationship"
                       class="text-muted"></p>

                </div>


                <div class="col-md-4">

                    <strong>Phone</strong>

                    <p id="view_app_emergency_phone"
                       class="text-muted"></p>

                </div>

            </div>


            <hr>


            {{-- OTHER INFORMATION --}}

            <h5 class="mb-3">
                Additional Information
            </h5>


            <div class="row">

                <div class="col-md-12 mb-3">

                    <strong>Medical Notes</strong>

                    <div id="view_app_medical_notes"
                         class="border rounded p-2 text-muted">
                    </div>

                </div>


                <div class="col-md-12 mb-3">

                    <strong>Additional Comments</strong>

                    <div id="view_app_additional_comments"
                         class="border rounded p-2 text-muted">
                    </div>

                </div>


                <div class="col-md-6">

                    <strong>How did you hear about us?</strong>

                    <p id="view_app_how_did_you_hear"
                       class="text-muted"></p>

                </div>


                <div class="col-md-6">

                    <strong>Status</strong>

                    <p id="view_app_status"
                       class="text-muted"></p>

                </div>


                <div class="col-md-12">

                    <strong>Admin Notes</strong>

                    <div id="view_app_admin_notes"
                         class="border rounded p-2 text-muted">
                    </div>

                </div>

            </div>

        </div>


        <div class="modal-footer">

            <button type="button"
                    class="btn btn-light"
                    data-dismiss="modal">

                Close

            </button>

        </div>

    </div>

</div>
```

</div>

{{-- ========================================================= --}}
{{-- APPROVE PARENT MODAL --}}
{{-- ========================================================= --}}

<div id="approve-parent-modal"
     class="modal fade"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">

```
<div class="modal-dialog modal-lg"
     role="document">

    <div class="modal-content">

        <div class="modal-header">

            <h5 class="modal-title">
                Approve Parent
            </h5>


            <button type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close">

                <span aria-hidden="true">
                    &times;
                </span>

            </button>

        </div>


        <form method="POST"
              action="{{ route('users.approveParent') }}"
              id="approve-parent-form">

            @csrf

            @method('PATCH')


            <input type="hidden"
                   name="parent_id"
                   id="approve-parent-id">


            <div class="modal-body">

                <div class="alert alert-info">

                    <strong>Parent:</strong>

                    <span id="approve-parent-name"></span>

                </div>


                <h6 class="font-weight-semibold mb-3">

                    Select the children for this parent

                </h6>


                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead>

                            <tr>

                                <th style="width:50px;">

                                    <input type="checkbox"
                                           id="select-all-parent-children">

                                </th>


                                <th>
                                    Student Name
                                </th>


                                <th>
                                    Email
                                </th>


                                <th>
                                    Status
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($parent_children as $child)

                                <tr>

                                    <td>

                                        <input type="checkbox"
                                               name="children[]"
                                               value="{{ $child->id }}"
                                               class="parent-child-checkbox">

                                    </td>


                                    <td>
                                        {{ $child->name }}
                                    </td>


                                    <td>
                                        {{ $child->email ?? '-' }}
                                    </td>


                                    <td>

                                        @if($child->is_approved)

                                            <span class="badge badge-success">
                                                Approved
                                            </span>

                                        @else

                                            <span class="badge badge-warning">
                                                Pending
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                @if($parent_children->count() === 0)

                    <div class="alert alert-warning">

                        No students are available to assign to this parent.

                    </div>

                @endif

            </div>


            <div class="modal-footer">

                <button type="button"
                        class="btn btn-light"
                        data-dismiss="modal">

                    Cancel

                </button>


                <button type="submit"
                        class="btn btn-success">

                    <i class="icon-check"></i>

                    Approve Parent

                </button>

            </div>

        </form>

    </div>

</div>
```

</div>

{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

{{-- RESET PASSWORD --}}

<script>

    $('#resetUserPasswordModal').on(
        'show.bs.modal',
        function(event) {

            var button = $(event.relatedTarget);

            $('#reset_user_id').val(
                button.data('user-id')
            );

            $('#reset_user_name').text(
                button.data('user-name')
            );

        }
    );

</script>

{{-- ========================================================= --}}
{{-- APPROVE PARENT --}}
{{-- ========================================================= --}}

<script>

    $(document).on(
        'click',
        '.approve-parent-btn',
        function() {

            var parentId =
                $(this).data('user-id');

            var parentName =
                $(this).data('user-name');


            $('#approve-parent-id').val(
                parentId
            );


            $('#approve-parent-name').text(
                parentName
            );


            $('.parent-child-checkbox')
                .prop('checked', false);


            $('#select-all-parent-children')
                .prop('checked', false);


            $('#approve-parent-modal')
                .modal('show');

        }
    );


    $('#select-all-parent-children').on(
        'change',
        function() {

            $('.parent-child-checkbox').prop(
                'checked',
                $(this).is(':checked')
            );

        }
    );


    $(document).on(
        'change',
        '.parent-child-checkbox',
        function() {

            var total =
                $('.parent-child-checkbox').length;

            var checked =
                $('.parent-child-checkbox:checked').length;


            $('#select-all-parent-children').prop(
                'checked',
                total > 0 && total === checked
            );

        }
    );

</script>

{{-- ========================================================= --}}
{{-- APPROVE STUDENT --}}
{{-- ========================================================= --}}

<script>

    var approveStudentSections = {

        @foreach ($my_classes as $class)

            "{{ $class->id }}": [

                @foreach ($class->section->where('active', 1) as $section)

                    {
                        id: "{{ $section->id }}",
                        name: @json($section->name)
                    },

                @endforeach

            ],

        @endforeach

    };


    $(document).on(
        'click',
        '.approve-student-btn',
        function(e) {

            e.preventDefault();

            e.stopImmediatePropagation();


            var userId =
                $(this).attr('data-user-id');


            var userName =
                $(this).attr('data-user-name');


            $('#approve_student_id').val(
                userId
            );


            $('#approve_student_name').val(
                userName
            );


            var url =
                "{{ route('users.approveStudent', ':id') }}";


            url =
                url.replace(
                    ':id',
                    userId
                );


            $('#approveStudentForm')
                .attr('action', url);


            $('#approve_my_class_id')
                .val('');


            $('#approve_section_id')

                .html(
                    '<option value="">Select a class first</option>'
                )

                .prop(
                    'disabled',
                    true
                );


            $('#approveStudentModal').modal({
                backdrop: 'static',
                keyboard: false
            });

        }
    );


    $(document).on(
        'change',
        '#approve_my_class_id',
        function() {

            var classId =
                $(this).val();


            var sectionSelect =
                $('#approve_section_id');


            if (!classId) {

                sectionSelect

                    .html(
                        '<option value="">Select a class first</option>'
                    )

                    .prop(
                        'disabled',
                        true
                    );

                return;

            }


            var classSections =
                approveStudentSections[classId] || [];


            if (classSections.length === 0) {

                sectionSelect

                    .html(
                        '<option value="">No active sections available</option>'
                    )

                    .prop(
                        'disabled',
                        true
                    );

                return;

            }


            sectionSelect.empty();


            sectionSelect.append(
                $('<option>', {
                    value: '',
                    text: 'Select Section'
                })
            );


            $.each(
                classSections,
                function(index, section) {

                    sectionSelect.append(
                        $('<option>', {
                            value: section.id,
                            text: section.name
                        })
                    );

                }
            );


            sectionSelect.prop(
                'disabled',
                false
            );

        }
    );


    $(document).on(
        'submit',
        '#approveStudentForm',
        function(e) {

            var classId =
                $('#approve_my_class_id').val();


            var sectionId =
                $('#approve_section_id').val();


            if (!classId) {

                e.preventDefault();

                alert(
                    'Please select a class.'
                );

                return false;

            }


            if (!sectionId) {

                e.preventDefault();

                alert(
                    'Please select a section.'
                );

                return false;

            }

        }
    );

</script>

{{-- ========================================================= --}}
{{-- VIEW STUDENT APPLICATION --}}
{{-- ========================================================= --}}

<script>

    $(document).on(
        'click',
        '.view-student-application-btn',
        function() {

            var button =
                $(this);


            $('#view_app_photo').attr(
                'src',
                button.attr('data-photo')
            );


            $('#view_app_number').text(
                button.attr('data-application-number') || '-'
            );


            $('#view_app_full_name').text(
                button.attr('data-full-name') || '-'
            );


            $('#view_app_first_name').text(
                button.attr('data-first-name') || '-'
            );


            $('#view_app_last_name').text(
                button.attr('data-last-name') || '-'
            );


            $('#view_app_dob').text(
                button.attr('data-date-of-birth') || '-'
            );


            $('#view_app_gender').text(
                button.attr('data-gender') || '-'
            );


            $('#view_app_nationality').text(
                button.attr('data-nationality') || '-'
            );


            $('#view_app_birth_place').text(
                button.attr('data-place-of-birth') || '-'
            );


            $('#view_app_current_school').text(
                button.attr('data-current-school') || '-'
            );


            $('#view_app_current_level').text(
                button.attr('data-current-level') || '-'
            );


            $('#view_app_previous_school').text(
                button.attr('data-previous-school') || '-'
            );


            $('#view_app_program').text(
                button.attr('data-program') || '-'
            );


            $('#view_app_requested_level').text(
                button.attr('data-requested-level') || '-'
            );


            $('#view_app_academic_year').text(
                button.attr('data-academic-year') || '-'
            );


            $('#view_app_start_date').text(
                button.attr('data-desired-start-date') || '-'
            );


            $('#view_app_academic_notes').text(
                button.attr('data-academic-notes') || '-'
            );


            $('#view_app_address').text(
                button.attr('data-address') || '-'
            );


            $('#view_app_city').text(
                button.attr('data-city') || '-'
            );


            $('#view_app_country').text(
                button.attr('data-country') || '-'
            );


            $('#view_app_parent_name').text(
                button.attr('data-parent-name') || '-'
            );


            $('#view_app_parent_relationship').text(
                button.attr('data-parent-relationship') || '-'
            );


            $('#view_app_parent_phone').text(
                button.attr('data-parent-phone') || '-'
            );


            $('#view_app_parent_whatsapp').text(
                button.attr('data-parent-whatsapp') || '-'
            );


            $('#view_app_parent_email').text(
                button.attr('data-parent-email') || '-'
            );


            $('#view_app_parent_occupation').text(
                button.attr('data-parent-occupation') || '-'
            );


            $('#view_app_parent_address').text(
                button.attr('data-parent-address') || '-'
            );


            $('#view_app_emergency_name').text(
                button.attr('data-emergency-name') || '-'
            );


            $('#view_app_emergency_relationship').text(
                button.attr('data-emergency-relationship') || '-'
            );


            $('#view_app_emergency_phone').text(
                button.attr('data-emergency-phone') || '-'
            );


            $('#view_app_medical_notes').text(
                button.attr('data-medical-notes') || '-'
            );


            $('#view_app_additional_comments').text(
                button.attr('data-additional-comments') || '-'
            );


            $('#view_app_how_did_you_hear').text(
                button.attr('data-how-did-you-hear') || '-'
            );


            $('#view_app_status').text(
                button.attr('data-status') || '-'
            );


            $('#view_app_admin_notes').text(
                button.attr('data-admin-notes') || '-'
            );

        }
    );

</script>

{{-- ========================================================= --}}
{{-- DELETE STUDENT APPLICATION --}}
{{-- ========================================================= --}}

<script>

    function deleteStudentApplication(applicationId) {

        if (!confirm(
            'Are you sure you want to delete this student application?'
        )) {

            return;

        }


        var form =
            document.getElementById(
                'delete-student-application-' + applicationId
            );


        if (form) {

            form.submit();

        } else {

            console.error(
                'Delete form not found for application:',
                applicationId
            );

        }

    }

</script>

@endsection
