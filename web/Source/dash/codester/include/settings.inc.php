<?php
/**
* @project ApPHP WebsiteCleaner
* @copyright (c) 2014 ApPHP
* @author ApPHP <info@apphp.com>
* @license http://www.gnu.org/licenses/
*/

// Mode: production|demo
define('_MODE', 'production'); 

// PHP script running time 
define('_PHP_TIME_LIMIT', 60);

// The list of sub direcories that will be ignored while scanning
// example (test,photo,newfolder) etc...	
define('_IGNORED_SUB_DIRECTORIES', '');

// Cache files settings
define('_CACHE_FILE_EXTENSION', '.cch');
define('_CACHE_ALLOW_DELETING', true);

// Thumb files settings
define('_THUMB_ALLOW_DELETING', true);

// Errorlog files settings
define('_ERRORLOG_FILE_NAME', 'error_log');
define('_ERRORLOG_ALLOW_DELETING', true);

// Infected files settings
define('_INFECTED_SEARCH_STRING', 'eval(');
define('_INFECTED_REPLACE_STRING', '');
define('_INFECTED_ALLOW_DELETING', false);
define('_INFECTED_ALLOW_CLEANING', true);
$_INFECTED_ALLOWED_EXTENSIONS = array('.php', '.txt', '.htm', '.html', '.js', '.rar', '.zip');

// Last changed  files settings
define('_CHANGED_DIFF_HOURS', 24);
define('_CHANGED_IGNORE_CACHE_FILES', true);

// Set up current language: 'en' or 'ru' or anyelse
define('_CURRENT_LANGUAGE', 'en');

