<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
     'controllers' => array(
         'invokables' => array(
             'Admin\Controller\Admin' => 'Admin\Controller\AdminController',
             
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'admin' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/admin[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Admin\Controller\Admin',
                         'action'     => 'index',
                     ),
                 ),
             ),
             'classified' => array(
             		'type'    => 'segment',
             		'options' => array(
             				'route'    => '/classified[/][:action][/:id]',
             				'constraints' => array(
             						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
             						'id'     => '[0-9]+',
             				),
             				'defaults' => array(
             						'controller' => 'classified/classified',
             						'action'     => 'index',
             				),
             		),
             ),
             'user' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/user[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Admin\Controller\User',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     
	 
	  'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
//             'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
//             'error/404'               => __DIR__ . '/../view/error/404.phtml',
//             'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
 );
