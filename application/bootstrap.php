<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/kohana/core'.EXT;

if (is_file(APPPATH.'classes/kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('America/Mexico_City');

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('es-mx');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
$domains = array('50.57.181.5', 'taktaktak');
Kohana::$environment = (in_array($_SERVER['SERVER_NAME'], $domains)) ? Kohana::PRODUCTION : Kohana::DEVELOPMENT;

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array(
	'base_url'   => '/',
	'index_file' => FALSE,
	'profile'    => FALSE,
	'caching'    => FALSE,
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	// 'auth'       => MODPATH.'auth',       // Basic authentication
	'cache'      => MODPATH.'cache',         // Caching with multiple backends
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	'database'   => MODPATH.'database',      // Database access
	'image'      => MODPATH.'image',         // Image manipulation
	// 'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	// 'unittest'   => MODPATH.'unittest',   // Unit testing
	// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
	'contento'   => MODPATH.'contento',
	'kohana-email'   => MODPATH.'kohana-email',
	'phpexcel'   => MODPATH.'phpexcel',
	));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
 
/**
 * Backend
 * Backend module is first to avoid 'pages' route handle it
 */
Route::set('backend', array('Controller_Backend_Template', 'routes'));
 
/**
 * Frontend
 */
 
Cookie::$salt = 'fdsR23rsf!5f235';
Cookie::$expiration = Date::YEAR;

Route::set('homepage', '(inicio)')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'homepage',
		'action'     => 'index',
	));
	
Route::set('juegos', 'juegos')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'game',
		'action'     => 'index',
	));

Route::set('detalle', 'detalle/<game>')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'game',
		'action'     => 'detalle',
	));

Route::set('jugar', 'jugar/<game>')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'game',
		'action'     => 'play',
	));
	
Route::set('resultado', 'resultado/<game>')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'game',
		'action'     => 'result',
	));

Route::set('api', 'api/<action>')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'api',
		'action'     => 'index',
	));

Route::set('contact', 'contacto')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'contact',
		'action'     => 'index',
	));

Route::set('login', 'login')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'register',
		'action'     => 'login',
	));
	
Route::set('logout', 'logout')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'register',
		'action'     => 'logout',
	));	

Route::set('registro', 'registro')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'register',
		'action'     => 'index',
	));
	
Route::set('registrocompleta', 'completa_registro')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'registercomplete',
		'action'     => 'index',
	));
	
Route::set('registrogracias', 'registro/gracias')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'register',
		'action'     => 'thanks',
	));	

Route::set('miperfil', 'mi_perfil')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'register',
		'action'     => 'profile',
	));
	
Route::set('materias', 'materias')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'register',
		'action'     => 'materias',
	));

Route::set('rmiperfilgracias', 'mi_perfil/gracias')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'register',
		'action'     => 'profile_thanks',
	));

Route::set('favoritos', 'favoritos')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'register',
		'action'     => 'favorites',
	));
	
Route::set('favorito', 'favorito/<game>')->defaults(array(
	'directory'  => 'frontend',
	'controller' => 'register',
	'action'     => 'favorite'
));
	
Route::set('search', 'search')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'game',
		'action'     => 'search',
	));


Route::set('pages', '(<section>(/<page>))', array('section' => '[a-z0-9\-]+', 'page' => '[a-z0-9\-]+'))
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'homepage',
		'action'     => 'pages',
	));
	
Route::set('recupera_password', 'recupera_contrasena')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'passwordrecovery',
		'action'     => 'index',
	));	
	
Route::set('nueva_contrasena', 'nueva_contrasena')
	->defaults(array(
		'directory'  => 'frontend',
		'controller' => 'register',
		'action'     => 'recovery',
	));	
	
Route::set('validateUsername', 'validateUsername')->defaults(array(
	'directory'  => 'frontend',
	'controller' => 'register',
	'action'     => 'validateUsername',
));