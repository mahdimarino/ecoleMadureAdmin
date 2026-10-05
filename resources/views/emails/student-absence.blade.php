<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">

    <title>
        Student Absence Notification
    </title>

</head>


<body
    style="
        font-family: Arial, sans-serif;
        color: #333;
        line-height: 1.6;
    "
>

    <h2>
        Student Absence Notification
    </h2>


    <p>
        Dear Parent,
    </p>


    <p>

        This is to inform you that

        <strong>
            {{ $attendance->student->user->name }}
        </strong>

        was marked absent from school on

        <strong>
            {{ $attendance->date->format('d/m/Y') }}
        </strong>.

    </p>


    @if($attendance->note)

        <p>

            <strong>
                Note:
            </strong>

            <br>

            {{ $attendance->note }}

        </p>

    @endif


    <p>

        If you believe this information is incorrect,
        please contact the school administration.

    </p>


    <p>

        Regards,

        <br>

        {{ config('app.name', 'École Madaure') }}

    </p>

</body>

</html>