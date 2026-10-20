@extends('layouts.master')

@section('page_title', 'All Students')

@section('content')
<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">All Students</h6>
        {!! Qs::getPanelOptions() !!}
    </div>

    <div class="card-body">
        <p class="text-muted">
            All active students across every class.
            <strong>{{ $students->count() }} students</strong>
        </p>

        <div class="table-responsive">
            <table class="table datatable-button-html5-columns">
                <thead>
                    <tr>
                        {{-- <th>S/N</th> --}}
                        <th>Photo</th>
                        <th>Name</th>
                        {{-- <th>ADM_No</th> --}}
                        <th>Class</th>
                        {{-- <th>Section</th> --}}
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($students as $s)
                        <tr>
                            {{-- <td>{{ $loop->iteration }}</td> --}}

                            <td>
                                <img
                                    class="rounded-circle"
                                    style="height:40px;width:40px;"
                                    src="{{ optional($s->user)->photo }}"
                                    alt="photo"
                                >
                            </td>

                            <td>{{ optional($s->user)->name }}</td>
                            {{-- <td>{{ $s->adm_no }}</td> --}}
                            <td>{{ optional($s->my_class)->name ?? '—' }}</td>
                            {{-- <td>{{ optional($s->section)->name ?? '—' }}</td> --}}
                            <td>{{ optional($s->user)->email }}</td>

                            <td>
                                <a href="{{ route('students.show', Qs::hash($s->id)) }}"
                                   class="btn btn-sm btn-light">
                                    View Profile
                                </a>

                                @if(Qs::userIsTeamSA())
                                    <a href="{{ route('students.edit', Qs::hash($s->id)) }}"
                                       class="btn btn-sm btn-light">
                                        Edit
                                    </a>

                                    <button type="button"
                                            class="btn btn-sm btn-light"
                                            data-toggle="modal"
data-target="#resetPasswordModal"
data-user-id="{{ Qs::hash($s->user->id) }}"
data-user-name="{{ $s->user->name }}"
                                            >
                                        Reset password
                                    </button>
                                @endif

                                @if(Qs::userIsSuperAdmin())
                                    <a href="#"
                                       onclick="confirmDelete('{{ Qs::hash($s->user->id) }}'); return false;"
                                       class="btn btn-sm btn-danger">
                                        Delete
                                    </a>

                                    <form method="POST"
                                          id="item-delete-{{ Qs::hash($s->user->id) }}"
                                          action="{{ route('students.destroy', Qs::hash($s->user->id)) }}"
                                          class="hidden">
                                        @csrf
                                        @method('delete')
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                No active students found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>



{{-- Reset Password Modal --}}
<div class="modal fade" id="resetPasswordModal" tabindex="-1"
     role="dialog" aria-labelledby="resetPasswordModalLabel"
     aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form method="POST" action="{{ route('st.reset_pass') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="resetPasswordModalLabel">
                        Reset Student Password
                    </h5>

                    <button type="button" class="close"
                            data-dismiss="modal" aria-label="Close">
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
                            New Password <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">
                            <input type="password"
                                   name="password"
                                   id="reset_password"
                                   class="form-control"
                                   placeholder="Enter new password"
                                   required minlength="6">

                            <div class="input-group-append">
                                <button type="button"
                                        class="btn btn-light"
                                        onclick="toggleStudentPassword('reset_password', this)"
                                        aria-label="Show or hide password">
                                    <i class="icon-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>
                            Confirm Password <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">
                            <input type="password"
                                   name="password_confirmation"
                                   id="reset_password_confirmation"
                                   class="form-control"
                                   placeholder="Confirm new password"
                                   required minlength="6">

                            <div class="input-group-append">
                                <button type="button"
                                        class="btn btn-light"
                                        onclick="toggleStudentPassword('reset_password_confirmation', this)"
                                        aria-label="Show or hide password">
                                    <i class="icon-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                            data-dismiss="modal">
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

        $('#reset_user_id').val(button.data('user-id'));
        $('#reset_student_name').text(button.data('user-name'));

        $('#reset_password').val('');
        $('#reset_password_confirmation').val('');
    });

    function toggleStudentPassword(inputId, button) {
        var input = document.getElementById(inputId);
        var icon = button.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'icon-eye-blocked';
        } else {
            input.type = 'password';
            icon.className = 'icon-eye';
        }
    }
</script>

@endsection