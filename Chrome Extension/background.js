let logged_in = false;

/**
 * Set the extension's state as logged in
 */
function set_logged_in() {
    if (!logged_in) {
        chrome.browserAction.setIcon({path: "images/lock_green.png"});
        chrome.browserAction.setTitle({title: "You are logged in"});
        logged_in = true;
    }
}

/**
 * Set the extension's state as not logged in
 */
function set_not_logged_in() {
    if (logged_in) {
        localStorage.removeItem("secret");
        localStorage.removeItem("raw_token");

        chrome.browserAction.setIcon({path: "images/lock_black.png"});
        chrome.browserAction.setTitle({title: "You are not logged in"});
        logged_in = false;
    }
}

// Grab and store header at completion of each main frame request
chrome.webRequest.onCompleted.addListener(function (details) {
    let logged_in = false;
    details.responseHeaders.forEach(function (header) {
        if (header.name === "Secret") {
            localStorage.setItem("secret", header.value);
            logged_in = true;
        }
        if (header.name === "Raw-Token") {
            localStorage.setItem("raw_token", header.value);
            logged_in = true;
        }
    });

    if (logged_in) {
        set_logged_in();
    } else {
        set_not_logged_in()
    }
}, {
    urls: [root_url + "*"],
    types: ["main_frame"]
}, ["responseHeaders"]);

// Set token for authentication
// Hash the URL for defense against MITM attack
chrome.webRequest.onBeforeSendHeaders.addListener(function(details) {
    const secret = localStorage.getItem("secret");
    const raw_token = localStorage.getItem("raw_token");
    if (secret && secret.length > 0 && raw_token && raw_token.length > 0) {
        const token = sha256(secret + raw_token).toUpperCase();
        const url_encrypted = sha256(secret + token + details.url).toUpperCase();
        details.requestHeaders.push({name: "Token", value: token});
        details.requestHeaders.push({name: "URL-Encrypted", value: url_encrypted});
    }
    return {requestHeaders: details.requestHeaders};
}, {
    urls: [root_url + "*"],
    types: ["main_frame"]
}, ["blocking", "requestHeaders"]);
