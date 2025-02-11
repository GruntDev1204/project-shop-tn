<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <title>Active User</title>
    <style>
        img {
            height: 200px;
            width: 200px;
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
                        <h3 class="text-center mb-5 mt-5">Active User <i class="fa-solid fa-user-check"></i> </h3>
                        <h4>Hi , {{ $userName }} !</h4>
                        <p>This is your infomation : </p>
                        <div class="alert alert-success">
                            <p class="text-center mb-5"><img src={{ $avatar }} alt="avatar" /></p>
                            <p>Name : {{ $userName }}</p>
                            <p>Email : {{ $email }}</p>
                            <p>Please click that button to active your account!</p>
                            <form action="http://127.0.0.1:8000/api/users/active/{{ $hash_code }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success">Active</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
