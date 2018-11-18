# API Documents

## Overall

* All requests should be done via HTTP POST, and the response data is in JSON format
* In response data, field `code` equals 0 means request success, the data is in `data` field
* Otherwise (`code` != 0) there will be a corresponding `message` field.

These negative code values have fixed meaning:

* -1: Missing parameter
* -2: Illegal parameter
* -3: Server error

## Register

### URL

* `api/register.php`

### Parameters:

* `name`: User name, length between [3, 32]
* `password`: MD5 encrypted user password
* `sex`: Sex, can be 'male', 'female' or empty
* `email`: Email

### Resturns:

* See login section
