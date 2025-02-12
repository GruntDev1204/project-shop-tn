new Vue({
    el: '#app',
    data: {
        setOpen: false,
        success: '',
        error: '',
        otp: 0
    },
    methods: {
        changePassowrd(hash) {
            axios.put('http://127.0.0.1:8000/api/users/active/' + hash, {
                otp: this.otp
            })
                .then((res) => {
                    this.success = res.data.message
                    setTimeout(() => {
                        window.location.href = 'http://localhost:3000/profile';
                    }, 1000)
                })
                .catch((error) => {
                    this.error = error.response.data.message
                })
        },
    },
})
