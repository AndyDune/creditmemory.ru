<?php
/**
 * Copyright (c) 2013 Andrey Ryzhov.
 * All rights reserved.
 *
 * @package     Admin
 * @author      Andrey Ryzhov <m@1rzn.com>
 * @copyright   2013 Andrey Ryzhov.
 * @license     http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link        http://rznw.ru
 */

namespace Admin;

use Zend\ModuleManager\Feature;
use Zend\Loader;

/**
 * Module class for ZfcAdmin
 *
 * @package ZfcAdmin
 */
class Module
{

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }


    /**
     * @{inheritdoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @{inheritdoc}
     */
    public function getServiceConfig()
    {
        return array();
    }
}
