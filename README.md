# SimpleSite

A simple website to demonstrate defense methods against cookie replay attack

## Environment

* LAMP or WAMP
* Apache version: 2.4+
* MySQL version: 8.0+
* PHP version: 5.5+

## Installation

**Please replace text in \`\` with your own content**

* Create database and user in MySQL, grant privileges
  * ```CREATE DATABASE `databasename` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;```
  * ```CREATE USER '`username`'@'localhost' IDENTIFIED BY '`password`';```
  * ```GRANT ALL ON `databasename`.* TO '`username`'@'localhost';```
  * ```FLUSH PRIVILEGES;```
  
* Initialize database
  * ```USE '`databasename`';```
  * ```SOURCE initialize.sql;```
  
* In root directory, copy `config.sample.php` as `config.php`
* Modify `config.php`, add root URL, MySQL \`databasename\`, \`username\` and \`password\`
* Also modify the root URL in `Chrome Extension/config.js` and `Chrome Extension/Manifest.json`
* Run `db_connect_test.php` in the browser to check database configuration
* Install the Chrome Extension ([Instructions](https://developer.chrome.com/extensions/getstarted))
* You're all set!
