<?php
namespace Classified\Form;

use Zend\Form\Form;

class PostForm extends Form
{
    public function __construct()
    {
        parent::__construct('post');

        $this->setAttribute('method', 'post');

        
        $this->add(array(
        		'name' => 'id',
        		'type'  => 'hidden',
        		'options' => array('label' => 'Title'),
        		'attributes' => array(
        				'id' =>'postid',
        				'class' => 'input-xxlarge'
        		)
        ));
        
        $this->add(array(
            'name' => 'title',
            'type'  => 'text',
            'options' => array('label' => 'Title',),
        		'attributes' => array(
        				'class' =>'textfield',
        				'required' => true,
        				'size' => '80'
        		)
        ));
        
        $this->add(array(
        		'name' => 'short_description',
        		'type'  => 'textarea',
        		'options' => array('label' => 'Short Description',),
        		'attributes' => array(
        				'required' => true,
        				'cols' => '82'
        		)
        ));
        
        $this->add(array(
        		'name' => 'description',
        		'type'  => 'textarea',
        		'options' => array('label' => 'Description',),
        		'attributes' => array(
        				'required' => true,
        				'cols' => '82'
        		)
        ));
        
        $this->add(array(
        		'name' => 'price',
        		'type'  => 'text',
        		'options' => array('label' => 'Price',),
        		'attributes' => array(
        				'required' => true,
        				'size' => '80'
        		)
        ));
        
        $this->add(array(
        		'name' => 'contact_name',
        		'type'  => 'text',
        		'options' => array('label' => 'Contact Name',),
        		'attributes' => array(
        				'required' => true,
        				'size' => '80'
        		)
        ));
        
        $this->add(array(
        		'name' => 'contact_email',
        		'type'  => 'email',
        		'options' => array('label' => 'Contact Email',),
        		'attributes' => array(
        				'required' => true,
        				'size' => '80'
        		)
        ));
        
        $this->add(array(
        		'name' => 'contact_phone_home',
        		'type'  => 'text',
        		'options' => array('label' => 'Contact Phone (Home)',),
        		'attributes' => array(
        				'required' => true,
        				'size' => '80'
        		)
        ));
        
        $this->add(array(
        		'name' => 'contact_phone_work',
        		'type'  => 'text',
        		'options' => array('label' => 'Contact Phone (Work)',),
        		'attributes' => array(
        				'required' => true,
        				'size' => '80'
        		)
        ));
        
        $this->add(array(
        		'name' => 'contact_phone_cell',
        		'type'  => 'text',
        		'options' => array('label' => 'Contact Phone (Cell)',),
        		'attributes' => array(
        				'required' => true,
        				'size' => '80'
        		)
        ));
        
        $this->add(array(
        		'name' => 'address_1',
        		'type'  => 'textarea',
        		'options' => array('label' => 'Address 1',),
        		'attributes' => array(
        				'required' => true,
        				'cols' => '82'
        		)
        ));
        
        $this->add(array(
        		'name' => 'address_2',
        		'type'  => 'textarea',
        		'options' => array('label' => 'Address 2',),
        		'attributes' => array(
        				'required' => true,
        				'cols' => '82'
        		)
        ));
        
        $this->add(array(
        		'name' => 'city',
        		'type'  => 'text',
        		'options' => array('label' => 'City',),
        		'attributes' => array(
        				'required' => true,
        				'size' => '80'
        		)
        ));
        
        $this->add(array(
        		'name' => 'state',
        		'type'  => 'text',
        		'options' => array('label' => 'State',),
        		'attributes' => array(
        				'required' => true,
        				'size' => '80'
        		)
        ));
        
        $this->add(array(
        		'name' => 'is_featured',
        		'type'  => 'select',
        		'options' => array('label' => 'Is featured',),
        		'attributes' =>  array(
        				'options' => array('1'=>'yes','0'=>'no'),
        				'required' => true
        		),
        ));
        
        $this->add(array(
        		'name' => 'status',
        		'type'  => 'select',
        		'options' => array('label' => 'Status',),
        		'attributes' =>  array(
        				'options' => array('0'=>'pending','1'=>'publish', '2'=>'draft'),
        				'required' => true
        		),
        ));
        
        $this->add(array(
        		'name' => 'zip',
        		'type'  => 'text',
        		'options' => array('label' => 'Zip',),
        		'attributes' => array(
        				'required' => true,
        				'size' => '80'
        		)
        ));
      

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Save',
                'id' => 'submitbutton',
            ),
        ));
        
        $this->add(array(
        		'name' => 'category_id',
        		'type'  => 'select',
        		'options' => array('label' => 'Category',),
        		'attributes' =>  array(
        				'id' => 'parentcat',
        				'options' => array(),
        				'required' => true,
        				'onChange' => 'getChildCategory()'
        		),
        ));
        
        $this->add(array(
        		'name' => 'sub_category_id',
        		'type'  => 'select',
        		'options' => array('label' => 'SubCategory',),
        		'attributes' =>  array(
        				'id' => 'childcat',
        				'options' => array(),
        				'required' => true
        		),
        ));
        
        $this->add(array(
        		'name' => 'user_id',
        		'attributes' => array(
        				'type'  => 'hidden',
        				'value' => ''
        		),
        ));
    }
}