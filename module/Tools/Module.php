<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Tools;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Zend\Cache\StorageFactory;
use Zend\Session\SaveHandler\Cache;
use Zend\Session\SessionManager;
use Zend\Session\Container;


class Module implements AutoloaderProviderInterface
{
    protected $_space = 'default';
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $serviceManager      = $e->getApplication()->getServiceManager();

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $this->bootstrapSession($e);
    }


    public function bootstrapSession($e)
    {
        $session = $e->getApplication()
            ->getServiceManager()
            ->get('Zend\Session\SessionManager');
        $session->start();

        $container = new Container('initialized');
        if (!isset($container->init)) {
            $session->regenerateId(true);
            $container->init = 1;
        }
    }


    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Zend\Session\SessionManager' => function ($sm) {
                        $config = $sm->get('config');
                        if (isset($config['session'])) {
                            $session = $config['session'];

                            $sessionConfig = null;
                            if (isset($session['config'])) {
                                $class = isset($session['config']['class'])  ? $session['config']['class'] : 'Zend\Session\Config\SessionConfig';
                                $options = isset($session['config']['options']) ? $session['config']['options'] : array();
                                $sessionConfig = new $class();
                                $sessionConfig->setOptions($options);
                            }

                            $sessionStorage = null;
                            if (isset($session['storage'])) {
                                $class = $session['storage'];
                                $sessionStorage = new $class();
                            }

                            $sessionSaveHandler = null;
                            if (isset($session['save_handler'])) {
                                // class should be fetched from service manager since it will require constructor arguments
                                $sessionSaveHandler = $sm->get($session['save_handler']);
                            }

                            $sessionManager = new SessionManager($sessionConfig, $sessionStorage, $sessionSaveHandler);

                            if (isset($session['validators'])) {
                                $chain = $sessionManager->getValidatorChain();
                                foreach ($session['validators'] as $validator) {
                                    $validator = new $validator();
                                    $chain->attach('session.validate', array($validator, 'isValid'));

                                }
                            }
                        } else {
                            $sessionManager = new SessionManager();
                        }

/*
                        $cache = StorageFactory::factory(array(
                            'adapter' => [
                                'name' => 'apc',
                            ],
                            'options' => [
                            ],
                        ));
                        $saveHandler = new Cache($cache);
                        $sessionManager->setSaveHandler($saveHandler);
*/


                        Container::setDefaultManager($sessionManager);
                        return $sessionManager;
                    },
            ),
        );
    }

}
