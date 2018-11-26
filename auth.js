/**
 * Update the next token according to raw token and secret
 */
function update_token() {
    let cookie_prefix = localStorage.getItem("simplesite_cookie_prefix");
    let secret = localStorage.getItem("simplesite_secret");
    const secret_matches = new RegExp("([0-9a-zA-Z_]+)secret=([0-9a-zA-Z]+)").exec(document.cookie);
    if (secret_matches !== null) {
        cookie_prefix = secret_matches[1];
        secret = secret_matches[2];
        localStorage.setItem("simplesite_cookie_prefix", cookie_prefix);
        localStorage.setItem("simplesite_secret", secret);
        delete_cookie(cookie_prefix + "secret");
    } else if (secret === null) {
        console.log("No secret found, user not logged in");
    }

    if (secret !== null) {
        const raw_token_matches = new RegExp(cookie_prefix + "raw_token=([0-9a-zA-Z]+)").exec(document.cookie);
        if (raw_token_matches !== null) {
            const raw_token = raw_token_matches[1];
            delete_cookie(cookie_prefix + "raw_token");
            set_cookie(cookie_prefix + "token", md5(secret + raw_token));
        } else {
            const token_matches = new RegExp(cookie_prefix + "token=([0-9a-zA-Z]+)").exec(document.cookie);
            if (token_matches === null) {
                console.error("No token found");
            }
        }
    }
}

/**
 * Delete cookie and local storage related to authentication. Use to log out
 */
function delete_token() {
    let cookie_prefix = localStorage.getItem("simplesite_cookie_prefix");
    localStorage.removeItem("simplesite_cookie_prefix");
    localStorage.removeItem("simplesite_secret");
    delete_cookie(cookie_prefix + "token");
}
