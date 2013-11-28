<?php
/**
 * Конфиг модуля Admin
 */

return array(

     'router' => array(
         'routes' => array(
             'zfcadmin' => array(

                 'child_routes' => array(
                     'config' => array(
                         'type' => 'literal',
                         'options' => array(
                             'route' => '/config',
                             'defaults' => array(
                                 'controller' => 'Admin\Controller\Index',
                                 'action'     => 'config',
                             ),
                         ),
                     ),
                 ),

                 'options' => array(
                     'defaults' => array(
                         'controller' => 'Admin\Controller\Index',
                          'action'     => 'index',
                      ),
                  ),
              ),
          ),
      ),



    'navigation' => array(
        'admin' => array(
            'config' => array(
                'label' => 'Настройки',
                'route' => 'zfcadmin/config',
            ),
        ),
    ),


    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController'
        ),
    ),
);
