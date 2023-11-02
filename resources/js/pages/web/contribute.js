export default {
    data() {
        return {}
    },
    methods: {
        copyToClipboard(text) {
            const spanElement = event.currentTarget.querySelector('span');
            const buttonText = spanElement.textContent;

            spanElement.textContent = 'Copiado';

            this.$copyToClipboard(text);

            setTimeout(() => {
                spanElement.textContent = buttonText;
            }, 2000);
        }
    }
};
