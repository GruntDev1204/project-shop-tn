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
    <style>
        .container {
            cursor: pointer;
        }

        img {
            height: 200px;
            width: 200px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="container mt-5" id="app">
        <div class="row">
            <div class="col">
                <div class="alert alert-info ">
                    <h3 class="text-center mb-5 mt-5">Change User Password <i class="fas fa-lock"></i></h3>
                    <p>Hi , {{ $user->email }}</p>
                    <p>This is your infomation : </p>
                    <div class="alert alert-success ">
                        <p class="text-center"><img src={{ $user->avatar }} alt="avatar" /></p>
                        <p>Name : {{ $user->name }}</p>
                        <p>Email : {{ $user->email }}</p>
                        <h5 class="mt-2 mb-2 text-center">Please type your otp , what were sent to your email! then
                            click the button below.</h5>
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
<script>
    new Vue({
        el: '#app',
        data: {
            setOpen: false,
            dataUser: {
                otp: 0,
                email: '',
                new_password: '',
                confirm_password: '',
            },
        },
        methods: {
            formatDate(datetime) {
                const input = datetime;
                const dateObj = new Date(input);
                const year = dateObj.getFullYear();
                const month = (dateObj.getMonth() + 1).toString().padStart(2, '0');
                const date = dateObj.getDate().toString().padStart(2, '0');
                const hours = dateObj.getHours().toString().padStart(2, '0');
                const minutes = dateObj.getMinutes().toString().padStart(2, '0');
                const seconds = dateObj.getSeconds().toString().padStart(2, '0');
                const result = `date/month/year - hours:minutes:seconds`;
                return result;
            },
            changePassowrd(token, email) {
                if (this.dataUser.new_password !== this.dataUser.confirm_password) {
                    alert('password not match')
                    return
                }
                this.dataUser.email = email

                axios.put('http://127.0.0.1:8000/api/auth/reset-password?token=' + token, this.dataUser)
                    .then((res) => {
                        if (res.data.status === 201) {
                            alert(res.data.message)
                            setTimeout(() => {
                                window.location.href = 'http://localhost:3000/login';
                            }, 1000);
                        }
                    })
                    .catch((error) => {
                        alert(error.message)
                    })
            },
            openForm() {
                if (this.dataUser.otp.length !== 6) {
                    alert("OTP is not available");
                    return;
                }
                this.setOpen = true
            }

        },
    })
</script>

</html>
