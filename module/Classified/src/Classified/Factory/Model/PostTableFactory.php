<?php
//filename : module/Album/src/Album/Factory/Model/AlbumTableFactory.php
namespace Classified\Factory\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Classified\Model\PostTable;
use Classified\Model\Post;

use Zend\Stdlib\Hydrator\ObjectProperty;
use Zend\Db\ResultSet\HydratingResultSet;

class PostTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$db = $serviceLocator->get('Zend\Db\Adapter\Adapter');

		$resultSetPrototype = new HydratingResultSet();
		$resultSetPrototype->setHydrator(new ObjectProperty());
		$resultSetPrototype->setObjectPrototype(new Post());

		$tableGateway       = new TableGateway('ksl_posts', $db, null, $resultSetPrototype);
		$table              = new PostTable($tableGateway);

		return $table;
	}
}