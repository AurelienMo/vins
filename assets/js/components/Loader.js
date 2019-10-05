export const show = () => {
    document.getElementById('loading-overlay').classList.add('is-active');
};

export const hide = () => {
    document.getElementById('loading-overlay').classList.remove('is-active');
};
