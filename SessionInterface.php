<?php

namespace Panada\Session;

/**
 * Interface for Session Drivers
 *
 * @package  Session
 * @author   Iskandar Soesman <k4ndar@yahoo.com>
 * @link     http://panadaframework.com/
 * @license  http://opensource.org/licenses/MIT
 * @since    version 1.0.0
 */
interface SessionInterface
{
    public function setValue($name, $value = '');
    public function getValue($name);
    public function getAllValue();
    public function deleteValue($name);
    public function regenerateId();
    public function destroy();
}
