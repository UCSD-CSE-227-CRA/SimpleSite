# API Documents

## Overall

* All requests should be made via `HTTP POST`, and the response data is in JSON format
* In response data, field `code` equals 0 means request success, the data is in `data` field
* In data field, if user is logged in, there will always be a `raw_token` field, see log in section
* Otherwise (`code` != 0) there will be a corresponding `message` field
* All sha256 result should be in upper case

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
* `password`: sha256 hashed user password
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
* `secret` & `raw_token`: Session secret and raw token. In the future:
    * Set `token = sha256(secret + raw_token)` for authentication
    * Set `info_encrypted = sha256(secret + token + info)` for authentication

## Log out

### URL

* `api/logout.php`

### Parameters:

* `sid` & `token` & `info` & `info_encrypted`: See log in section

### Returns:

* Empty

## View user profile

### URL

* `api/view_profile.php`

### Parameters:

* `sid` & `token` & `info` & `info_encrypted`: See log in section
* `name`: Optional, default to view self

### Returns:

* `name`: User name
* `sex`: User sex
* `email`: User email, only visible when viewing self
