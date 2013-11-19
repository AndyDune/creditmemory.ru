<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Tools\Controller\Index' => 'Tools\Controller\IndexController',
        ),
    ),

    'service_manager' => array(
        'invokables' => array(
            'Structure' => 'Tools\Service\Structure',
        ),
        'aliases' => array(
            //'structure' => 'Structure',
        ),
    ),

/*
    'di' => array(
        'services' => array(
            'Structure' => 'Tools\Service\Structure',
        )
    ),
*/


/*
    'view_manager' => array(
        'template_path_stack' => array(
            'Templates' => __DIR__ . '/../view',
        ),
    ),
*/
);
