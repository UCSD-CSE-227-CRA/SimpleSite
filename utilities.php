<?php

require_once 'config.php';

/**
 * Print the HTML head and body label
 * @param string $title
 */
function print_header($title = "Simple Web") {
    $protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
    $utilities_path = "${protocol}://" . SIMPLE_SITE_ROOT_URL . "utilities.js";
    echo "<!DOCTYPE html>
<html>
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
    <title>${title}</title>
    <script src=${utilities_path}></script>
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
 * @param $on_success callable Callback when it succeeds
 * @param $on_error callable Callback when it fails
 * @return array API call result
 */
function call_api($name, $params = null, $on_success = null, $on_error = null) {
    $request_params = array_merge($params ? $params : [], $_REQUEST);

    $protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
    $url = "${protocol}://" . SIMPLE_SITE_ROOT_URL . "api/${name}.php";

    $options = array('http' => array(
        'method' => 'POST',
        'content' => http_build_query($request_params),
    ),
    );
    $raw_result = file_get_contents($url, false, stream_context_create($options));

    $result = json_decode($raw_result, true);
    if ($result['code'] == 0) {
        if (is_callable($on_success)) {
            $on_success($result['data']);
        }
    } else {
        if (is_callable($on_error)) {
            $on_error($result['code'], $result['message']);
        }
    }
    return $result;
}