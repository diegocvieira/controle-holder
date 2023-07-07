import HeaderComponent from '../components/header-component.vue';
import AlertMessageComponent from '../components/alert-message-component.vue';

export default new Vue({
    el: '#login-page',
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
                this.$refs.alertMessage.type = 'error';
                this.$refs.alertMessage.message = error.response.data.message;
                this.$refs.alertMessage.show = true;
            }).then(() => {
                this.submitButtonIsDisabled = false;
            });
        },
        validateFields() {
            if (!this.email || !this.password) {
                this.$refs.alertMessage.type = 'warning';
                this.$refs.alertMessage.message = 'Preencha todos os campos.';
                this.$refs.alertMessage.show = true;

                return false;
            }

            return true;
        }
    },
    components: {
        HeaderComponent,
        AlertMessageComponent
    }
});
