<?php

namespace Panada\Session;

use Panada\Resource;

/**
 * Panada session Handler.
 *
 * @package  Resource
 * @link     http://panadaframework.com/
 * @license  http://www.opensource.org/licenses/bsd-license.php
 * @author   Iskandar Soesman <k4ndar@yahoo.com>
 * @since    Version 0.1
 */
class Session
{
    private $driver;
    private $config = [
        'expiration' => 7200,
        'name' => 'PANSID',
        'cookieExpire' => 0,
        'cookiePath' => '/',
        'cookieSecure' => false,
        'cookieDomain' => '',
        'cookieDomain' => '',
        'driver' => 'native', /* The option is 'native', 'cookie', cookies, cache or 'database' */
        'driverConnection' => 'default',
        'storageName' => 'sessions',
        'isEncrypt' => false,
        'secretKey' => '123'
    ];
    
    protected static $instance = [];

    public function __construct($config = [])
    {
        $this->setOption($config);
    }
    
    public static function getInstance($type = 'default')
    {
        if (! isset(self::$instance[$type])) {
            self::$instance[$type] = new static(\Panada\Resource\Config::session()[$type]);
        }
        
        return self::$instance[$type];
    }

    /**
     * Overrider for session config option.
     *
     * @param array $option The new option.
     * @return void
     * @since version 1.0
     */
    public function setOption($config = [])
    {
        $this->config = array_merge($this->config, $config);
        $this->init();
    }
    
    /**
     * Instantiate the driver class
     *
     * @return void
     * @since version 1.0
     */
    private function init()
    {
        $driverNamespace = 'Panada\Session\Drivers\\' . ucwords($this->config['driver']);
        $this->driver = new $driverNamespace($this->config);
    }

    /**
     * Use magic method 'call' to pass user method
     * into driver method
     *
     * @param string @name
     * @param array @arguments
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array(array($this->driver, $name), $arguments);
    }

    /**
     * Magic getter for properties
     *
     * @param string
     * @return mix
     */
    public function __get($name)
    {
        return $this->driver->$name;
    }

    /**
     * Magic setter for properties
     *
     * @param string
     * @param mix
     * @return mix
     */
    public function __set($name, $value)
    {
        $this->driver->$name = $value;
    }
}
