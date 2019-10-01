export default class Loader {
    show = () => {
        document.getElementById('loading-overlay').classList.add('is-active');
    };

    hide = () => {
        document.getElementById('loading-overlay').classList.remove('is-active');
    };
}
