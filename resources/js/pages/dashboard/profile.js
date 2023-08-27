import HeaderComponent from '../../components/header-component.vue';
import LoaderComponent from '../../components/loader-component.vue';
import AlertComponent from '../../components/alert-component.vue';

export default new Vue({
    el: '#profile-page',
    data () {
        return {
            name: '',
            email: '',
            currentPassword: '',
            newPassword: '',
            confirmPassword: ''
        }
    },
    methods: {
        getData() {
            axios.get('/api/user/profile').then(response => {
                this.name = response.data.data.name;
                this.email = response.data.data.email;
            }).catch(error => console.log(error));
        },
        saveData(formType = null) {
            let data;

            if (formType === 'password') {
                data = {
                    'current_password': this.currentPassword,
                    'password': this.newPassword,
                    'password_confirmation': this.confirmPassword
                };
            } else {
                data = {
                    'name': this.name,
                    'email': this.email
                };
            }

            axios.put('/api/user/profile', data).then(response => {
                this.currentPassword = '';
                this.newPassword = '';
                this.confirmPassword = '';

                this.$refs.alert.showSuccess('Dados alterados com sucesso!');
            }).catch(error => {
                if (error.response.data.success === false) {
                    this.$refs.alert.showError(error.response.data.message)
                }
            });
        }
    },
    created() {
        this.getData();
    },
    updated() {
        this.$refs.loader.show = false;
    },
    components: {
        HeaderComponent,
        LoaderComponent,
        AlertComponent
    }
});
