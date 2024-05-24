<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Verify OTP</title>
</head>
<body>

    <h1>Hi, {{$user->fullName()}}</h1>
    <h3>You OTP is: {{$otp}}</h3>
    <p>Please verify you email.</p>
    <p>Thank you.</p>

</body>
</html>
