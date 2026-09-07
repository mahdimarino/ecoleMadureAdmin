<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Contact Form Submission</title>
</head>

<body>

    <h2>New Contact Form Submission</h2>

    <p><strong>Full Name:</strong> {{ $data['full_name'] }}</p>

    <p><strong>Email:</strong> {{ $data['email'] }}</p>

    <p><strong>Mobile Number:</strong> {{ $data['mobile_number'] }}</p>

    <p><strong>Subject:</strong> {{ $data['subject'] }}</p>

    <p><strong>Message:</strong></p>

    <p>
        {{ $data['message'] }}
    </p>

</body>
</html>