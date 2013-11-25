<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace SiteStructure\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

class IndexController extends AbstractActionController
{
    protected $session = null;

    public function indexAction()
    {
        return $this->layout()->getVariables();
        return array();
    }

    public function staticPageAction()
    {

        //phpinfo();
        /** @var \Zend\ServiceManager\ServiceManager $sm */
        $sm = $this->getServiceLocator();

        $session = $this->getSession();
        $session->number = 12;

        //echo $session->number;

        $structure = $sm->get('site_structure');

        return $this->layout()->getVariables();
    }


    /**
     * @return Container
     */
    public function getSession()
    {
        if ($this->session === null) {
            $this->session = new Container('my_session');
        }
        return $this->session;
    }

}
