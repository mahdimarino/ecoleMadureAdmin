@extends('layouts.master')
@section('page_title', 'Mon Tableau de bord')
@section('content')

    {{-- ========================================================= --}}
    {{-- RESPONSIVE STYLES --}}
    {{-- ========================================================= --}}
    <style>
        /* ---------- Stat cards ---------- */
        .dash-stat {
            margin-bottom: 1rem;
        }

        .dash-stat .media {
            align-items: center;
        }

        /* ---------- Calendar toolbar (all sizes) ---------- */
        .school-calendar .fc-toolbar h2 {
            margin: 0;
        }

        .school-calendar .fc-event {
            cursor: pointer;
        }

        /* ---------- Day events list inside modal ---------- */
        .cal-event-card .cal-event-title {
            word-break: break-word;
        }

        .cal-event-card .edit-calendar-event {
            min-width: 40px;
            min-height: 40px;
        }

        /* ---------- Tablets and below ---------- */
        @media (max-width: 767.98px) {

            .calendar-card .card-body {
                padding: .75rem;
            }

            #calendar_class_filter_wrap {
                max-width: 100% !important;
            }

            /* Toolbar: title on top, buttons underneath */
            .school-calendar .fc-toolbar {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
            }

            .school-calendar .fc-toolbar .fc-left,
            .school-calendar .fc-toolbar .fc-right {
                float: none;
            }

            .school-calendar .fc-toolbar .fc-center {
                order: -1;
                width: 100%;
                text-align: center;
                margin-bottom: .6rem;
            }

            .school-calendar .fc-toolbar .fc-center h2 {
                font-size: 1.1rem;
                text-transform: capitalize;
            }

            .school-calendar .fc-toolbar .fc-clear {
                display: none;
            }

            .school-calendar .fc-button {
                padding: .3rem .55rem;
                font-size: .8rem;
                height: auto;
            }
        }

        /* ---------- Phones ---------- */
        @media (max-width: 575.98px) {

            /* Stat cards: 2 x 2 grid, compact */
            .dash-stats {
                margin-left: -6px;
                margin-right: -6px;
            }

            .dash-stats>[class*="col-"] {
                padding-left: 6px;
                padding-right: 6px;
            }

            .dash-stat {
                padding: .875rem;
                margin-bottom: .75rem;
            }

            .dash-stat h3 {
                font-size: 1.4rem;
            }

            .dash-stat .icon-3x {
                font-size: 1.75rem;
            }

            .dash-stat .text-uppercase {
                display: block;
                font-size: .625rem;
                letter-spacing: .3px;
                line-height: 1.2;
            }

            /* Calendar grid */
            .school-calendar .fc-day-header {
                font-size: .7rem;
                padding: 4px 0;
            }

            .school-calendar .fc-day-number {
                font-size: .75rem;
                padding: 2px 4px;
            }

            .school-calendar .fc-day-grid-event {
                font-size: .65rem;
                margin: 1px 1px 0;
                padding: 0 2px;
            }

            .school-calendar .fc-day-grid-event .fc-time {
                display: none;
            }

            .school-calendar .fc-more {
                font-size: .65rem;
            }

            /* Modal: full screen, scrollable body */
            #calendarEventModal .modal-dialog {
                margin: 0;
                max-width: 100%;
                min-height: 100%;
            }

            #calendarEventModal .modal-content {
                min-height: 100vh;
                border: 0;
                border-radius: 0;
            }

            #calendarEventModal .modal-body {
                padding: 1rem;
            }

            #calendarEventModal .modal-title {
                font-size: 1rem;
            }

            /* 16px inputs stop iOS from zooming on focus */
            #calendarEventModal .form-control {
                font-size: 16px;
                min-height: 44px;
            }

            #calendarEventModal .btn {
                min-height: 44px;
            }

            #addCalendarEventBtn {
                width: 100%;
            }

            /* Form buttons: full width, save on top */
            #calendarEventForm .form-actions {
                display: flex;
                flex-direction: column-reverse;
            }

            #calendarEventForm .form-actions .btn {
                width: 100%;
                margin: .25rem 0 0;
            }
        }
    </style>


    @if (Qs::userIsTeamSA())
        <div class="row dash-stats">
            <div class="col-6 col-xl-3">
                <div class="card card-body bg-blue-400 has-bg-image dash-stat">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0">{{ $users->where('user_type', 'student')->count() }}</h3>
                            <span class="text-uppercase font-size-xs font-weight-bold">Total Étudiants</span>
                        </div>

                        <div class="ml-3 align-self-center">
                            <i class="icon-users4 icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card card-body bg-danger-400 has-bg-image dash-stat">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0">{{ $users->where('user_type', 'teacher')->count() }}</h3>
                            <span class="text-uppercase font-size-xs">Total Enseignants</span>
                        </div>

                        <div class="ml-3 align-self-center">
                            <i class="icon-users2 icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card card-body bg-success-400 has-bg-image dash-stat">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0">{{ $users->where('user_type', 'admin')->count() }}</h3>
                            <span class="text-uppercase font-size-xs">Total Administrateurs</span>
                        </div>

                        <div class="ml-3 align-self-center">
                            <i class="icon-pointer icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card card-body bg-indigo-400 has-bg-image dash-stat">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0">{{ $users->where('user_type', 'parent')->count() }}</h3>
                            <span class="text-uppercase font-size-xs">Total Parents</span>
                        </div>

                        <div class="ml-3 align-self-center">
                            <i class="icon-user icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Events Calendar Begins --}}
    <div class="card calendar-card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Calendrier des événements scolaires</h5>
            {!! Qs::getPanelOptions() !!}
        </div>

        <div class="card-body">

            @if ($calendar_classes->count())
                <div class="form-group" id="calendar_class_filter_wrap" style="max-width: 320px;">
                    <label>Classe</label>

                    <select id="calendar_class_filter" class="form-control select">

                        @if (Qs::userIsTeamSAT() || $calendar_classes->count() > 1)
                            <option value="">Toutes les classes</option>
                        @endif

                        @foreach ($calendar_classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach

                    </select>
                </div>
            @endif

            <div class="school-calendar"></div>
        </div>
    </div>

    <!-- Calendar Modal -->
    <div class="modal fade" id="calendarEventModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="icon-calendar mr-2"></i>
                        <span id="calendarModalTitle">Calendrier</span>
                    </h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <!-- DAY VIEW -->
                    <div id="calendarDayView">

                        <div class="alert alert-light border">
                            <strong id="selectedCalendarDate"></strong>
                        </div>

                        <div id="calendarDayEvents"></div>

                        @if (Qs::userIsTeamSAT())
                            <button type="button" class="btn btn-primary mt-3" id="addCalendarEventBtn">
                                <i class="icon-plus2 mr-2"></i>
                                Ajouter
                            </button>
                        @endif

                    </div>


                    <!-- FORM -->
                    <div id="calendarFormView" style="display:none;">

                        <form id="calendarEventForm">

                            @csrf

                            <input type="hidden" id="calendar_event_id" name="event_id">

                            <input type="hidden" id="calendar_event_type" name="type">


                            <div class="form-group">
                                <label>Type</label>

                                <select id="calendar_type" class="form-control">
                                    <option value="schedule">Emploi du temps</option>
                                    <option value="exam">Examen</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label>Classe</label>

                                <select name="class_id" id="calendar_class_id" class="form-control" required>

                                    @foreach ($calendar_classes as $class)
                                        <option value="{{ $class->id }}">
                                            {{ $class->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>


                            <div class="form-group">
                                <label>Matière</label>

                                {{-- Options are built by JavaScript according to the selected class --}}
                                <select name="subject_id" id="calendar_subject_id" class="form-control" required>
                                </select>
                            </div>


                            {{-- EXAM NAME --}}
                            <div class="form-group" id="calendar_exam_group" style="display:none;">

                                <label>Examen</label>

                                <input type="text" name="exam_name" id="calendar_exam_name" class="form-control"
                                    placeholder="Exemple : Examen de Mathématiques">

                            </div>


                            <div class="form-group">

                                <label>Date</label>

                                <input type="date" name="date" id="calendar_date" class="form-control" required>

                            </div>


                            <div class="row">

                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Début</label>

                                        <input type="time" name="start_time" id="calendar_start_time"
                                            class="form-control" required>
                                    </div>
                                </div>


                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Fin</label>

                                        <input type="time" name="end_time" id="calendar_end_time"
                                            class="form-control" required>
                                    </div>
                                </div>

                            </div>


                            <div class="text-right form-actions">

                                <button type="button" class="btn btn-light" id="calendarBackBtn">
                                    Retour
                                </button>

                                <button type="submit" class="btn btn-primary">
                                    Enregistrer
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </div>
    </div>

@section('scripts')

    <script>
        $(document).ready(function() {

            var calendar = $('.school-calendar');

            var canManage = @json(Qs::userIsTeamSAT());

            var baseUrl = "{{ url('/calendar/events') }}";

            var classFilter = $('#calendar_class_filter');

            var classes = {!! $calendar_classes->map(function ($class) {
                    return [
                        'id' => $class->id,
                        'name' => $class->name,
                    ];
                })->values()->toJson() !!};

            var subjects = {!! $calendar_subjects->map(function ($subject) {
                    return [
                        'id' => $subject->id,
                        'name' => $subject->name,
                        'class_id' => $subject->my_class_id,
                    ];
                })->values()->toJson() !!};


            /*
            |--------------------------------------------------------------------------
            | MOBILE HELPERS
            |--------------------------------------------------------------------------
            */

            function isMobile() {
                return window.innerWidth < 576;
            }

            function getAspectRatio() {
                // Taller cells on phones so events are readable
                return isMobile() ? 0.85 : 1.35;
            }


            /*
            |--------------------------------------------------------------------------
            | CALENDAR
            |--------------------------------------------------------------------------
            */

            calendar.fullCalendar({

                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },

                defaultView: 'month',

                editable: false,

                eventLimit: true,

                aspectRatio: getAspectRatio(),

                windowResize: function() {
                    calendar.fullCalendar('option', 'aspectRatio', getAspectRatio());
                },

                events: {
                    url: "{{ route('calendar.events') }}",
                    data: function() {
                        return {
                            class_id: classFilter.val() || ''
                        };
                    }
                },

                eventAfterAllRender: function() {

                    // Reset all days first
                    $('.fc-day').css('background-color', '');

                    var events = calendar.fullCalendar('clientEvents');

                    events.forEach(function(event) {

                        var props = event.extendedProps;

                        // Only exams make the whole day yellow
                        if (props.type !== 'exam') {
                            return;
                        }

                        var date = moment(event.start).format('YYYY-MM-DD');

                        $('.fc-day[data-date="' + date + '"]').css({
                            'background-color': '#fff3cd'
                        });

                    });
                },

                dayClick: function(date) {
                    openDayModal(date.format('YYYY-MM-DD'));
                },

                eventClick: function(event) {

                    var props = event.extendedProps;

                    // Read-only users: tapping an event opens the day details
                    // (on a phone the event text is tiny, so this is the way to read it)
                    if (!canManage) {
                        openDayModal(moment(event.start).format('YYYY-MM-DD'));
                        return false;
                    }

                    if (!props.row_id) {
                        alert('TimeTable ID is missing.');
                        return;
                    }

                    openEventModal(event);
                },

                isRTL: $('html').attr('dir') === 'rtl'

            });


            /*
            |--------------------------------------------------------------------------
            | CLASS FILTER
            |--------------------------------------------------------------------------
            */

            classFilter.on('change', function() {

                calendar.fullCalendar('refetchEvents');

            });


            /*
            |--------------------------------------------------------------------------
            | OPEN DAY
            |--------------------------------------------------------------------------
            */

            function openDayModal(date) {

                $('#calendarDayView').show();
                $('#calendarFormView').hide();

                $('#calendarModalTitle').text('Calendrier');

                $('#selectedCalendarDate')
                    .text(moment(date).format('dddd DD MMMM YYYY'))
                    .data('date', date);

                $('#calendarDayEvents').html(
                    '<div class="text-center p-3">' +
                    '<i class="icon-spinner2 spinner"></i>' +
                    '</div>'
                );

                $('#calendarEventModal').modal('show');


                var events = calendar.fullCalendar('clientEvents');

                var dayEvents = events.filter(function(event) {
                    return moment(event.start).format('YYYY-MM-DD') === date;
                });

                // Show exams first, then normal schedule
                dayEvents.sort(function(a, b) {

                    var aIsExam = a.extendedProps.type === 'exam';
                    var bIsExam = b.extendedProps.type === 'exam';

                    if (aIsExam && !bIsExam) return -1;
                    if (!aIsExam && bIsExam) return 1;

                    return moment(a.start).valueOf() - moment(b.start).valueOf();

                });


                if (!dayEvents.length) {

                    $('#calendarDayEvents').html(
                        '<div class="alert alert-info">' +
                        '<i class="icon-info22 mr-2"></i>' +
                        'Aucun événement pour cette date.' +
                        '</div>'
                    );

                    return;
                }


                var html = '';

                $.each(dayEvents, function(index, event) {

                    var props = event.extendedProps;

                    var isExam = props.type === 'exam';

                    html +=
                        '<div class="card cal-event-card border-left-' +
                        (isExam ? 'danger' : 'primary') +
                        ' mb-2">' +

                        '<div class="card-body py-2">' +

                        '<div class="d-flex justify-content-between align-items-start">' +

                        '<div class="mr-2">' +

                        '<span class="badge badge-' + (isExam ? 'danger' : 'primary') + ' mb-1">' +
                        (isExam ? 'Examen' : 'Cours') +
                        '</span>' +

                        '<div class="cal-event-title"><strong>' +
                        escapeHtml(event.title) +
                        '</strong></div>' +

                        '<div class="text-muted mt-1">' +
                        '<i class="icon-alarm mr-1"></i>' +
                        moment(event.start).format('HH:mm') +
                        ' - ' +
                        moment(event.end).format('HH:mm') +
                        '</div>' +

                        '<div class="text-muted">' +
                        escapeHtml(props.class_name) +
                        '</div>' +

                        '</div>' +

                        '<div>';

                    if (canManage) {

                        html +=
                            '<button type="button" ' +
                            'class="btn btn-sm btn-light edit-calendar-event" ' +
                            'data-row-id="' + props.row_id + '">' +

                            '<i class="icon-pencil"></i>' +

                            '</button>';

                    }

                    html +=
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';

                });


                $('#calendarDayEvents').html(html);


                $('.edit-calendar-event').off('click').on('click', function() {

                    var rowId = $(this).data('row-id');

                    var event = events.find(function(e) {

                        return e.extendedProps.row_id == rowId;

                    });

                    if (event) {
                        openEventModal(event);
                    }

                });

            }


            /*
            |--------------------------------------------------------------------------
            | ADD
            |--------------------------------------------------------------------------
            */

            $('#addCalendarEventBtn').on('click', function() {

                resetForm();

                if (classFilter.val()) {

                    $('#calendar_class_id').val(classFilter.val());

                    filterSubjects();

                }

                var date = $('#selectedCalendarDate').data('date');

                if (!date) {

                    date = moment().format('YYYY-MM-DD');

                }

                $('#calendar_date').val(date);

                $('#calendarModalTitle').text('Ajouter un événement');

                $('#calendarDayView').hide();

                $('#calendarFormView').show();

                $('#calendar_event_id').val('');

                $('#calendar_event_type').val('schedule');

                $('#calendar_type')
                    .val('schedule')
                    .trigger('change');

            });


            /*
            |--------------------------------------------------------------------------
            | TYPE CHANGE
            |--------------------------------------------------------------------------
            */

            $('#calendar_type').on('change', function() {

                var type = $(this).val();

                $('#calendar_event_type').val(type);

                if (type === 'exam') {

                    $('#calendar_exam_group').show();

                    $('#calendar_exam_name').prop('required', true);

                } else {

                    $('#calendar_exam_group').hide();

                    $('#calendar_exam_name')
                        .prop('required', false)
                        .val('');

                }

            });


            /*
            |--------------------------------------------------------------------------
            | CLASS CHANGE
            |--------------------------------------------------------------------------
            */

            $('#calendar_class_id').on('change', function() {

                filterSubjects();

            });


            /*
            |--------------------------------------------------------------------------
            | SUBJECTS
            | Rebuilt instead of hidden: iOS Safari / Android ignore
            | display:none on <option>, which showed every class's subjects.
            |--------------------------------------------------------------------------
            */

            function filterSubjects(selectedId) {

                var classId = $('#calendar_class_id').val();

                var select = $('#calendar_subject_id').empty();

                $.each(subjects, function(index, subject) {

                    if (String(subject.class_id) === String(classId)) {

                        select.append(
                            $('<option>', {
                                value: subject.id,
                                text: subject.name
                            })
                        );

                    }

                });

                if (selectedId) {

                    select.val(selectedId);

                }

            }


            /*
            |--------------------------------------------------------------------------
            | FORM SUBMIT
            |--------------------------------------------------------------------------
            */

            $('#calendarEventForm').on('submit', function(e) {

                e.preventDefault();

                var id = $('#calendar_event_id').val();

                var method = id ? 'PUT' : 'POST';

                var url = id ?
                    baseUrl + '/' + id :
                    baseUrl;


                $.ajax({

                    url: url,

                    type: method,

                    data: $(this).serialize(),

                    success: function(response) {

                        $('#calendarEventModal').modal('hide');

                        calendar.fullCalendar('refetchEvents');

                        flash({
                            msg: response.msg,
                            type: 'success'
                        });

                    },

                    error: function(xhr) {

                        console.log('Calendar update error:', xhr);

                        console.log('Response:', xhr.responseJSON);

                        var message = 'Une erreur est survenue.';

                        if (xhr.responseJSON) {

                            if (xhr.responseJSON.msg) {

                                message = xhr.responseJSON.msg;

                            } else if (xhr.responseJSON.message) {

                                message = xhr.responseJSON.message;

                            } else if (xhr.responseJSON.errors) {

                                message = Object.values(xhr.responseJSON.errors)
                                    .flat()
                                    .join('<br>');

                            }

                        }

                        flash({
                            msg: message,
                            type: 'danger'
                        });

                    }

                });

            });


            /*
            |--------------------------------------------------------------------------
            | OPEN EVENT
            |--------------------------------------------------------------------------
            */

            function openEventModal(event) {

                var props = event.extendedProps;

                $('#calendarDayView').hide();

                $('#calendarFormView').show();

                $('#calendarModalTitle').text(
                    props.type === 'exam' ?
                    'Modifier l’examen' :
                    'Modifier le planning'
                );

                $('#calendar_event_id').val(props.row_id);

                $('#calendar_event_type').val(props.type);

                $('#calendar_type').val(props.type);

                $('#calendar_class_id').val(props.class_id);

                // Build the subject list for this class, then select the right one
                filterSubjects(props.subject_id);

                $('#calendar_date').val(props.date);

                $('#calendar_start_time').val(moment(event.start).format('HH:mm'));

                $('#calendar_end_time').val(moment(event.end).format('HH:mm'));


                if (props.type === 'exam') {

                    $('#calendar_exam_group').show();

                    $('#calendar_exam_name')
                        .val(props.exam_name)
                        .prop('required', true);

                } else {

                    $('#calendar_exam_group').hide();

                    $('#calendar_exam_name')
                        .val('')
                        .prop('required', false);

                }

                $('#calendarEventModal').modal('show');

            }


            /*
            |--------------------------------------------------------------------------
            | BACK
            |--------------------------------------------------------------------------
            */

            $('#calendarBackBtn').on('click', function() {

                $('#calendarFormView').hide();

                $('#calendarDayView').show();

                $('#calendarModalTitle').text('Calendrier');

            });


            /*
            |--------------------------------------------------------------------------
            | RESET
            |--------------------------------------------------------------------------
            */

            function resetForm() {

                $('#calendarEventForm')[0].reset();

                $('#calendar_event_id').val('');

                $('#calendar_type').prop('disabled', false);

                $('#calendar_class_id').prop('disabled', false);

                $('#calendar_exam_name')
                    .prop('disabled', false)
                    .prop('required', false)
                    .val('');

                $('#calendar_exam_group').hide();

                $('#calendar_start_time').val('08:00');

                $('#calendar_end_time').val('09:00');

                filterSubjects();

            }


            /*
            |--------------------------------------------------------------------------
            | ESCAPE HTML
            |--------------------------------------------------------------------------
            */

            function escapeHtml(text) {

                return $('<div>')
                    .text(text || '')
                    .html();

            }

        });
    </script>

@endsection

{{-- Events Calendar Ends --}}
@endsection