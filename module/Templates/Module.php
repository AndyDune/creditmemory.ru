<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Templates;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

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
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);



        $app = $e->getParam('application');
        $app->getEventManager()->attach('dispatch', array($this, 'setLayout'));

        //$app->getEventManager()->attach(MvcEvent::EVENT_ROUTE, array($this, 'onRoute'), 1);


        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractController', 'dispatch', function($e) {
            $controller      = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            $config          = $e->getApplication()->getServiceManager()->get('config');
            if (isset($config['module_layouts'][$moduleNamespace]))
            {
                $controller->layout($config['module_layouts'][$moduleNamespace]);
            }
        }, 100);


        return;
        // Для Аякса специпальный шаблон для всего
        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractController', 'dispatch', function($e)
        {
            $controller      = $e->getTarget();
            $request = $controller->getRequest();
            if ($request->isXmlHttpRequest())
            {
                $layout = $controller->layout();
                //$layout->setTemplate(__DIR__ . '/view/default/layout/json');
                $layout->setTemplate('/default/layout/json');
            }
        }, 101);

    }

    public function onRoute($e)
    {
        $matches = $e->getRouteMatch();
        $matches->setParam('controller', 'Templates\Controller\Index');
        $matches->setParam('action', 'index');
    }

    public function setLayout($e)
    {
        $viewTemplatePathStack = $e->getApplication()->getServiceManager()->get('ViewTemplatePathStack');
        $viewTemplatePathStack->addPath(__DIR__ . '/view/default/');

        $controllerObject = $e->getTarget();
        $request = $controllerObject->getRequest();
        if ($request->isXmlHttpRequest())
        {
            $layout = $controllerObject->layout();
            //$layout->setTemplate(__DIR__ . '/view/default/layout/json');
            $layout->setTemplate('/layout/json');
        }

        $matches    = $e->getRouteMatch();
        $controller = $matches->getParam('controller');

        if (false === strpos($controller, __NAMESPACE__))
        {
            $controllerClass = get_class($controllerObject);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));

            $viewTemplatePathStack->addPath(__DIR__ . '/view-modules/default/' . $moduleNamespace  . '/');
            //print_r($viewTemplatePathStack);
        }

        //return;

        $action = $matches->getParam('action');
        if (false !== strpos($controller, __NAMESPACE__))
        {
            // not a controller from this module
            return;
        }

        // Set the layout template
        //$viewModel = $e->getViewModel();
        //$viewModel->setTemplate('content/layout');
    }
}
