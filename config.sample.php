<?php
/**
 * Configuration for Simple Site.
 *
 * You need to copy this file to `config.php` to make it work.
 *
 * This file contains the following configrations:
 *
 * - MySQL settings.
 *
 * Reference:
 * - https://github.com/WordPress/WordPress/blob/master/wp-config-sample.php
 */

//** Server settings. **//

/** The server root URL */
define('SIMPLE_SITE_ROOT_URL', 'localhost/SimpleSite/');
 
//** MySQL settings. **//

/** The database username. */
define('SIMPLE_SITE_DB_USERNAME', 'database_username_here');

/** The database password. */
define('SIMPLE_SITE_DB_PASSWORD', 'database_password_here');

/** The database name. */
define('SIMPLE_SITE_DB_NAME', 'database_name_here');

/** The database hostname. */
define('SIMPLE_SITE_DB_HOSTNAME', '127.0.0.1');

//** Debug settings. **//

/** Whether server should report errors. */
define('SIMPLE_SITE_REPORT_ERRORS', true);
