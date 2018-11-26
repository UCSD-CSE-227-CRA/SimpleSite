<?php

require_once 'commons.php';

/** Cookie prefix on client browser. No need to change it. */
define('SIMPLE_SITE_COOKIE_PREFIX', 'simplesite_');

$GLOBALS['url_prefix'] = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://" . SIMPLE_SITE_ROOT_URL;

/**
 * Generate the URL for file at a given path
 * @param $path string file path relative to server root
 * @return string URL
 */
function url_for_path($path) {
    return $GLOBALS['url_prefix'] . $path;
}

$GLOBALS['urls'] = [
    'main' => url_for_path(''),
    'register' => url_for_path('register'),
    'login' => url_for_path('login'),
    'logout' => url_for_path('logout'),
    'view_profile' => url_for_path('view_profile'),
];

/**
 * Print the HTML head and body label
 * @param string $title
 */
function print_header($title = "Simple Web") {
    $utilities_path = url_for_path("utilities.js");
    $auth_path = url_for_path("auth.js");
    $styles_path = url_for_path("styles.css");
    echo "<!DOCTYPE html>
<html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>
    <title>${title}</title>
    <script src=${utilities_path}></script>
    <script src=${auth_path}></script>
    <script>update_token()</script>
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
 * Since this function might set the cookie header, it should be called before printing anything
 * @param $name string API name
 * @param $params array Request additional parameters
 * @return array API call result
 */
function call_api($name, $params = null) {
    $request_params = array_merge($params ? $params : [], $_POST);
    // Strip cookie prefix
    foreach ($_COOKIE as $key => $value) {
        if (preg_match('/^' . SIMPLE_SITE_COOKIE_PREFIX . '/', $key)) {
            $request_params[str_replace(SIMPLE_SITE_COOKIE_PREFIX, '', $key)] = $value;
        }
    }

    $url = url_for_path("api/${name}.php");

    $options = ['http' => [
        'method' => 'POST',
        'content' => http_build_query($request_params),
    ],
    ];
    $raw_result = file_get_contents($url, false, stream_context_create($options));

    $result = json_decode($raw_result, true);
    do_when_success($result, function ($data) {
        if ($data['raw_token']) {
            set_cookie('raw_token', $data['raw_token'], 0, false);
        }
    });
    return $result;
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
 * Wrapper function of PHP setcookie() to set a cookie
 *
 * @param string $name Name of the cookie, will be automatically prefixed with SIMPLE_SITE_COOKIE_PREFIX
 * @param string $value Value of the cookie
 * @param int $expire The expiration time as UNIX timestamp.
 * @param bool $httponly Use HttpOnly. Defaults to true.
 * @see setcookie()
 */
function set_cookie($name, $value, $expire, $httponly = true) {
    $real_name = SIMPLE_SITE_COOKIE_PREFIX . $name;
    setcookie($real_name, $value, $expire, '/', null, null, $httponly);
}

/**
 * Delete a cookie
 *
 * @param string $name Name of the cookie
 * @see set_cookie()
 */
function delete_cookie($name) {
    set_cookie($name, '', time() - 3600);
}
