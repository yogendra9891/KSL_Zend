<?php 
namespace Classified\Model;

 use Zend\Db\TableGateway\TableGateway;
 use Zend\Db\Sql\Select;
 use Zend\Db\Sql\Sql;
 use Zend\Paginator\Adapter\DbSelect;
 use Zend\Paginator\Paginator;
 use Zend\Db\ResultSet\ResultSet;
 //use for hydrator prototype(mainly object conversion).
 use Zend\Stdlib\Hydrator\ObjectProperty;
 use Zend\Db\ResultSet\HydratingResultSet;
 class SubCategoryTable
 {
	 protected $tableGateway;
	
	 /**
	  * defining the construct 
	  * @param TableGateway $tableGateway
	  */
	 public function __construct(TableGateway $tableGateway)
	 {
		 $this->tableGateway = $tableGateway;
	 }
	 
	 /**
	  * getting current table gateway adapter.
	  */
	 public function getTableGateway()
	 {
	 	return $this->tableGateway->adapter;
	 }	
	 /**
	  * fetching all the records from table
	  * @params boolean,string, string
	  * @return object 
	  */
	 public function fetchAll($paginated=false, $order_by, $order)
	 {
	 	 if ($paginated) {
	 		 // create a new Select object for the table SubCategory
	 		 $select = new Select('ksl_child_category');
	 		 $select->columns(array('id', 'description', 'title', 'created_date', 'modified_date'))
	 		        ->join('ksl_parent_category', 'ksl_parent_category.id = ksl_child_category.parent_id', array('parent_id'=>'id', 'parent_cat'=>'title'))
	 		        ->order($order_by . ' ' . $order);

	 		 // create a new result set based on the SubCategory entity
// 	 		 $resultSetPrototype = new ResultSet();
// 	 		 $resultSetPrototype->setArrayObjectPrototype(new SubCategory());

	 		 //set the hydrator getting the second table column(parent_id, parent_cat).
	 		 $resultSetPrototype = new HydratingResultSet();
	 		 $resultSetPrototype->setHydrator(new ObjectProperty());
	 		 $resultSetPrototype->setObjectPrototype(new SubCategory());
	 		 
	 		 // create a new pagination adapter object
	 		 $paginatorAdapter = new DbSelect(
	 				 // our configured select object
	 				 $select,
	 				 // the adapter to run it against
	 				 $this->tableGateway->getAdapter(),
	 				 // the result set to hydrate
	 				 $resultSetPrototype
	 				 );
	 		 $paginator = new Paginator($paginatorAdapter);
	 		 return $paginator;
	 	 }
		 $resultSet = $this->tableGateway->select();
		 return $resultSet;
	 }
	
	 /**
	  * get a single record accorsding to id.
	  * @param int $id
	  * @throws \Exception
	  */
	 public function getSubCategory($id)
	 {
		 $id = (int) $id;
		 $rowset = $this->tableGateway->select(array('id' => $id));
		 $row = $rowset->current();
		 if (!$row) {
		 	throw new \Exception("Could not find row $id");
		 }
		 return $row;
	 }
	 
	 /**
	  * saving/update a record
	  * @param Object
	  * @throws \Exception
	  */
	  public function saveSubCategory(SubCategory $SubCategory)
	  {
		 $data = array(
		 			 'title'       =>  $SubCategory->title,
		 			 'description' => $SubCategory->description,
		 		     'parent_id'   => $SubCategory->parent_id,
		 		     'created_date'   => $SubCategory->created_date,
		 		     'modified_date'   => $SubCategory->modified_date,
		 			 );
		 $id = (int) $SubCategory->id;
		 if ($id == 0) {
			 $this->tableGateway->insert($data);
		 } else {
			  if ($this->getSubCategory($id)) {
				 $this->tableGateway->update($data, array('id' => $id));
			  } else {
			 	 throw new \Exception('SubCategory id does not exist');
			 }
		}
	  }
	
	 /**
	  * delete a single record from table 
	  * @param int $id
	  */
	 public function deleteSubCategory($id)
	 {
		  $this->tableGateway->delete(array('id' => (int) $id));
	  }
	  
	  /**
	   * fetching all the parent category records from table
	   * @params none
	   * @return array
	   */
	  public function fetchAllParentCatergory()
	  {
	  	$adapter = $this->getTableGateway();
	  	
	  	$sql = new Sql($adapter);
	  	$select = $sql->select();
	  	$select->from('ksl_parent_category');
	  	$selectString = $sql->getSqlStringForSqlObject($select);
	  	$resultset = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
	  	$results = $resultset->toArray();
      	$array = array();
      	foreach ($results as $result) {
      		$array[$result['id']] = $result['title'];
      	}
	  	return $array;
	  }
 }
 ?>