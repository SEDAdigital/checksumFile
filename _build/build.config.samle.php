<?php
/**
 * Define the MODX path constants necessary for core installation
 *
 * @package quip
 * @subpackage build
 */
define('MODX_BASE_PATH', dirname(__DIR__, 2) . '/modx/');
define('MODX_CORE_PATH', MODX_BASE_PATH . 'core/');
define('MODX_CONFIG_KEY','modx');

// Define package names
define('PKG_NAME', 'checksumFile');
define('PKG_NAME_LOWER', strtolower(PKG_NAME));
define('PKG_VERSION', '0.1.0');
define('PKG_RELEASE', 'release');
