<?php
namespace CjsLogin;

/**
 * \CjsLogin\Login::regAutoload();
 */
class Login {

    protected static $isReg = false;

    public static function regAutoload() {
        if(self::$isReg) {
            return false;
        }
        self::$isReg = true;
        require_once __DIR__  . '/Helpers.php';
        spl_autoload_register(function ($class) {
            $ns = 'CjsLogin';
            $base_dir = __DIR__ . '/';
            $prefix_len = strlen($ns);
            if (substr($class, 0, $prefix_len) !== $ns) {
                return;
            }
            $class = substr($class, $prefix_len);
            $file = $base_dir .str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
            if (is_readable($file)) {
                require $file;
            }
        });
        return true;
    }

}