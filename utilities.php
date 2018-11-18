<?php

/**
 * Make an POST request to call the API
 * @param $path string Relative path to API
 * @param $params array Request additional parameters
 * @param $on_success callable Callback when it succeeds
 * @param $on_error callable Callback when it fails
 * @return array API call result
 */
function call_api($path, $params = [], $on_success = null, $on_error = null) {
    $request_params = array_merge($params, $_REQUEST);

    $protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
    $current_dir = dirname($_SERVER['SCRIPT_NAME']);
    $url = "${protocol}://${_SERVER['SERVER_NAME']}:${_SERVER['SERVER_PORT']}${current_dir}/${path}";

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
