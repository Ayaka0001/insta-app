<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .h1{
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
        }
        a{
            font-style: italic;
            color: blue;
        }
        .info{
            text-decoration: underline;
            font-weight: light;
        }
        .danger{
            color: red;
            font-size: 0.8rem;
        }
        .footer{
            text-align: center;
            font-size: 0.6rem;
            font-style:italic;
            color: gray;
        }

    </style>
</head>
<body>
    <p class="h1">Welcome, {{ $name }}!</p> {{-- the variable $name comes from 'name' in line76 --}}
    <p>Thank you for registering at Kredo IG.</p>
    <p>To get started, visit the website <a href="{{ $appURL }}">here</a>.</p>
    <br>
    <p class="info">Information you registered</p>
    <p>Name: {{ $name }}</p>
    <p>Email: {{ $email }}</p>
    <p>Password: ****</p>
    <br>
    <p>To change your information please  <a href="{{ $appURL }}">login</a> and update your Kredo IG account</p>
    <p class="danger">
        If you did not register at Kredo IG, please ignore this email.
        <br>This is an automatically generated email. Please do not reply.
    </p>
    <hr>
    <p class="footer">Kredo IG</p>
</body>
</html>