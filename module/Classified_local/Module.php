<?php
namespace Classified;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    // Add this method:
    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
    					'Classified\Model\CategoryTable' 	=>  'Classified\Factory\Model\CategoryTableFactory',
						'Classified\Model\SubCategoryTable' =>  'Classified\Factory\Model\SubCategoryTableFactory',
						'Classified\Model\PostTable' 		=>  'Classified\Factory\Model\PostTableFactory',
    					'Classified\Model\PostImageTable' 	=>  'Classified\Factory\Model\PostImageTableFactory',
    			),
    	);
    }
}
