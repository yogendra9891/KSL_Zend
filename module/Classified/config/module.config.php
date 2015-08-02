<?php
//module/Album/config/module.config.php
return array(
    'doctrine' => array(
        'driver' => array(
            'Classified_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Classified/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Classified\Entity' =>  'Classified_driver'
                ),
            ),
        ),
    ),  

		'controllers' => array(
				'invokables' => array(
						'classified/classified' => 'Classified\Controller\ClassifiedController',
						'entity/entity'			=> 'Classified\Controller\EntityUsingController',
				),
		),
		
		'router' => array(
				'routes' => array(
						'classified' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/classified[/:action][/:id]',
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
						
				),
		),
		
		'translator' => array(
				'locale' => 'en_US',
				'translation_file_patterns' => array(
						array(
								'type'     => 'gettext',
								'base_dir' => __DIR__ . '/../language',
								'pattern'  => '%s.mo',
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
					//	'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
						//             'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
		//             'error/404'               => __DIR__ . '/../view/error/404.phtml',
		//             'error/index'             => __DIR__ . '/../view/error/index.phtml',
				),
				'template_path_stack' => array(
						__DIR__ . '/../view',
						'Classified' => __DIR__ . '/../view',
				),
		),
);