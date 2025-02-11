new Vue({
    el: '#app',
    data: {
        setOpen: false,
        success: '',
        error: '',
        dataUser: {
            otp: 0,
            email: '',
            new_password: '',
            confirm_password: '',
        },
    },
    methods: {
        formatDate(datetime) {
            const input = datetime
            const dateObj = new Date(input)
            const year = dateObj.getFullYear()
            const month = (dateObj.getMonth() + 1).toString().padStart(2, '0')
            const date = dateObj.getDate().toString().padStart(2, '0')
            const hours = dateObj.getHours().toString().padStart(2, '0')
            const minutes = dateObj.getMinutes().toString().padStart(2, '0')
            const seconds = dateObj.getSeconds().toString().padStart(2, '0')
            return `${date}/${month}/${year} - ${hours}:${minutes}:${seconds}`
            return result
        },
        changePassowrd(token, email) {
            if (this.dataUser.new_password !== this.dataUser.confirm_password) {
                this.error = 'Passowrd is not match'
                return
            }
            this.dataUser.email = email

            axios.put('http://127.0.0.1:8000/api/auth/reset-password?token=' + token, this.dataUser)
                .then((res) => {
                    if (res.data.status === 201) {
                        this.success = res.data.message
                        setTimeout(() => {
                            window.location.href = 'http://localhost:3000/login'
                        }, 1000)
                    }
                })
                .catch((error) => {
                    if (error.response.status === 410) {
                        this.error = error.response.data.message
                        setTimeout(() => {
                            window.location.href = 'http://localhost:3000/reset-password'
                        }, 1000)
                    } else {
                        this.error = error.response.data.message
                    }
                })
        },
        openForm() {
            if (this.dataUser.otp.length !== 6) {
                this.error = 'OTP must be exactly 6 digits.'
                return
            }
            this.setOpen = true
        }
    },
})
