// export default class APIResolver {
//     headers = {
//         'X-Requested-With': 'xmlhttprequest',
//     };
//
//     send = async () => {
//
//     };
// }

export const send = async (uri, method, body, queryparams) => {
    let response = await fetch(
        uri,
        {
            method: method,
            // headers: this.headers,
            // body: body
        });

    return await response.json();
};
