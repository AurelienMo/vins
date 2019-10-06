export const send = async (uri, method, body, queryparams) => {
    let response = await fetch(
        uri,
        {
            method: method,
        });

    return await response.json();
};
