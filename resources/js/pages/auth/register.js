export default {
    data () {
        return {
            name: '',
            email: '',
            password: '',
            passwordConfirmation: '',
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
                name: this.name,
                email: this.email,
                password: this.password,
                password_confirmation: this.passwordConfirmation
            };

            axios.post('/api/auth/register', data).then(response => {
                window.open('/dashboard', '_self');
            }).catch(error => {
                this.$refs.alert.showError(error.response.data.message);
            }).then(() => {
                this.submitButtonIsDisabled = false;
            });
        },
        validateFields() {
            if (!this.name || !this.email || !this.password || !this.passwordConfirmation) {
                this.$refs.alert.showWarning('Preencha todos os campos.');
                return false;
            }

            return true;
        }
    }
};
