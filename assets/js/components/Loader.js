export const showLoader = () => {
    document.getElementById('loading-overlay').classList.add('is-active');
};

export const hideLoader = () => {
    document.getElementById('loading-overlay').classList.remove('is-active');
};
