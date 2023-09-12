export default {
    data () {
        return {
            email: '',
            password: '',
            submitButtonIsDisabled: false
        }
    },
    methods: {
        formSubmit() {
            if (!this.validateFields()) {
                return false;
            }

            this.submitButtonIsDisabled = true;

            const data = {
                email: this.email,
                password: this.password
            };

            axios.post('/api/auth/login', data).then(response => {
                window.open('/dashboard', '_self');
            }).catch(error => {
                this.$refs.alert.showError(error.response.data.message);
            }).then(() => {
                this.submitButtonIsDisabled = false;
            });
        },
        validateFields() {
            if (!this.email || !this.password) {
                this.$refs.alert.showWarning('Preencha todos os campos.');
                return false;
            }

            return true;
        }
    }
};
