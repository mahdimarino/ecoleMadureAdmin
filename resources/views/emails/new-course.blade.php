<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Course Material</title>
</head>

<body>

    <h2>New Course Material Available</h2>

    <p>Hello,</p>

    <p>
        A new course material has been added to your class.
    </p>

    <p>
        <strong>Course:</strong> {{ $course->title }}
    </p>

    @if($course->description)
        <p>
            <strong>Description:</strong><br>
            {{ $course->description }}
        </p>
    @endif

    @if($course->my_class)
        <p>
            <strong>Class:</strong> {{ $course->my_class->name }}
        </p>
    @endif

    <p>
        Please log in to your student account to view the new course material.
    </p>

    <p>
        Best regards,<br>
        École Madaure
    </p>

</body>
</html>