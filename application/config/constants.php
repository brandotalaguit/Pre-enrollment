<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/*
|---------------------------------------------------------------------------
| User Defined Constant
|---------------------------------------------------------------------------
*/

define('FIVE_HUNDRED'		,	500);
define('SEVEN_HUNDRED'		,	700);
define('ONE_THOUSAND'		,	1000);
define('TWO_THOUSAND'		,	2000);
define('THREE_THOUSAND'		,	3000);
define('ONE_THOUSAND_FIVE'	,	1500);
define('TWO_THOUSAND_FIVE'	,	2500);

define('DECIMAL_PLACES'	,	2);
define('LANDBANK_OTC'	,	2);
define('LANDBANK_ATM'	,	1);
define('LANDBANK_MSC'	,	1);
define('LANDBANK_TKN'	,	2);
define('TUITION_FEE'	,	10000);

if (ENVIRONMENT == 'production')
{
define('DBHSU', 'umakunil_hsu_enrollment.');
define('DBTASC', 'umakunil_new_hsu_database.');
define('DBFE', 'umakunil_feval.');
}

if (ENVIRONMENT == 'development')
{
define('DBHSU', 'umaktest_hsu_enrollment.');
define('DBTASC', 'umaktest_new_hsu_database.');
define('DBFE', 'umaktest_feval.');
}



/* End of file constants.php */
/* Location: ./application/config/constants.php */