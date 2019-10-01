import Modal from "./Modal";

export const initLoginEvent = (loader) => {
    const selectorConnect = document.querySelector('#connect');
    selectorConnect.addEventListener('click', function (e) {
        e.preventDefault();
        const modal = new Modal();
        let uri = selectorConnect.attributes.href.value;
        loader.show();
        $.ajax({
            method: "GET",
            url: uri,
            success: function (response) {
                modal.html('basic-modal', response.html);
                loader.hide();
                modal.toggle('basic-modal');
            },
            error: function (response) {
                console.log(response);
                modal.html('basic-modal', response.html);
                loader.hide();
            }
        });
    });
};
