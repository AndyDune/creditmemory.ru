<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(

            'zfcadmin' => array(
                'child_routes' => array(
                    'user' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/user/[:id]',
                            'defaults' => array(
                                'controller' => 'Users\Controller\Admin',
                                'action'     => 'info',
                            ),
                        ),
                    ),

                    'user-edit' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/user-edit[/:id]',
                            'defaults' => array(
                                'controller' => 'Users\Controller\Admin',
                                'action'     => 'edit',
                            ),
                        ),
                    ),

                    'users' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/users',
                            'defaults' => array(
                                'controller' => 'Users\Controller\Admin',
                                'action'     => 'list',
                            ),
                        ),
                    ),

                ),

            ),
        ),
    ),

    'navigation' => array(
        'admin' => array(
            'users' => array(
                'label' => 'Пользователи',
                'route' => 'zfcadmin/users',
            ),
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'Users\Controller\Admin' => 'Users\Controller\AdminController'
        ),
    ),



    'di' => array(
        'services' => array(
//            'Users\Model\UsersTable' => 'Users\Model\UsersTable',
//            'Users\Model\UserStatusesTable' => 'Users\Model\UserStatusesTable',
        )
    ),
);