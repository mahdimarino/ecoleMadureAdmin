@extends('layouts.master')
@section('page_title', 'Mon Tableau de bord')
@section('content')

    @if(Qs::userIsTeamSA())
       <div class="row">
           <div class="col-sm-6 col-xl-3">
               <div class="card card-body bg-blue-400 has-bg-image">
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

           <div class="col-sm-6 col-xl-3">
               <div class="card card-body bg-danger-400 has-bg-image">
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

           <div class="col-sm-6 col-xl-3">
               <div class="card card-body bg-success-400 has-bg-image">
                   <div class="media">
                       <div class="mr-3 align-self-center">
                           <i class="icon-pointer icon-3x opacity-75"></i>
                       </div>

                       <div class="media-body text-right">
                           <h3 class="mb-0">{{ $users->where('user_type', 'admin')->count() }}</h3>
                           <span class="text-uppercase font-size-xs">Total Administrateurs</span>
                       </div>
                   </div>
               </div>
           </div>

           <div class="col-sm-6 col-xl-3">
               <div class="card card-body bg-indigo-400 has-bg-image">
                   <div class="media">
                       <div class="mr-3 align-self-center">
                           <i class="icon-user icon-3x opacity-75"></i>
                       </div>

                       <div class="media-body text-right">
                           <h3 class="mb-0">{{ $users->where('user_type', 'parent')->count() }}</h3>
                           <span class="text-uppercase font-size-xs">Total Parents</span>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       @endif

    {{--Events Calendar Begins--}}
   <div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Calendrier des événements scolaires</h5>
        {!! Qs::getPanelOptions() !!}
    </div>

    <div class="card-body">
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

                <button type="button"
                        class="close"
                        data-dismiss="modal">
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

                    @if(Qs::userIsTeamSAT())
                        <button type="button"
                                class="btn btn-primary mt-3"
                                id="addCalendarEventBtn">
                            <i class="icon-plus2 mr-2"></i>
                            Ajouter
                        </button>
                    @endif

                </div>


                <!-- FORM -->
                <div id="calendarFormView" style="display:none;">

                    <form id="calendarEventForm">

                        @csrf

                        <input type="hidden"
                               id="calendar_event_id"
                               name="event_id">

                        <input type="hidden"
                               id="calendar_event_type"
                               name="type">


                        <div class="form-group">
                            <label>Type</label>

                            <select id="calendar_type"
                                    class="form-control">

                                <option value="schedule">
                                    Emploi du temps
                                </option>

                                <option value="exam">
                                    Examen
                                </option>

                            </select>
                        </div>


                        <div class="form-group">
                            <label>Classe</label>

                            <select name="class_id"
                                    id="calendar_class_id"
                                    class="form-control"
                                    required>

                                @foreach($calendar_classes as $class)

                                    <option value="{{ $class->id }}">
                                        {{ $class->name }}
                                    </option>

                                @endforeach

                            </select>
                        </div>


                        <div class="form-group">
                            <label>Matière</label>

                            <select name="subject_id"
                                    id="calendar_subject_id"
                                    class="form-control"
                                    required>

                                @foreach($calendar_subjects as $subject)

                                    <option
                                        value="{{ $subject->id }}"
                                        data-class="{{ $subject->my_class_id }}">

                                        {{ $subject->name }}

                                    </option>

                                @endforeach

                            </select>
                        </div>


                        <div class="form-group"
                             id="calendar_exam_group"
                             style="display:none;">

                            <label>Examen</label>

                            <select name="exam_id"
                                    id="calendar_exam_id"
                                    class="form-control">

                                @foreach($calendar_exams as $exam)

                                    <option value="{{ $exam->id }}">
                                        {{ $exam->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="form-group">

                            <label>Date</label>

                            <input type="date"
                                   name="date"
                                   id="calendar_date"
                                   class="form-control"
                                   required>

                        </div>


                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Début</label>

                                    <input type="time"
                                           name="start_time"
                                           id="calendar_start_time"
                                           class="form-control"
                                           required>

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>Fin</label>

                                    <input type="time"
                                           name="end_time"
                                           id="calendar_end_time"
                                           class="form-control"
                                           required>

                                </div>

                            </div>

                        </div>


                        <div class="text-right">

                            <button type="button"
                                    class="btn btn-light"
                                    id="calendarBackBtn">
                                Retour
                            </button>

                            <button type="submit"
                                    class="btn btn-primary">
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

$(document).ready(function () {

    var calendar = $('.school-calendar');

    var canManage = @json(Qs::userIsTeamSAT());

    var baseUrl = "{{ url('/calendar/events') }}";

    var classes = @json(
        $calendar_classes->map(function($class) {
            return [
                'id' => $class->id,
                'name' => $class->name
            ];
        })->values()
    );

    var subjects = @json(
        $calendar_subjects->map(function($subject) {
            return [
                'id' => $subject->id,
                'name' => $subject->name,
                'class_id' => $subject->my_class_id
            ];
        })->values()
    );


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

        events: "{{ route('calendar.events') }}",

        dayClick: function(date) {

            openDayModal(
                date.format('YYYY-MM-DD')
            );

        },

        eventClick: function(event) {

    var props = event.extendedProps;

    console.log('EDIT EVENT:', event);
    console.log('TIMETABLE ID:', props.row_id);

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
    | OPEN DAY
    |--------------------------------------------------------------------------
    */

    function openDayModal(date) {

        $('#calendarDayView').show();
        $('#calendarFormView').hide();

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
                '<div class="card border-left-' +
                (isExam ? 'danger' : 'primary') +
                ' mb-2">' +

                    '<div class="card-body py-2">' +

                        '<div class="d-flex justify-content-between">' +

                            '<div>' +

                                '<strong>' +
                                    escapeHtml(event.title) +
                                '</strong>' +

                                '<div class="text-muted mt-1">' +
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

        var date = $('#selectedCalendarDate')
            .data('date');

        if (!date) {

            var text = $('#selectedCalendarDate').text();

            date = moment().format('YYYY-MM-DD');

        }

       $('#calendar_date').val(
    $('#selectedCalendarDate').data('date')
);

        $('#calendarModalTitle').text(
            'Ajouter un événement'
        );

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

            $('#calendar_exam_id').prop('required', true);

        } else {

            $('#calendar_exam_group').hide();

            $('#calendar_exam_id').prop('required', false);

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


    function filterSubjects() {

        var classId = $('#calendar_class_id').val();

        $('#calendar_subject_id option').each(function() {

            var subjectClass = $(this).data('class');

            $(this).toggle(
                String(subjectClass) === String(classId)
            );

        });

        var firstVisible = $('#calendar_subject_id option:visible')
            .first();

        if (firstVisible.length) {

            $('#calendar_subject_id')
                .val(firstVisible.val());

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

        var url = id
            ? baseUrl + '/' + id
            : baseUrl;


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
        }

        else if (xhr.responseJSON.message) {
            message = xhr.responseJSON.message;
        }

        else if (xhr.responseJSON.errors) {

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
            props.type === 'exam'
                ? 'Modifier l’examen'
                : 'Modifier le planning'
        );

        $('#calendar_event_id').val(
            props.row_id
        );

        $('#calendar_event_type').val(
            props.type
        );

       $('#calendar_type')
    .val(props.type);

$('#calendar_class_id')
    .val(props.class_id);

        $('#calendar_subject_id')
            .val(props.subject_id);

        $('#calendar_date')
            .val(props.date);

        $('#calendar_start_time')
            .val(moment(event.start).format('HH:mm'));

        $('#calendar_end_time')
            .val(moment(event.end).format('HH:mm'));

        if (props.type === 'exam') {

            $('#calendar_exam_group').show();

           $('#calendar_exam_id')
    .val(props.exam_id);

        } else {

            $('#calendar_exam_group').hide();

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

    });


    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */

    function resetForm() {

        $('#calendarEventForm')[0].reset();

        $('#calendar_event_id').val('');

        $('#calendar_type')
            .prop('disabled', false);

        $('#calendar_class_id')
            .prop('disabled', false);

        $('#calendar_exam_id')
            .prop('disabled', false);

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
    {{--Events Calendar Ends--}}
    @endsection