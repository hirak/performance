<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initFunctions()
    {
        require_once 'functions.php';
    }

    protected function _initPluginCache()
    {
        $cachefile = APPLICATION_PATH . '/../data/cache/plugins.php';
        if (file_exists($cachefile)) {
            include_once $cachefile;
        }
        Zend_Loader_PluginLoader::setIncludeFileCache($cachefile);
    }
}
