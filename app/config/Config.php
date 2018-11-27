<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/11/2018
 * Time: 16:50
 */

namespace app\config;

class Config
{

    private static $instance;
    private $settings = [];

    public function __construct($file)
    {
        $this->settings = require($file);
    }

    public static function getInstance($file)
    {
        if (is_null(self::$instance)) {
            self::$instance = new Config($file);
        }
        return self::$instance;
    }

    public function get($key)
    {
        if (!isset($this->settings[$key])) {
            return null;
        }
        return $this->settings[$key];
    }
}
