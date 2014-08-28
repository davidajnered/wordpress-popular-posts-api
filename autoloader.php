<?php
/**
 * Setup autoloader.
 *
 * @param string $namespace
 * @param string $constantPrefix unique prefix for project constants
 * @param string $appFolder name of root folder where autoloader should search for classes
 */
function autoloader($namespace, $constantPrefix, $appFolder)
{
    // Make sure prefix variable is set
    if (!$constantPrefix) {
        trigger_error('variable $pluginCostantPrefix is not set', E_USER_ERROR);
    }

    // Setup plugin constants
    if (!defined($constantPrefix . '_RELPATH')) {
        define($constantPrefix . '_RELPATH', str_replace(ABSPATH, '', plugin_dir_path(__FILE__)));
    }

    if (!defined($constantPrefix . '_ABSPATH')) {
        define($constantPrefix . '_ABSPATH', plugin_dir_path(__FILE__));
    }

    // Autoload classes
    spl_autoload_register(function ($className) use ($namespace, $constantPrefix, $appFolder) {
        if (strpos($className, $namespace) === 0) {
            $classPath = str_replace($namespace, '', str_replace('\\', '/', $className)) . '.php';
            $classPath = constant($constantPrefix . '_ABSPATH') . $appFolder . $classPath;

            if (file_exists($classPath)) {
                include_once($classPath);
            }
        }
    });
}
