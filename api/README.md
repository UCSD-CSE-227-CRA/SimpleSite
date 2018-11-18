# API Documents

## Overall

* All requests should be made via `HTTP POST`, and the response data is in JSON format
* In response data, field `code` equals 0 means request success, the data is in `data` field
* Otherwise (`code` != 0) there will be a corresponding `message` field.

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

### Resturns:

* Empty

## Log in

### URL

* `api/login.php`

### Parameters:

* `name`: User name or email
* `password`: User password

### Resturns:

* `sid` Session ID, used for future authentication

## Log out

### URL

* `api/logout.php`

### Parameters:

* `sid`: Session ID

### Resturns:

* Empty

## Get user info

### URL

* `api/user_info.php`

### Parameters:

* `sid`: Session ID
* `name`: Optional, default to view self

### Resturns:

* `name`: User name
* `sex`: User sex
* `email`: User email, only visible when viewing self

