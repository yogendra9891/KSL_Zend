<?php
// module/Album/src/Album/Model/AlbumTable.php:
namespace Classified\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Sql;

class PostTable 
{
    protected $table ='ksl_post';

    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }

    public function getTableGateway()
    {
    	return $this->tableGateway->adapter;
    }
   
    
    /**
     * Get all parent category 
     * @param user id
     * @return array
     */
    public function getAllPost($paginated=false, $order_by, $order)
    {
    	if ($paginated) {
    	// create a new Select object for the table SubCategory
    		$sqlSelect = $this->tableGateway->getSql()
    	    ->select()
    		->order('id' . ' DESC');
    		
    		// create a new result set based on the SubCategory entity
    		$resultSetPrototype = new ResultSet();
    		$resultSetPrototype->setArrayObjectPrototype(new Category());
    		// create a new pagination adapter object
    		$paginatorAdapter = new DbSelect(
    		// our configured select object
    				$sqlSelect,
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
     * Get all parent category
     * @param void
     * @return array
     */
    public function getAllCategory()
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
    
    /**
     * Get all parent category
     * @param void
     * @return array
     */
    public function getAllChildCategory()
    {
    	$adapter = $this->getTableGateway();
    
    	$sql = new Sql($adapter);
    	$select = $sql->select();
    	$select->from('ksl_child_category');
    	$selectString = $sql->getSqlStringForSqlObject($select);
    	$resultset = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
    	$results = $resultset->toArray();
    	$array = array();
    	foreach ($results as $result) {
    		$array[$result['id']] = $result['title'];
    	}
    	return $array;
    }
    
    /**
     * get the child category
     * @param int $id
     * @return array
     */
    public function getChildCategory($id)
    {
    	$adapter = $this->getTableGateway();
    	
    	$sql = new Sql($adapter);
    	$select = $sql->select();
    	$select->from('ksl_child_category');
    	$select->where(array('parent_id'=>$id));
    	
    	$selectString = $sql->getSqlStringForSqlObject($select);
    	$resultset = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
    	$results = $resultset->toArray();
    	$array = array();
    	foreach ($results as $result) {
    		$array[$result['id']] = $result['title'];
    	}
    	return $array;
    }
    
    /**
     * Save the category
     * @param array
     * @return array
     */
    public function savePost($data)
    {
    	
    	$id = (int) $data['id'];
    	$date = date('Y-m-d H:i:s');
    	$newdata['title'] = $data['title'];
    	$newdata['short_description'] = $data['short_description'];
    	$newdata['description'] = $data['description'];
    	$newdata['price'] = $data['price'];
    	$newdata['contact_name'] = $data['contact_name'];
    	$newdata['contact_email'] = $data['contact_email'];
    	$newdata['contact_phone_home'] = $data['contact_phone_home'];
    	$newdata['contact_phone_work'] = $data['contact_phone_work'];
    	$newdata['contact_phone_cell'] = $data['contact_phone_cell'];
    	$newdata['address_1'] = $data['address_1'];
    	$newdata['address_2'] = $data['address_2'];
    	$newdata['city'] = $data['city'];
    	$newdata['state'] = $data['state'];
    	$newdata['is_featured'] = $data['is_featured'];
    	$newdata['status'] = $data['status'];
    	$newdata['zip'] = $data['zip'];
    	$newdata['category_id'] = $data['category_id'];
    	$newdata['sub_category_id'] = $data['sub_category_id'];
    	$newdata['user_id'] = $data['user_id'];
    	
    	if($id == 0){
    		$newdata['created_date'] = $date;
    		$newdata['modified_date'] = $date;
    	    $this->tableGateway->insert($newdata);
    	}else {
    		$newdata['modified_date'] = $date;
    	    $this->tableGateway->update(
    			$newdata,
    			array(
    					'id' => $id,
    			)
    	);
    	}
    }
    
    /**
     * delete the post
     * @param int $id
     */
    public function deletePost($id)
    {
    	$result = $this->tableGateway->delete(array(
    			'id' => $id,
    	));
    	if($result){
    		return true;
    	}
    }
    
    public function getSinglePost($id)
    {
    	//get category detail
    	$rowset = $this->tableGateway->select(array('id'=>$id));
    	$row = $rowset->current();
    	
    	return $row;
    }
    
    /**
     * get subcategory of selected post
     * @param int $id
     * @return int
     */
    public function getPostSubCategory($id)
    {
    	
    	$adapter = $this->getTableGateway();
    	
    	$sql = new Sql($adapter);
    	$select = $sql->select();
    	$select->columns(array('sub_category_id'));
    	$select->from('ksl_posts');
    	$select->where(array('id'=>$id));
    	
    	$selectString = $sql->getSqlStringForSqlObject($select);
    	$resultset = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
    	$results = $resultset->toArray();
    	
    	foreach($results as $result){
    		$sub_cat_id = $result['sub_category_id'];
    	}
    	return $sub_cat_id;
    }
    
   
    
    
	}