export default {
    install(app, options) {
        app.config.globalProperties.$copyToClipboard = function (text) {
            const element = document.createElement('textarea');
            element.value = text;
            element.setAttribute('readonly', '');
            element.style.position = 'absolute';
            element.style.left = '-9999px';

            document.body.appendChild(element);

            element.select();
            document.execCommand('copy');

            document.body.removeChild(element);
        }
    }
};
