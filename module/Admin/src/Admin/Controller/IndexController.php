<?php
/**
 *
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * Placeholder controller
 *
 * This controller is just here in case you have not defined a controller
 * behind the 'admin' route yourself. If you haven't, you would otherwise
 * get a 404: Page not found error.
 *
 * If you want to override this controller (and action), create a module and
 * put this in the module configuration:
 *
 * <code>
 * <?php
 * return array(
 *     'router' => array(
 *         'routes' => array(
 *             'admin' => array(
 *                 'options' => array(
 *                     'defaults' => array(
 *                         'controller' => 'MyFoo\Controller\OtherController',
 *                         'action'     => 'custom',
 *                     ),
 *                 ),
 *             ),
 *         ),
 *     ),
 * );
 * </code>
 *
 * @package    ZfcAdmin
 * @subpackage Controller
 */
class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        return array();
    }


    public function configAction()
    {
        return array();
    }


}