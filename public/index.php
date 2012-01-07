<?php
function myloader($classname) {
    return @include str_replace('_', DIRECTORY_SEPARATOR, $classname).'.php';
}
spl_autoload_register('myloader');

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path()
)));

require_once 'functions.php';

main();
function main() {
    $key = 'app_performance';
    $config = apc_fetch($key, $success);
    if (!$success) {
        $config = new Zend_Config_Ini(
            APPLICATION_PATH . '/configs/application.ini',
            APPLICATION_ENV
        );
        $config = $config->toArray();
        apc_store($key, $config);
    }
    $cachefile = APPLICATION_PATH . '/../data/cache/plugins.php';
    if (file_exists($cachefile)) {
        include_once $cachefile;
    }
    Zend_Loader_PluginLoader::setIncludeFileCache($cachefile);

    // Create application, bootstrap, and run
    $application = new Zend_Application(
        APPLICATION_ENV,
    //    APPLICATION_PATH . '/configs/application.ini'
        $config
    );
    $application->bootstrap()
                ->run();
}
