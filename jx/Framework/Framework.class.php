<?php

class Framework
{
    public static function run()
    {
        self::intiPath();
        self::initConfig();
        self::initClassMapping();
        self::initRequest();
        self::autoLoad();
        self::dispache();
    }

    private static function intiPath()
    {
        defined('DS') or define('DS', DIRECTORY_SEPARATOR);
        defined('ROOT_PATH') or define('ROOT_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . DS);
        defined('APP_PATH') or define('APP_PATH', ROOT_PATH . 'Application' . DS);
        defined('CONFIG_PATH') or define('CONFIG_PATH', APP_PATH . 'Config' . DS);
        defined('CONTROLLER_PATH') or define('CONTROLLER_PATH', APP_PATH . 'Controller' . DS);
        defined('MODEL_PATH') or define('MODEL_PATH', APP_PATH . 'Model' . DS);
        defined('VIEW_PATH') or define('VIEW_PATH', APP_PATH . 'View' . DS);
        defined('FRAMEWORK_PATH') or define('FRAMEWORK_PATH', ROOT_PATH . 'Framework' . DS);
        defined('TOOL_PATH') or define('TOOL_PATH', FRAMEWORK_PATH . 'Tool' . DS);
        defined('UPLOAD_PATH') or define('UPLOAD_PATH', ROOT_PATH . 'Upload' . DS);
    }

    private static function initConfig()
    {
        $GLOBALS['config'] = require CONFIG_PATH.'application.config.php';
    }

    private static function initRequest()
    {
        defined('CONTROLLER_NAME') or  define('CONTROLLER_NAME',isset($_GET['c']) ?$_GET['c']: $GLOBALS['config']['App']['default_controller']);
        defined('ACTION_NAME') or define('ACTION_NAME',isset($_GET['a']) ? $_GET['a'] : $GLOBALS['config']['App']['default_action']);
        defined('PLATFORM_NAME') or define('PLATFORM_NAME',isset($_GET['p']) ? $_GET['p'] : $GLOBALS['config']['App']['default_platform']);
        unset($_GET['p']);
        unset($_GET['c']);
        unset($_GET['a']);
        unset($_REQUEST['p']);
        unset($_REQUEST['c']);
        unset($_REQUEST['a']);
        defined('CURRENT_VIEW_PATH') or define('CURRENT_VIEW_PATH', VIEW_PATH . PLATFORM_NAME .DS.CONTROLLER_NAME. DS);
        defined('CURRENT_CONTROLLER_PATH') or define('CURRENT_CONTROLLER_PATH', CONTROLLER_PATH.PLATFORM_NAME.DS);
    }

    private static function dispache()
    {
        $actionName = ACTION_NAME . 'Action';
        $controllerName = CONTROLLER_NAME . 'Controller';
        $controller = new $controllerName();
        $controller->$actionName();
    }

    private static function initClassMapping()
    {
        $GLOBALS['map'] = array(
            'DB' => FRAMEWORK_PATH . 'DB.class.php',
            'Model' => FRAMEWORK_PATH . 'Model.class.php',
            'Controller' => FRAMEWORK_PATH . 'Controller.class.php',
        );
    }

    private static function autoLoad()
    {
        spl_autoload_register('Framework::userautoload');
    }

    private static function userAutoload($className)
    {
        if (array_key_exists($className, $GLOBALS['map']))
        {
            require $GLOBALS['map'][$className];
        } else if (substr($className, -10) == 'Controller')
        {
            require CURRENT_CONTROLLER_PATH . $className . '.class.php';
        } else if (substr($className, -5) == 'Model')
        {
            require MODEL_PATH . $className . '.class.php';
        } else if (substr($className, -4) == 'Tool')
        {
            require TOOL_PATH . $className . '.class.php';
        }
    }

}
