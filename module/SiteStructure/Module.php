<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace SiteStructure;

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

        //$app->getEventManager()->attach(MvcEvent::EVENT_ROUTE, array($this, 'onRoute'), 1);

        $uri  = $e->getRequest()->getUri();
        $path = $uri->getPath();

        /** @var \Tools\Service\Structure $structure */
        $structure   = $e->getApplication()->getServiceManager()->get('SiteStructure');

        $structureRoot = __DIR__ . '/../../data/structure/www';

        $structure->setRoot($structureRoot);
        $structure->setPath($path);

        $structure->run();

        //$structureData = $this->_buildStructureData($path, $structureRoot, $e);

        $pathFull = __DIR__ . '/../../data/structure/www' . rtrim($path, ' /') . '/config.php';
        if (is_file($pathFull))
        {
                $array = include($pathFull);
                //$e->getRequest()->set
                //print_r($e->getViewModel());
                $e->getViewModel()->setVariables($array, true);


                $rou = array(
                'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => $path,
                    'defaults' => array(
                        'controller' => 'SiteStructure\Controller\Index',
                        'action'     => 'static-page',
                    ),
                ),
            )
            );
            $e->getRouter()->setRoutes($rou);
        }

        return;
    }


    protected function _buildStructureData($path, $root, MvcEvent $e)
    {
        $fileToLook = '/config.php';
        $result = [];
        $currentExistKey = '/';
        if (is_file($root . $fileToLook))
        {
            $result['/'] = include($root . $fileToLook);
        }
        $parts = explode('/', $path);
        $accumulatorPath = '';
        foreach($parts as $value)
        {
            $value = trim($value);
            if (!$value)
                continue;
            $accumulatorPath .= '/' . $value;
            $file = $root . $accumulatorPath . $fileToLook;
            if (is_file($file))
            {
                $currentExistKey = $accumulatorPath;
                $result[$accumulatorPath] = include($file);
            }
            else
            {

                break;
            }

        }
    }


}
