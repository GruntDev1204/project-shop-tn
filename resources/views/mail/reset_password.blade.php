<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Active User!</div>
                    <div class="panel-body">
                        <p>Hi {{ $email }},</p>
                        <p>Your otp : {{ $otp }} (do not share with anyone , you must need it to reset your password)</p>
                        <p>Click the button below to go to the page to reset your password.</p>
                        <p><a type="button" href="http://127.0.0.1:8000/api/auth/request-forgot-password?token={{ $token }}">Reset Password
                                </a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
