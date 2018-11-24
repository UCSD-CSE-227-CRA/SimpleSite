/**
 * Update the next token according to raw token and secret
 */
function update_token(cookie) {
    let cookie_prefix = localStorage.getItem("simple_site_cookie_prefix");
    let secret = localStorage.getItem("simple_site_secret");
    const secret_matches = new RegExp("([0-9a-zA-Z_]+)secret=([0-9a-zA-Z]+)").exec(cookie);
    if (secret_matches !== null) {
        cookie_prefix = secret_matches[1];
        secret = secret_matches[2];
        localStorage.setItem("simple_site_cookie_prefix", cookie_prefix);
        localStorage.setItem("simple_site_secret", secret);
        delete_cookie(cookie_prefix + "secret");
    } else if (secret === null) {
        console.log("No secret found, user not logged in");
    }

    if (secret !== null) {
        const raw_token_matches = new RegExp(cookie_prefix + "raw_token=([0-9a-zA-Z]+)").exec(cookie);
        if (raw_token_matches !== null) {
            const raw_token = raw_token_matches[1];
            delete_cookie(cookie_prefix + "raw_token");
            set_cookie(cookie_prefix + "token", md5(secret + raw_token));
        } else {
            const token_matches = new RegExp(cookie_prefix + "token=([0-9a-zA-Z]+)").exec(cookie);
            if (token_matches === null) {
                console.error("No token found");
            }
        }
    }
}

let current_cookie = document.cookie;
update_token(current_cookie);
// Loop forever to listen to cookie changes
setInterval(function () {
    if (current_cookie !== document.cookie) {
        current_cookie = document.cookie;
        update_token(current_cookie);
    }
}, 100);
