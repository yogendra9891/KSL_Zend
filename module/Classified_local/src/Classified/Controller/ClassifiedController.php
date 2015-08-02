<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Classified\Controller;

use MyProject\Proxies\__CG__\OtherProject\Proxies\__CG__\stdClass;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Classified\Model\Category;
use Classified\Model\SubCategory;
use Classified\Model\Post;
use Classified\Form\ParentCategoryForm;  
use Classified\Form\ChildCategoryForm;
use Classified\Form\UploadForm;
use Classified\Form\PostForm;
use Zend\Db\Sql\Select;      // <-- Add this import


class ClassifiedController extends AbstractActionController {

	protected $subCategoryTable;
	const ROUTE_LOGIN        = 'zfcuser/login';
	//defined for guest login(yogi)
	const GUEST_LOGIN              = 'guest';
	const GUEST_LOGIN_REDIRECT     = 'userclassified';
	
	//image path
	const ORIGINAL_IMAGE = '/assests/post/original/';
	const STANDARD_IMAGE = '/assests/post/standard/';
	const THUMB_IMAGE    = '/assests/post/thumb/';
	const IMAGE_SIZE     = 1048576;
	const THUMB_SIZE     = 100;
	const STANDARD_SIZE  = 300;
	
    /**
     * Classified index
     * (non-PHPdoc)
     * @see Zend\Mvc\Controller.AbstractActionController::indexAction()
     */
    public function indexAction() 
    {
    	//check for login
		$this->chekUserAuthenticationAction();
   	
    	return new ViewModel(array());
    }
	
	/**
	 * defining the sub category table object.
	 */
	public function getSubCategoryTable()
	{
		if (!$this->subCategoryTable) {
			$sm = $this->getServiceLocator();
			$this->subCategoryTable = $sm->get('Classified\Model\SubCategoryTable');
		}
		return $this->subCategoryTable;
	}    
     /**
     * Add the parent category
     * @param void
     * @return array
     */
    public function addParentCategoryAction()
    {
    	//check for login
		$this->chekUserAuthenticationAction();

    	$form = new ParentCategoryForm();

    	//check if form submitted
    	$request = $this->getRequest();
    	
    	if($request->isPost()){
    		//get category object
    		$category = new Category();
    		$form->setInputFilter($category->getInputFilter());
    		$form->setData($request->getPost());
    		if($form->isValid()){
    			$category->exchangeArray($form->getData());
    			$table = $this->getServiceLocator()->get('Classified\Model\CategoryTable');
    	        $categories = $table->saveCategory($category);
    	        return $this->redirect()->toRoute('classified',array('action'=>'listparentcategory'));
    		}
    	}
    	
    	return new ViewModel(array('form' => $form));
    }
    
    /**
     * Edit the parent category
     * @param category id
     * @return array
     */
    public function editParentCategoryAction()
    {
    	//check for login
		$this->chekUserAuthenticationAction();
    	
    	//get category id
    	$id = (int) $this->params()->fromRoute('id', 0);
    	
    	//check if id is null
    	if (!$id) {
    		return $this->redirect()->toRoute('classified', array(
    				'action' => 'addparentcategory'
    		));
    	}
    	$table = $this->getServiceLocator()->get('Classified\Model\CategoryTable');
    	$categories = $table->getSingleCategory($id);
    	
    	$form  = new ParentCategoryForm();
    	$form->bind($categories);
    	$form->get('submit')->setAttribute('value', 'Edit');
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		//get category object
    		$category = new Category();
    		$form->setInputFilter($category->getInputFilter());
    		$form->setData($request->getPost());
    	
    		if ($form->isValid()) {
    			$categories = $table->saveCategory($form->getData());
    	
    			// Redirect to list of category list
    			 return $this->redirect()->toRoute('classified',array('action'=>'listparentcategory'));
    		}
    	}
    	
    	return array(
    			'id' => $id,
    			'form' => $form,
    	);
        
    }
    
    /**
     * Delete the parent category
     * @param category id
     * @return array
     */

    public function deleteParentCategoryAction()
    {
    	//check for login
		$this->chekUserAuthenticationAction();
		
        //get event id
        $id = (int) $this->params()->fromRoute('id',0);
        if($id == 0){
        	return $this->redirect()->toRoute('classified', array(
        			'action' => 'addparentcategory'
        	));
        }
        
        $table = $this->getServiceLocator()->get('Classified\Model\CategoryTable');
        $categories = $table->deleteCategory($id);
        // Redirect to list of category list
        return $this->redirect()->toRoute('classified',array('action'=>'listparentcategory'));
        
    }
    
    /**
     * List all the parent category
     * @return \Zend\View\Model\ViewModel
     */
    public function listParentCategoryAction()
    {

    	//check for login
		$this->chekUserAuthenticationAction();
   	
    	$request = $this->getRequest();
    	$order_by = $this->params()->fromQuery('order_by') ? $this>params()->fromQuery('order_by') : 'id';
    	$order    = $this->params()->fromQuery('order')    ? $this>params()->fromQuery('order') : Select::ORDER_ASCENDING;
    	// grab the paginator from the SubCategoryTable
    	
    	$table = $this->getServiceLocator()->get('Classified\Model\CategoryTable');
    	
    	$categories = $table->getCategory(true, $order_by, $order);
    	// set the current page to what has been passed in query string, or to 1 if none set
    	$pageCount = 5;
    	$categories->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1))->setItemCountPerPage($pageCount);
    	return new ViewModel(array('order' =>$order, 'order_by' => $order_by, 'request'=>$request, 'title'=>'Parent Category','categories' => $categories,));

    }
    
    /**
     * Child category list
     * @param none
     * @return array
     */
    public function childCategoryAction()
    {
    	 //check for login
    	 $this->chekUserAuthenticationAction();
    	 $request = $this->getRequest();
    	 $order_by = $this->params()->fromQuery('order_by') ? $this->params()->fromQuery('order_by') : 'id';
    	 $order    = $this->params()->fromQuery('order')    ? $this->params()->fromQuery('order') : Select::ORDER_ASCENDING;
    	 // grab the paginator from the SubCategoryTable
    	 $paginator = $this->getSubCategoryTable()->fetchAll(true, $order_by, $order);
    	 // set the current page to what has been passed in query string, or to 1 if none set
    	 $pageCount = 5;
    	 $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1))->setItemCountPerPage($pageCount);
    	 return new ViewModel(array('order' =>$order, 'order_by' => $order_by, 'request'=>$request, 'title'=>'Child Category','child_categories' => $paginator,));
    }
    
    /**
     * add child category
     */
    public function addChildCategoryAction()
    {
    	//check for login
    	$this->chekUserAuthenticationAction();
		$form = new ChildCategoryForm();
        $form->get('submit')->setValue('add sub category');
        $category_array = $this->category();
        $form->get('parent_id')->setAttribute('options', $category_array);
        $request = $this->getRequest(); echo "<pre>"; print_r($request->getPost()); exit;
        if ($request->isPost()) { //checking a request is a post request.
            $subcategory = new SubCategory();
            $form->setInputFilter($subcategory->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $subcategory->exchangeArray($form->getData());
                $this->getSubCategoryTable()->saveSubCategory($subcategory);
                // Redirect to list of properties
                return $this->redirect()->toRoute('classified', array('action'=>'childcategory'));
            } else {
            	return $this->redirect()->toRoute('classified', array('action'=>'addchildcategory'));
            }
        }
        return array('form' => $form);
    }
    
    /**
     * edit child category
     * @params int id
     * @return array
     */
    public function editChildCategoryAction()
    {   
    	//check for login
    	$this->chekUserAuthenticationAction();
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('classified', array(
    				'action' => 'addchildcategory'
    				));
    	}
    	
    	// if it cannot be found, in which case go to the index page.
    	try {
    	  $subcategory = $this->getSubCategoryTable()->getSubCategory($id);
    	}
    	catch (Exception $ex) {
	    	return $this->redirect()->toRoute('classified', array(
	    			'action' => 'childcategory'
	    	));
    	}
    	
    	$form = new ChildCategoryForm();
    	$form->bind($subcategory);
    	$form->get('submit')->setAttribute('value', 'Edit');
		$category_array = $this->category();
    	$form->get('parent_id')->setAttribute('options', $category_array);
    	$request = $this->getRequest();
    	if ($request->isPost()) {
	    	$form->setInputFilter($subcategory->getInputFilter());
	    	$form->setData($request->getPost());
	    	if ($form->isValid()) {
		    	$this->getSubCategoryTable()->saveSubCategory($subcategory);
		    	return $this->redirect()->toRoute('classified', array('action'=>'childcategory'));
	    	}
    	}
    	
    	return array(
    			'category_id' => $id,
    			'form' => $form,
    	); 
    }

    /**
     * Delete the child category
     * @param subcategory id
     * @return array
     */
    public function deleteChildCategoryAction()
    {
    	//check for login
    	$this->chekUserAuthenticationAction();
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('classified', array(
    				'action' => 'childcategory'
    		));
    	}
    	$this->getSubCategoryTable()->deleteSubCategory($id);
    	return $this->redirect()->toRoute('classified', array('action'=>'childcategory'));
    }
    
    /**
     * Finding the categories.
     */
    private function category()
    {
    	$category = $this->getSubCategoryTable()->fetchAllParentCatergory();
    	return $category;
    }
    
    /**
     * checking  the user authenitication and if a user is guest then redirect it on posts lists
     */
    private function chekUserAuthenticationAction()
    {
    	//check for login
    	if (!$this->zfcUserAuthentication()->hasIdentity()) {
    		return $this->redirect()->toRoute(static::ROUTE_LOGIN);
    	} else {
    		//check for guest user login
    		if ($this->zfcUserAuthentication()->getIdentity()->getType() === static::GUEST_LOGIN)
    			return $this->redirect()->toRoute(static::GUEST_LOGIN_REDIRECT);    		
    	}
    }
	
	    /**
     * List the post
     * @param void
     * @return array
     */
    public function listPostAction()
    {
    	
    	//check for login
    	$this->chekUserAuthenticationAction();
    	
    	$request = $this->getRequest();
    	$order_by = $this->params()->fromQuery('order_by') ? $this>params()->fromQuery('order_by') : 'id';
    	$order    = $this->params()->fromQuery('order')    ? $this>params()->fromQuery('order') : Select::ORDER_ASCENDING;
    	
    	//get model instance
    	$table = $this->getServiceLocator()->get('Classified\Model\PostTable');
    	
    	$posts = $table->getAllPost(true, $order_by, $order);
    	// set the current page to what has been passed in query string, or to 1 if none set
    	$pageCount = 5;
    	$posts->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1))->setItemCountPerPage($pageCount);
    	return new ViewModel(array('order' =>$order, 'order_by' => $order_by, 'request'=>$request, 'title'=>'Ads','posts' => $posts,));
    }
    
    /**
     * Add the new post
     * @param void
     * @return \Zend\View\Model\ViewModel
     */
    public function addPostAction()
    {
    	
    	//check for login
    	$this->chekUserAuthenticationAction();
    	//get login user id
    	$user_id  = $this->zfcUserAuthentication()->getIdentity()->getId();
    	
    	$form = new PostForm();
    	
    	//get model instance
    	$table = $this->getServiceLocator()->get('Classified\Model\PostTable');
    	
    	//get all category
    	$cats = $table->getAllCategory();
    	$form->get('category_id')->setAttribute('options', $cats);
    	
    	//get all child category
    	$subcats = $table->getAllChildCategory();
    	$form->get('sub_category_id')->setAttribute('options', $subcats);
    	
    	//$form->getElement('user_group_id')->clearValidators();
    	//check if form is subitted
    	$request = $this->getRequest();
    	$request->getPost()->set('user_id', $user_id);
    	if ($request->isPost()) {
    		//get post object
    		$post = new Post();
    		$form->setInputFilter($post->getInputFilter());
    		$form->setData($request->getPost());
             
    		if ($form->isValid()) {
    			$post->exchangeArray($form->getData());
    			$post = $table->savePost($form->getData());
    	
    			// Redirect to list of category list
    			return $this->redirect()->toRoute('classified',array('action'=>'listpost'));
    		}
    	}
    	return new ViewModel(array('form' => $form));
    }
    
    /**
     * get child category for ajax call
     * @return string
     */
    public function getChildCategoryAction()
    {
    	$request = $this->getRequest();
    	$post = $request->getPost();
    	
    	$simple_array = $post->toArray();
    	$id = $simple_array['id'];
    	
    	//get child category
    	$table = $this->getServiceLocator()->get('Classified\Model\PostTable');
    	
    	//get all category
    	$cats = $table->getChildCategory($id);
    	$str = "";
    	//create option field
    	foreach($cats as $key => $value){
    		$str .="<option value=".$key.">".$value."</option>";
    	}
    	echo $str;
    	exit;
    }
    
    
    /**
     * get selected child category for ajax call
     * @return string
     */
    public function getSelectedChildCategoryAction()
    {
    	$request = $this->getRequest();
    	$post = $request->getPost();
    
    	$simple_array = $post->toArray();
    	$cat_id = $simple_array['cat_id'];
    	$post_id = $simple_array['post_id'];
    
    	//get child category
    	$table = $this->getServiceLocator()->get('Classified\Model\PostTable');
    
    	//get all category
    	$cats = $table->getChildCategory($cat_id);
    	
    	//get post subcategory
        $post_cat_id = $table->getPostSubCategory($post_id);
    	$str = "";
    	$selected="";
    	//create option field
    	foreach($cats as $key => $value){
    		$selected="";
    		if($post_cat_id == $key)
    			$selected = "selected = 'selected'";
    		$str .="<option value=".$key." $selected>".$value."</option>";
    	}
    	echo $str;
    	exit;
    }
    
    /**
     * edit the post
     * @patam int $int
     * @teurn array
     */
    public function editPostAction()
    {
    	//check for login
    	$this->chekUserAuthenticationAction();
    	
    
    	//get login user id
    	$user_id  = $this->zfcUserAuthentication()->getIdentity()->getId();
    	//get category id
    	$id = (int) $this->params()->fromRoute('id', 0);
    	
    	//check if id is null
    	if (!$id) {
    		return $this->redirect()->toRoute('classified', array(
    				'action' => 'addpost'
    		));
    	}
    	$table = $this->getServiceLocator()->get('Classified\Model\PostTable');
    	$posts = $table->getSinglePost($id);
    	
    	$form  = new PostForm();
    	$form->bind($posts);
    	$form->get('submit')->setAttribute('value', 'Edit');
    	
    	//get all category
    	$cats = $table->getAllCategory();
    	$form->get('category_id')->setAttribute('options', $cats);
    	
    	//get all child category
    	$subcats = $table->getAllChildCategory();
    	$form->get('sub_category_id')->setAttribute('options', $subcats);
    	
    	$request = $this->getRequest();
    	$request->getPost()->set('user_id', $user_id);
    	if ($request->isPost()) {
    		//get category object
    		$category = new Category();
    		$form->setInputFilter($category->getInputFilter());
    		$form->setData($request->getPost());
    	
    		if ($form->isValid()) {
    			$categories = $table->saveCategory($form->getData());
    	
    			// Redirect to list of category list
    			return $this->redirect()->toRoute('classified',array('action'=>'listparentcategory'));
    		}
    	}
    	
    	return array(
    			'id' => $id,
    			'form' => $form,
    	);
    }
    
    /**
     * delete the post from db
     * @param int $id
     * @return void
     */
    public function deletePostAction()
    {
    	//check for login
    	$this->chekUserAuthenticationAction();
    	
    	//get event id
    	$id = (int) $this->params()->fromRoute('id',0);
    	if($id == 0){
    		return $this->redirect()->toRoute('classified', array(
    				'action' => 'addpost'
    		));
    	}
    	
    	$table = $this->getServiceLocator()->get('Classified\Model\PostTable');
    	$categories = $table->deletePost($id);
    	// Redirect to list of category list
    	return $this->redirect()->toRoute('classified',array('action'=>'listpost'));
    }
    
    /**
     * uploading the post image data
     * $params posts data(file+data)
     * @return \Zend\Http\Response
     */
    public function uploadFormAction()
    { 
    	//check for login
    	$this->chekUserAuthenticationAction();
    	$form = new UploadForm('upload-form');
    	//getting post id from route
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		
    	}
    	$request = $this->getRequest();
    	//get model instance
    	$table = $this->getServiceLocator()->get('Classified\Model\PostImageTable');
    	if ($request->isPost()) {
    		// Make certain to merge the files info!
    		$post = array_merge_recursive(
    				$request->getPost()->toArray(),
    				$request->getFiles()->toArray()
    		);
    		//rename file name
    		$newFileName = time().$post['image-file']['name'];
			$pathName = static::ORIGINAL_IMAGE.$newFileName;
			$path          = dirname(__DIR__).static::ORIGINAL_IMAGE.$newFileName;
			$original_path = dirname(__DIR__).static::ORIGINAL_IMAGE;
			$standard_path = dirname(__DIR__).static::STANDARD_IMAGE;
			$thumb_path    = dirname(__DIR__).static::THUMB_IMAGE;
						
			$thumb_size 	= static::THUMB_SIZE;
			$standard_size 	= static::STANDARD_SIZE;
    		$form->setData($post);
    		// Form is valid, save the form!
    		if ($form->isValid()) {
    			$data = $form->getData();
    			$uploadObj = new \Zend\File\Transfer\Adapter\Http();
    			$uploadObj->addValidator('Count', false, 1)
    					  ->addValidator('Size', false, static::IMAGE_SIZE)
    					  ->addValidator('Extension', false, array('jpg', 'jpeg', 'png', 'gif'));
    			$uploadObj->addFilter('Rename',
    					array('target' => $path,
    							'overwrite' => true));
    			
    			//check for the valid image by above defined validators.
    			//@TODO we will give message for not uploading case(failed validation)
    			if (!$uploadObj->isValid()) {
    				return $this->redirect()->toRoute('classified', array('action'=>'uploadform', 'id'=>$id));
    			}
    			
    			try
    			{
    				// upload received file(s)
    				$uploadObj->receive();
    				//creating the thumb
    				$this->createThumbnailAction($newFileName, $thumb_size, $original_path, $thumb_path);
    				//standard thumb
    				$this->createThumbnailAction($newFileName, $standard_size, $original_path, $standard_path);
    				//make a new array for saving the data for image.
    				$data = array();
    				$data['id']      = null;
    				$data['post_id'] = $id;
    				$data['user_id'] = $this->zfcUserAuthentication()->getIdentity()->getId();
    				$data['image']   = $newFileName;
    				$table->addImageData($data);
    			}
    			catch (Exception $e)
    			{
    				$e->getMessage();
    				exit;
    			}
    			return $this->redirect()->toRoute('classified', array('action'=>'uploadform', 'id'=>$id));
    		}
    	}
    	$images = $table->getAllImages($id);
    	return array('form' => $form, 'images_data'=> $images, 'post_id'=>$id);
    }

    /**
     * deleting the post image data
     * $params post id
     * @return \Zend\Http\Response
     */
    public function deletePostImageAction()
    {
    	//check for login
    	$this->chekUserAuthenticationAction();
    	//getting post id from route
    	$id = (int) $this->params()->fromRoute('id', 0);
    	//get model instance
    	$table = $this->getServiceLocator()->get('Classified\Model\PostImageTable');
    	//getting the postimage data for processing.
    	$result = $table->getPostImage($id);
    	$post_id = 0;
    	if ($result->id) {
	    	$post_id = $result->post_id;
	    	$table->deleteImageData($id);
	    	$dbName = $result->image;
	    	$original_file = dirname(__DIR__).static::ORIGINAL_IMAGE.$dbName;
	    	$standard_file = dirname(__DIR__).static::STANDARD_IMAGE.$dbName;
	    	$thumb_file    = dirname(__DIR__).static::THUMB_IMAGE.$dbName;
	    	//unlink the file(Original, standarad, thumb)
	    	if (file_exists($original_file))
	    		unlink($original_file);
	    	if (file_exists($standard_file))
	    		unlink($standard_file);
	    	if (file_exists($thumb_file))
	    	    unlink($thumb_file);
    	}
    	return $this->redirect()->toRoute('classified', array('action'=>'uploadform', 'id'=>$post_id));
    }
    
    /**
     * creating the image thumb
     * @param unknown_type $filename
     * @return boolean
     */
    private function createThumbnailAction($filename, $thumb_size, $original_path, $thumb_path)
    {
    	$path_to_thumbs_directory = $thumb_path;
    	$path_to_image_directory = $original_path;
    	$final_width_of_image = $thumb_size;
    	if(preg_match('/[.](jpg)$/', $filename)) {
    		$im = imagecreatefromjpeg($path_to_image_directory . $filename);
    	} else if(preg_match('/[.](JPG)$/', $filename)) {
    		$im = imagecreatefromjpeg($path_to_image_directory . $filename);
    	} else if(preg_match('/[.](JPEG)$/', $filename)) {
    		$im = imagecreatefromjpeg($path_to_image_directory . $filename);
    	} else if (preg_match('/[.](jpeg)$/', $filename)) {
    		$im = imagecreatefromgif($path_to_image_directory . $filename);
    	} else if (preg_match('/[.](gif)$/', $filename)) {
    		$im = imagecreatefromgif($path_to_image_directory . $filename);
    	} else if (preg_match('/[.](GIF)$/', $filename)) {
    		$im = imagecreatefromgif($path_to_image_directory . $filename);
    	} else if (preg_match('/[.](png)$/', $filename)) {
    		$im = imagecreatefrompng($path_to_image_directory . $filename);
    	} else if (preg_match('/[.](PNG)$/', $filename)) {
    		$im = imagecreatefrompng($path_to_image_directory . $filename);
    	}
    	$ox = imagesx($im);
    	$oy = imagesy($im);
    	$nx = $final_width_of_image;
    	$ny = floor($oy * ($final_width_of_image / $ox));
    	$nm = imagecreatetruecolor($nx, $ny);
    	
    	imagesavealpha($nm, true);
    	$trans_colour = imagecolorallocatealpha($nm, 0, 0, 0, 127); //for best quality of thumb image.
    	imagefill($nm, 0, 0, $trans_colour);
    	imagecopyresampled($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);
    	
//    	imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);
    	if(!file_exists($path_to_thumbs_directory)) {
    		if(!mkdir($path_to_thumbs_directory)) {
    			die("There was a problem. Please try again!");
    		}
    	}
    	imagejpeg($nm, $path_to_thumbs_directory.$filename);
		return true;
    }
}