<?php

/**
 * Index.php
 *
 * @package myMVC
 * @copyright ueffing.net
 * @author Guido K.B.W. Üffing <info@ueffing.net>
 * @license GNU GENERAL PUBLIC LICENSE Version 3. See application/doc/COPYING
 */

/**
 * @name $BlogimusEvent
 */
namespace Blogimus\Event;

use MVC\Event;
use MVC\Registry;
use MVC\Request;

/**
 * Index
 */
class Index
{
    /**
     * Blogimus\Event\Index
     * 
     * @var Blogimus\Event\Index
     * @access private
     * @static
     */
    private static $_oInstance = NULL;

    /**
     * Index constructor.
     * @throws \ReflectionException
     */
    protected function __construct()
    {
        $aEvent = Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'));

        foreach ($aEvent['EVENT_BIND'] as $sEvent => $oClosure)
        {
            Event::BIND($sEvent, $oClosure);
        }
    }

    /**
     * Singleton instance
     * @return Blogimus\Event\Index|Index
     * @throws \ReflectionException
     */
    public static function getInstance()
    {
        if (null === self::$_oInstance)
        {
            self::$_oInstance = new self ();
        }

        return self::$_oInstance;
    }

    /**
     * prevent any cloning
     * 
     * @access private
     * @return void
     */
    private function __clone()
    {
        ;
    }

    /**
     * activates Session for Frontend Calls
     * @param DTArrayObject $oDTArrayObject
     * @throws \ReflectionException
     */
    public static function enableSession(\MVC\DataType\DTArrayObject $oDTArrayObject)
    {
        // Request via GUI
        $bIsGuiRequest = in_array(
            Request::getInstance()->getController(),
            Registry::get('MODULE_' . Registry::get('MODULE_FOLDERNAME'))['SESSION']['aEnableSessionForController']
        );

        if (true === $bIsGuiRequest &&
            isset($_COOKIE['myMVC_cookieConsent']) &&
            "true" == $_COOKIE['myMVC_cookieConsent']) {
            Registry::set('MVC_SESSION_ENABLE', true);
        }
    }

    /**
     * Destructor
     * 
     * @access public
     * @return void
     */
    public function __destruct()
    {
        ;
    }
}
