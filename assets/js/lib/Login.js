


const LoginApp = new Vue({
    'el': "#loginbox",
    data: {
        username: "",
        password: "",
        error: "",
        success: ""
    },
    methods: {
        doLogin() {
            $.post('/user/login', {
                username: this.username,
                password: this.password
            }, null, 'json').then(r => {
                var d = r.data;
                this.success = d.success;
                window.location.href = '/dashboard';
            }, err => {
                console.log(err);
                this.error = err.responseJSON.data.error;
            });
        }
    },
    computed: {
        block() {
            return !this.username || !this.password;
        }
    }
});
