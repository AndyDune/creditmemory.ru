<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Tools\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {


        return $this->layout()->getVariables();
        return array();
    }

    public function staticPageAction()
    {
        $sm = $this->getServiceLocator();
        $structure = $sm->get('structure');

        return $this->layout()->getVariables();
    }
}
