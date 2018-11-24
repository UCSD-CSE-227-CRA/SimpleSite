# API Documents

## Overall

* All requests should be made via `HTTP POST`, and the response data is in JSON format
* In response data, field `code` equals 0 means request success, the data is in `data` field
* In data field, if user is logged in, there will always be a `raw_token` field, see log in section
* Otherwise (`code` != 0) there will be a corresponding `message` field

These negative code values have fixed meaning:

* -1: Missing parameter
* -2: Illegal parameter
* -3: Not logged in
* -100: Server error

## Register

### URL

* `api/register.php`

### Parameters:

* `name`: User name, length between [3, 32]
* `password`: MD5 encrypted user password
* `sex`: User sex, can be 'male', 'female' or empty
* `email`: User email

### Returns:

* Empty

## Log in

### URL

* `api/login.php`

### Parameters:

* `name`: User name or email
* `password`: User password

### Returns:

* `sid`: Session ID, used for future authentication
* `secret` & `raw_token`: Session secret and raw token. Set `token = MD5(secret + raw_token)` for future authentication

## Log out

### URL

* `api/logout.php`

### Parameters:

* `sid` & `token`: Session ID and token, see log in section

### Returns:

* Empty

## Get user info

### URL

* `api/user_info.php`

### Parameters:

* `sid` & `token`: Session ID and token, see log in section
* `name`: Optional, default to view self

### Returns:

* `name`: User name
* `sex`: User sex
* `email`: User email, only visible when viewing self
