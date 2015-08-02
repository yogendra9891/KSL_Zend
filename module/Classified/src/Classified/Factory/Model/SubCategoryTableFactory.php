<?php
//filename : module/Classified/src/Classified/Factory/Model/SubCategoryTableFactory.php
namespace Classified\Factory\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Classified\Model\SubCategoryTable;
use Classified\Model\SubCategory;

use Zend\Stdlib\Hydrator\ObjectProperty;
use Zend\Db\ResultSet\HydratingResultSet;

class SubCategoryTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$db = $serviceLocator->get('Zend\Db\Adapter\Adapter');

		$resultSetPrototype = new HydratingResultSet();
		$resultSetPrototype->setHydrator(new ObjectProperty());
		$resultSetPrototype->setObjectPrototype(new SubCategory());

		$tableGateway       = new TableGateway('ksl_child_category', $db, null, $resultSetPrototype);
		$table              = new SubCategoryTable($tableGateway);

		return $table;
	}
}