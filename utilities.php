<?php

require_once 'commons.php';

define('SIMPLE_SITE_COOKIE_PREFIX', 'simplesite');

/**
 * Generate the URL for file at a given path
 * @param $path string file path relative to server root
 * @return string URL
 */
function url_for_path($path) {
    return (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://" . SIMPLE_SITE_ROOT_URL . $path;
}

/**
 * Print the HTML head and body label
 * @param string $title
 */
function print_header($title = "Simple Web") {
    $utilities_path = url_for_path("utilities.js");
    $styles_path = url_for_path("styles.css");
    echo "<!DOCTYPE html>
<html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>
    <title>${title}</title>
    <script src=${utilities_path}></script>
    <link rel='stylesheet' href=${styles_path}>
</head>
<body>";
}


/**
 * Complete the HTML document
 * @see print_header()
 */
function print_footer() {
    echo "</body>
</html>
";
}

/**
 * Make an POST request to call the API
 * @param $name string API name
 * @param $params array Request additional parameters
 * @return array API call result
 */
function call_api($name, $params = null) {
    $request_params = array_merge($params ? $params : [], $_POST);
    // Strip cookie prefix
    foreach ($_COOKIE as $key => $value) {
        $request_params[str_replace(SIMPLE_SITE_COOKIE_PREFIX . '_', '', $key)] = $value;
    }

    $url = url_for_path("api/${name}.php");

    $options = ['http' => [
        'method' => 'POST',
        'content' => http_build_query($request_params),
    ],
    ];
    $raw_result = file_get_contents($url, false, stream_context_create($options));

    return json_decode($raw_result, true);
}

/**
 * Call func if result is a success API call
 * @param $result array API call result
 * @param $func callable Function to be called
 * @see call_api()
 */
function do_when_success($result, $func) {
    if ($result['code'] == 0) {
        if (is_callable($func)) {
            $func($result['data']);
        }
    }
}

/**
 * Call func if result is a failed API call
 * @param $result array API call result
 * @param $func callable Function to be called
 * @see call_api()
 */
function do_when_fail($result, $func) {
    if ($result['code'] != 0) {
        if (is_callable($func)) {
            $func($result['code'], $result['message']);
        }
    }
}

/**
 * Sets a cookie of the given name with the specified data for the given length of time.
 * If no time is specified, a session cookie will be set.
 *
 * @param string $name Name of the cookie, will be automatically prefixed with SIMPLE_SITE_COOKIE_PREFIX
 * @param string $cookiedata The data to hold within the cookie
 * @param int $cookietime The expiration time as UNIX timestamp. If 0 is provided, a session cookie is set.
 * @param bool $httponly Use HttpOnly. Defaults to true.
 */
function set_cookie($name, $cookiedata, $cookietime, $httponly = true) {
    $name_data = SIMPLE_SITE_COOKIE_PREFIX . '_' . $name . '=' . $cookiedata;
    $expire = gmdate('D, d-M-Y H:i:s \\G\\M\\T', $cookietime);
    header('Set-Cookie: ' . $name_data .
        (($cookietime) ? '; expires=' . $expire : '') . ';' .
        '; path=/ ;' .
        (($httponly) ? ' HttpOnly' : ''), false);
}
