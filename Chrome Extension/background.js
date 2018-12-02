/**
 * Take a string and return the hex representation of its MD5.
 * @param str Input string
 * @returns MD5 hex result
 */
function md5(str) {
    /**
     * Convert a 32-bit number to a hex string with ls-byte first
     */
    function rhex(num) {
        const hex_chr = "0123456789abcdef";
        let str = "";
        for (let j = 0; j <= 3; j++) {
            str += hex_chr.charAt((num >> (j * 8 + 4)) & 0x0F) + hex_chr.charAt((num >> (j * 8)) & 0x0F);
        }
        return str;
    }

    /**
     * Convert a string to a sequence of 16-word blocks, stored as an array.
     * Append padding bits and the length, as described in the MD5 standard.
     */
    function str2blks_md5(str) {
        const len = str.length;
        const nblk = ((len + 8) >> 6) + 1;
        const blks = new Array(nblk * 16);
        for (let i = 0; i < nblk * 16; i++) {
            blks[i] = 0;
        }
        for (let i = 0; i < len; i++) {
            blks[i >> 2] |= str.charCodeAt(i) << ((i % 4) * 8);
        }
        blks[len >> 2] |= 0x80 << ((len % 4) * 8);
        blks[nblk * 16 - 2] = len * 8;
        return blks;
    }

    /**
     * Add integers, wrapping at 2^32. This uses 16-bit operations internally
     * to work around bugs in some JS interpreters.
     */
    function add(x, y) {
        const lsw = (x & 0xFFFF) + (y & 0xFFFF);
        const msw = (x >> 16) + (y >> 16) + (lsw >> 16);
        return (msw << 16) | (lsw & 0xFFFF);
    }

    /**
     * Bitwise rotate a 32-bit number to the left
     */
    function rol(num, cnt) {
        return (num << cnt) | (num >>> (32 - cnt));
    }

    /**
     * These functions implement the basic operation for each round of the
     * algorithm.
     */
    function cmn(q, a, b, x, s, t) {
        return add(rol(add(add(a, q), add(x, t)), s), b);
    }

    function ff(a, b, c, d, x, s, t) {
        return cmn((b & c) | ((~b) & d), a, b, x, s, t);
    }

    function gg(a, b, c, d, x, s, t) {
        return cmn((b & d) | (c & (~d)), a, b, x, s, t);
    }

    function hh(a, b, c, d, x, s, t) {
        return cmn(b ^ c ^ d, a, b, x, s, t);
    }

    function ii(a, b, c, d, x, s, t) {
        return cmn(c ^ (b | (~d)), a, b, x, s, t);
    }

    const x = str2blks_md5(str);
    let a =  1732584193;
    let b = -271733879;
    let c = -1732584194;
    let d =  271733878;

    for (let i = 0; i < x.length; i += 16) {
        let olda = a;
        let oldb = b;
        let oldc = c;
        let oldd = d;

        a = ff(a, b, c, d, x[i+ 0], 7 , -680876936);
        d = ff(d, a, b, c, x[i+ 1], 12, -389564586);
        c = ff(c, d, a, b, x[i+ 2], 17,  606105819);
        b = ff(b, c, d, a, x[i+ 3], 22, -1044525330);
        a = ff(a, b, c, d, x[i+ 4], 7 , -176418897);
        d = ff(d, a, b, c, x[i+ 5], 12,  1200080426);
        c = ff(c, d, a, b, x[i+ 6], 17, -1473231341);
        b = ff(b, c, d, a, x[i+ 7], 22, -45705983);
        a = ff(a, b, c, d, x[i+ 8], 7 ,  1770035416);
        d = ff(d, a, b, c, x[i+ 9], 12, -1958414417);
        c = ff(c, d, a, b, x[i+10], 17, -42063);
        b = ff(b, c, d, a, x[i+11], 22, -1990404162);
        a = ff(a, b, c, d, x[i+12], 7 ,  1804603682);
        d = ff(d, a, b, c, x[i+13], 12, -40341101);
        c = ff(c, d, a, b, x[i+14], 17, -1502002290);
        b = ff(b, c, d, a, x[i+15], 22,  1236535329);

        a = gg(a, b, c, d, x[i+ 1], 5 , -165796510);
        d = gg(d, a, b, c, x[i+ 6], 9 , -1069501632);
        c = gg(c, d, a, b, x[i+11], 14,  643717713);
        b = gg(b, c, d, a, x[i+ 0], 20, -373897302);
        a = gg(a, b, c, d, x[i+ 5], 5 , -701558691);
        d = gg(d, a, b, c, x[i+10], 9 ,  38016083);
        c = gg(c, d, a, b, x[i+15], 14, -660478335);
        b = gg(b, c, d, a, x[i+ 4], 20, -405537848);
        a = gg(a, b, c, d, x[i+ 9], 5 ,  568446438);
        d = gg(d, a, b, c, x[i+14], 9 , -1019803690);
        c = gg(c, d, a, b, x[i+ 3], 14, -187363961);
        b = gg(b, c, d, a, x[i+ 8], 20,  1163531501);
        a = gg(a, b, c, d, x[i+13], 5 , -1444681467);
        d = gg(d, a, b, c, x[i+ 2], 9 , -51403784);
        c = gg(c, d, a, b, x[i+ 7], 14,  1735328473);
        b = gg(b, c, d, a, x[i+12], 20, -1926607734);

        a = hh(a, b, c, d, x[i+ 5], 4 , -378558);
        d = hh(d, a, b, c, x[i+ 8], 11, -2022574463);
        c = hh(c, d, a, b, x[i+11], 16,  1839030562);
        b = hh(b, c, d, a, x[i+14], 23, -35309556);
        a = hh(a, b, c, d, x[i+ 1], 4 , -1530992060);
        d = hh(d, a, b, c, x[i+ 4], 11,  1272893353);
        c = hh(c, d, a, b, x[i+ 7], 16, -155497632);
        b = hh(b, c, d, a, x[i+10], 23, -1094730640);
        a = hh(a, b, c, d, x[i+13], 4 ,  681279174);
        d = hh(d, a, b, c, x[i+ 0], 11, -358537222);
        c = hh(c, d, a, b, x[i+ 3], 16, -722521979);
        b = hh(b, c, d, a, x[i+ 6], 23,  76029189);
        a = hh(a, b, c, d, x[i+ 9], 4 , -640364487);
        d = hh(d, a, b, c, x[i+12], 11, -421815835);
        c = hh(c, d, a, b, x[i+15], 16,  530742520);
        b = hh(b, c, d, a, x[i+ 2], 23, -995338651);

        a = ii(a, b, c, d, x[i+ 0], 6 , -198630844);
        d = ii(d, a, b, c, x[i+ 7], 10,  1126891415);
        c = ii(c, d, a, b, x[i+14], 15, -1416354905);
        b = ii(b, c, d, a, x[i+ 5], 21, -57434055);
        a = ii(a, b, c, d, x[i+12], 6 ,  1700485571);
        d = ii(d, a, b, c, x[i+ 3], 10, -1894986606);
        c = ii(c, d, a, b, x[i+10], 15, -1051523);
        b = ii(b, c, d, a, x[i+ 1], 21, -2054922799);
        a = ii(a, b, c, d, x[i+ 8], 6 ,  1873313359);
        d = ii(d, a, b, c, x[i+15], 10, -30611744);
        c = ii(c, d, a, b, x[i+ 6], 15, -1560198380);
        b = ii(b, c, d, a, x[i+13], 21,  1309151649);
        a = ii(a, b, c, d, x[i+ 4], 6 , -145523070);
        d = ii(d, a, b, c, x[i+11], 10, -1120210379);
        c = ii(c, d, a, b, x[i+ 2], 15,  718787259);
        b = ii(b, c, d, a, x[i+ 9], 21, -343485551);

        a = add(a, olda);
        b = add(b, oldb);
        c = add(c, oldc);
        d = add(d, oldd);
    }
    return rhex(a) + rhex(b) + rhex(c) + rhex(d);
}

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
        chrome.cookies.remove({url: root_url, name: cookie_prefix + "sid"});

        chrome.browserAction.setIcon({path: "images/lock_black.png"});
        chrome.browserAction.setTitle({title: "You are not logged in"});
        logged_in = false;
    }
}

/**
 * Store the raw token and secret (if exists) and remove them from cookie
 * @param raw_token The raw token
 */
function store_token(raw_token) {
    localStorage.setItem("raw_token", raw_token);
    chrome.cookies.remove({url: root_url, name: cookie_prefix + "raw_token"});

    chrome.cookies.get({url: root_url, name: cookie_prefix + "secret"}, function (cookie) {
        if (!cookie && !localStorage.getItem("secret")) {
            set_not_logged_in();
            console.log("No secret found, user not logged in");
            return;
        }
        if (cookie) {
            localStorage.setItem("secret", cookie.value);
            chrome.cookies.remove({url: root_url, name: cookie_prefix + "secret"});

        }
        set_logged_in();
    });
}

// Grab and store cookie at completion of each main frame request
chrome.webRequest.onCompleted.addListener(function () {
    chrome.cookies.get({url: root_url, name: cookie_prefix + "raw_token"}, function (cookie) {
        if (cookie) {
            store_token(cookie.value);
        } else {
            set_not_logged_in();
        }
    });
}, {
    urls: [root_url + "/*"],
    types: ["main_frame"]
});

// Hash the URL and put it in header for better defense against MITM attack
chrome.webRequest.onBeforeSendHeaders.addListener(function(details) {
    const secret = localStorage.getItem("secret");
    const raw_token = localStorage.getItem("raw_token");
    if (secret && secret.length > 0 && raw_token && raw_token.length > 0) {
        const token = md5(secret + raw_token);
        const encrypted_url = md5(secret + token + details.url);
        details.requestHeaders.push({name: "Token", value: token});
        details.requestHeaders.push({name: "URL-Encrypted", value: encrypted_url});
    }
    return {requestHeaders: details.requestHeaders};
}, {
    urls: [root_url + "/*"],
    types: ["main_frame"]
}, ["blocking", "requestHeaders"]);
