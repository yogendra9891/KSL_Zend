<?php
//filename : module/Classified/src/Classified/Factory/Model/PostImageTableFactory.php
namespace Classified\Factory\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Classified\Model\PostImageTable;
use Classified\Model\PostImage;

use Zend\Stdlib\Hydrator\ObjectProperty;
use Zend\Db\ResultSet\HydratingResultSet;

class PostImageTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$db = $serviceLocator->get('Zend\Db\Adapter\Adapter');

		$resultSetPrototype = new HydratingResultSet();
		$resultSetPrototype->setHydrator(new ObjectProperty());
		$resultSetPrototype->setObjectPrototype(new PostImage());

		$tableGateway       = new TableGateway('ksl_post_images', $db, null, $resultSetPrototype);
		$table              = new PostImageTable($tableGateway);

		return $table;
	}
}