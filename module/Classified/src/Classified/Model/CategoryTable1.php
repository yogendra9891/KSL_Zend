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
     * save the user profile
     * @param Profile $profile
     */
    public function saveProfile( Profile $profile )
    {
    	$data = array(
    			'user_id' => $profile->user_id,
    			'profile_img'  => $profile->profile_img['name'],
    			'status' => 1
    	);
    	
    	$id = (int) $profile->user_id;
        $update_status = $this->getProfileInfo($id);
    	if ($update_status) {
    		$this->update($data, array('user_id' => $id));
    	} elseif ($this->getProfileInfo($id)) {
    		$this->insert($data);
    	} else {
    		throw new \Exception('Form id does not exist');
    	}
    }
    
    /**
     * Get profile info
     * $return boolean
     */
    public function getProfileInfo($user_id)
    {
    	$user_id  = (int) $user_id;
    	$rowset = $this->select(array(
    			'user_id' => $user_id,
    	));
    	$row = $rowset->current();
    	return $row;
    }
    
    /**
     * Get profile info
     * $return boolean
     */
    public function getProfile($user_id)
    {
    	$user_id  = (int) $user_id;
    	$rowset = $this->select(array(
    			'user_id' => $user_id,
    	));
    	$row = $rowset->current();
    
    	return $row;
    }
    
    /**
     * Get all events 
     * @param user id
     * @return array
     */
    public function getCategory()
    {


    	$sqlSelect = $this->tableGateway->getSql()
    	->select();
    	
    	
    	return $this->tableGateway->selectWith($sqlSelect);
    }
    
    
	}