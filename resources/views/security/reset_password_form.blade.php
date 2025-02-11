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
    <title>Reset User's Password</title>
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
                    <div class="alert alert-success ">
                        <h3 class="text-center mb-5 mt-5">Change User's Password <i class="fas fa-lock"></i></h3>
                        <p>Hi , {{ $user->email }}</p>
                        <p>This is your infomation : </p>
                        <p class="text-center"><img src={{ $user->avatar }} alt="avatar" /></p>
                        <p>Name : {{ $user->name }}</p>
                        <p>Email : {{ $user->email }}</p>
                        <h5 class="mt-5 mb-3  text-center">Please type your OTP , what were sent to your email! then
                            click the button below.</h5>

                        <small class=" mb-2 text-center">Remember that your OTP will expire at <strong
                                v-text="formatDate(`{{ $expire_time }}`)"></strong></small>
                        <p><input class="form-control" type="number" v-model="dataUser.otp" /></p>
                        <p> <button class="btn btn-success" v-on:click="openForm()">Continue</button></p>

                        <div class="row" v-if="setOpen">
                            <div class="col">
                                <p><input class="form-control" type="password" v-model="dataUser.new_password"
                                        placeholder="New Password" /></p>
                                <p><input class="form-control" type="password" v-model="dataUser.confirm_password"
                                        placeholder="Confirm Password" /></p>
                                <p>
                                    <button type="submit" class="btn btn-success"
                                        v-on:click="changePassowrd('{{ $token }}', '{{ $user->email }}')">
                                        Change Password
                                    </button>
                                </p>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
<script src="/assets/reset_password.js"></script>
</html>
