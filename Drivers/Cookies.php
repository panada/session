<?php

namespace Panada\Session\Drivers;

use Panada\Resources;

class Cookies extends Cookie
{
    public function __construct($config)
    {
        $this->response = \Panada\Resources\Response::getInstance();
        
        parent::__construct($config);
    }
    
    protected function setCookie($name, $value = '')
    {
        $this->response->setCookie(
            $name,
            $value,
            time() + $this->sessionCookieExpire,
            $this->sessionCookiePath,
            $this->sessionCookieDomain,
            $this->sessionCookieSecure,
            $this->sessionCookieHTTTPOnly
        );
    }
    
    public function destroy($setExpireHeader = false)
    {
        if ($setExpireHeader) {
            $this->response->setHeaders('Expires', 'Mon, 1 Jul 1998 01:00:00 GMT');
            $this->response->setHeaders('Cache-Control', 'no-store, no-cache, must-revalidate');
            $this->response->setHeaders('Pragma', 'no-cache');
            $this->response->setHeaders('Last-Modified', \gmdate('D, j M Y H:i:s') . ' GMT');
        }

        $this->curentValues = [];
        $this->curentValues['_d'] = '.';
        $this->sessionCookieExpire = strtotime('-10 years');
        $this->setCookie($this->sessionName);
        $this->setCookie($this->cookieChekSumName);
        $this->setSessionValues();
    }
}