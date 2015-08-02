<?php
// module/Classified/src/Classified/Model/PostImageTable.php:
namespace Classified\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Sql;

class PostImageTable 
{
    protected $table ='ksl_post_images';

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
    public function getAllImages($id)
    {
//     	if ($paginated) {
//     	// create a new Select object for the table SubCategory
//     		$sqlSelect = $this->tableGateway->getSql()
//     	    ->select();
    		
    		
//     		// create a new result set based on the SubCategory entity
//     		$resultSetPrototype = new ResultSet();
//     		$resultSetPrototype->setArrayObjectPrototype(new Category());
//     		// create a new pagination adapter object
//     		$paginatorAdapter = new DbSelect(
//     		// our configured select object
//     				$sqlSelect,
//     				// the adapter to run it against
//     				$this->tableGateway->getAdapter(),
//     				// the result set to hydrate
//     				$resultSetPrototype
//     		);
//     		$paginator = new Paginator($paginatorAdapter);
//     		return $paginator;
//     	}
    	$resultSet = $this->tableGateway->select(array('post_id'=>$id));
    	return $resultSet;
    }

    /**
     * get a single record accorsding to id.
     * @param int $id
     * @throws \Exception
     */
    public function getPostImage($id)
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
     * saving the image data for a post.
     * @params array
     * @return boolean
     */
	public function addImageData($data)
	{
    	$this->tableGateway->insert($data);
    	return true;
	}    
	
	/**
	 * delete a single record from table
	 * @param int $id
	 */
	public function deleteImageData($id)
	{
		$this->tableGateway->delete(array('id' => (int) $id));
	}
}