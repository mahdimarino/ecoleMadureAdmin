@extends('layouts.master')
@section('page_title', 'Student Information - '.$my_class->name)
@section('content')

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">Students List</h6>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-highlight">
                <li class="nav-item"><a href="#all-students" class="nav-link active" data-toggle="tab">All {{ $my_class->name }} Students</a></li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Sections</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @foreach($sections as $s)
                            <a href="#s{{ $s->id }}" class="dropdown-item" data-toggle="tab">{{ $my_class->name.' '.$s->name }}</a>
                        @endforeach
                    </div>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="all-students">
                    <table class="table datatable-button-html5-columns">
                        <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>ADM_No</th>
                            {{-- <th>Section</th> --}}
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($students as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><img class="rounded-circle" style="height: 40px; width: 40px;" src="{{ $s->user->photo }}" alt="photo"></td>
                                <td>{{ $s->user->name }}</td>
                                <td>{{ $s->adm_no }}</td>
                                {{-- <td>{{ $my_class->name.' '.$s->section->name }}</td> --}}
                                <td>{{ $s->user->email }}</td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-left">
                                                <a href="{{ route('students.show', Qs::hash($s->id)) }}" class="dropdown-item"><i class="icon-eye"></i> View Profile</a>
                                                @if(Qs::userIsTeamSA())
                                                    <a href="{{ route('students.edit', Qs::hash($s->id)) }}" class="dropdown-item"><i class="icon-pencil"></i> Edit</a>
                                                   <a href="#"
   class="dropdown-item"
   data-toggle="modal"
   data-target="#resetPasswordModal"
   data-user-id="{{ Qs::hash($s->user->id) }}"
   data-user-name="{{ $s->user->name }}">
    <i class="icon-lock"></i> Reset password
</a>
                                                @endif
                                                {{-- <a target="_blank" href="{{ route('marks.year_selector', Qs::hash($s->user->id)) }}" class="dropdown-item"><i class="icon-check"></i> Marksheet</a> --}}

                                                {{--Delete--}}
                                                @if(Qs::userIsSuperAdmin())
                                                    <a id="{{ Qs::hash($s->user->id) }}" onclick="confirmDelete(this.id)" href="#" class="dropdown-item"><i class="icon-trash"></i> Delete</a>
                                                    <form method="post" id="item-delete-{{ Qs::hash($s->user->id) }}" action="{{ route('students.destroy', Qs::hash($s->user->id)) }}" class="hidden">@csrf @method('delete')</form>
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

                @foreach($sections as $se)
                    <div class="tab-pane fade" id="s{{$se->id}}">                         <table class="table datatable-button-html5-columns">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>ADM_No</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students->where('section_id', $se->id) as $sr)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img class="rounded-circle" style="height: 40px; width: 40px;" src="{{ $sr->user->photo }}" alt="photo"></td>
                                    <td>{{ $sr->user->name }}</td>
                                    <td>{{ $sr->adm_no }}</td>
                                    <td>{{ $sr->user->email }}</td>
                                    <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="{{ route('students.show', Qs::hash($sr->id)) }}" class="dropdown-item"><i class="icon-eye"></i> View Info</a>
                                                    @if(Qs::userIsTeamSA())
                                                        <a href="{{ route('students.edit', Qs::hash($sr->id)) }}" class="dropdown-item"><i class="icon-pencil"></i> Edit</a>
                                                        <a href="{{ route('st.reset_pass', Qs::hash($sr->user->id)) }}" class="dropdown-item"><i class="icon-lock"></i> Reset password</a>
                                                    @endif
                                                    {{-- <a href="#" class="dropdown-item"><i class="icon-check"></i> Marksheet</a> --}}

                                                    {{--Delete--}}
                                                    @if(Qs::userIsSuperAdmin())
                                                        <a id="{{ Qs::hash($sr->user->id) }}" onclick="confirmDelete(this.id)" href="#" class="dropdown-item"><i class="icon-trash"></i> Delete</a>
                                                        <form method="post" id="item-delete-{{ Qs::hash($sr->user->id) }}" action="{{ route('students.destroy', Qs::hash($sr->user->id)) }}" class="hidden">@csrf @method('delete')</form>
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

            </div>
        </div>
    </div>

    {{--Student List Ends--}}

    {{-- Reset Password Modal --}}
<div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form method="POST" action="{{ route('st.reset_pass') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="resetPasswordModalLabel">
                        Reset Student Password
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="user_id" id="reset_user_id">

                    <div class="mb-3">
                        <strong>Student:</strong>
                        <span id="reset_student_name"></span>
                    </div>

                    <div class="form-group">
                        <label>
                            New Password:
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="password"
                            name="password"
                            id="reset_password"
                            class="form-control"
                            placeholder="Enter new password"
                            required
                            minlength="6">
                    </div>

                    <div class="form-group">
                        <label>
                            Confirm Password:
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            placeholder="Confirm new password"
                            required
                            minlength="6">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="icon-lock"></i>
                        Change Password
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
    $('#resetPasswordModal').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget);

        var userId = button.data('user-id');
        var userName = button.data('user-name');

        $('#reset_user_id').val(userId);
        $('#reset_student_name').text(userName);

        $('#reset_password').val('');
    });
</script>

@endsection
