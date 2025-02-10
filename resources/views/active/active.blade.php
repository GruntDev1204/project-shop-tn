<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <title>Active User</title>
    <style>
        img {
            height: 100px;
            width: 100px;
            border-radius: 50%
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="container mt-5">
            <div class="row">
                <div class="col">
                    <div class="alert alert-info">
                        <h3 class="text-center">Active User</h3>
                        <p>Hi , {{ $userName }}</p>
                        <p>This is your infomation : </p>
                        <p><img src={{ $avatar }} alt="avatar" class="img-fluid" /></p>
                        <p>Name : {{ $userName }}</p>
                        <p>Email : {{ $email }}</p>
                        <p>Please click that button to active your account!</p>
                        <a href="http://127.0.0.1:8000/api/users/active/{{ $hash_code }}" type="button"
                            class="btn btn-success">Active</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
