<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"></script>
    <title>Active User</title>
    <link rel="stylesheet" href="/assets/style/index.css" />
</head>

<body>
    <div class="container mt-5" id="app">
        <div class="alert alert-successs alert-fixed" v-if="success !== ''">
            <p>
            <h4><i class="fa-regular fa-circle-check"></i> </h4>
            <h4 v-text="success"></h4>
            </p>
        </div>
        <div class="alert alert-dangerr alert-fixed" v-if="error !== ''">
            <h4><i class="fa-solid fa-triangle-exclamation"></i> </h4>
            <h4 v-text="error"></h4>
        </div>

        <div class="row">
            <div class="col">
                <div class="alert alert-info">
                    <div class="alert alert-success">
                        <h3 class="text-center mb-5 mt-5">Active User <i class="fa-solid fa-user-check"></i> </h3>
                        <h4>Hi , {{ $userName }} !</h4>
                        <p>This is your infomation : </p>
                        <p class="text-center mb-5"><img src={{ $avatar }} alt="avatar" /></p>
                        <p>Name : {{ $userName }}</p>
                        <p>Email : {{ $email }}</p>
                        <p>Please type your OTP , what were sent to your email!</p>
                        <p> OTP : <input class="form-control" type="number" v-model="otp"/> </p>
                       <p> And then click that button to active your account!</p>
                        <button type="submit" class="btn btn-success"
                            v-on:click="changePassowrd('{{ $hash_code }}')">Active</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="/assets/active.js"></script>
</html>
