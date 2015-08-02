<?php
// module/Album/src/Album/Model/AlbumTable.php:
namespace Classified\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class CategoryTable 
{
    protected $table ='ksl_parent_category';

    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }

    public function getTableGateway()
    {
    	return $this->adapter;
    }
   
    
    /**
     * Get all parent category 
     * @param user id
     * @return array
     */
    public function getCategory($paginated=false, $order_by, $order)
    {
//     	$rowset = $this->tableGateway->select(array(
//     			'id' => 2,
//     	));
    	
// return $rowset;
    	if ($paginated) {
    	// create a new Select object for the table SubCategory
    		$sqlSelect = $this->tableGateway->getSql()
    	    ->select();
    		
    		
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
     * Save the category
     * @param array
     * @return array
     */
    public function saveCategory($data)
    {
    	$id = (int) $data->id;
    	$date = date('Y-m-d H:i:s');
    	$add_data = array(
    			'title' => $data->title,
    			'description'  => $data->description,
                'created_date' => $date,
    			'modified_date' => $date,
    			
    	);
    	
    	if($id == 0){
    	$this->tableGateway->insert($add_data);
    	}else {
    		
    		$edit_data = array(
    				'title' => $data->title,
    				'description'  => $data->description,
    				'modified_date' => $date,
    		
    		);
    	$this->tableGateway->update(
    			$edit_data,
    			array(
    					'id' => $id,
    			)
    	);
    	}
    }
    
    /**
     * get the single category
     * @param int $id
     * @return array
     */
    public function getSingleCategory($id)
    {
    	//get category detail
    	$rowset = $this->tableGateway->select(array('id'=>$id));
    	$row = $rowset->current();
    
    	return $row;
    }
    
    /**
     * delete the category
     * @param int $id
     * @return boolean
     */
    public function deleteCategory($id)
    {
    	$result = $this->tableGateway->delete(array(
    			'id' => $id,
    	));
    	if($result){
    		return true;
    	}
    }
    
    
	}