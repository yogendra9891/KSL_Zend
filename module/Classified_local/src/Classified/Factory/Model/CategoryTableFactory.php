<?php
//filename : module/Album/src/Album/Factory/Model/AlbumTableFactory.php
namespace Classified\Factory\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Classified\Model\CategoryTable;
use Classified\Model\Category;

use Zend\Stdlib\Hydrator\ObjectProperty;
use Zend\Db\ResultSet\HydratingResultSet;

class CategoryTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$db = $serviceLocator->get('Zend\Db\Adapter\Adapter');

		$resultSetPrototype = new HydratingResultSet();
		$resultSetPrototype->setHydrator(new ObjectProperty());
		$resultSetPrototype->setObjectPrototype(new Category());

		$tableGateway       = new TableGateway('ksl_parent_category', $db, null, $resultSetPrototype);
		$table              = new CategoryTable($tableGateway);

		return $table;
	}
}