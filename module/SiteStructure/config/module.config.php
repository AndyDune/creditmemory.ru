<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'SiteStructure\Controller\Index' => 'SiteStructure\Controller\IndexController',
        ),
    ),

    'service_manager' => array(
        'invokables' => array(
            'SiteStructure' => 'SiteStructure\Service\Structure',
        ),
        'aliases' => array(
            //'SiteStructure' => 'site_structure',
        ),
    ),

    'view_helpers' => array(
        'invokables' => [
      //      'headTitle' => 'SiteStructure\View\Helper\HeadTitle',
        ],
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
