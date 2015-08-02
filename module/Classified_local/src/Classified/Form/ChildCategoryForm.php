<?php
namespace Classified\Form;

use Zend\Form\Form;

class ChildCategoryForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('childcategory');

        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'title',
            'type'  => 'text',
            'options' => array('label' => 'Title',),
			'attributes' =>  array(
        				'id' => 'title',
        				'required'=> true
        		)
        ));
        $this->add(array(
        		'name' => 'parent_id',
        		'type'  => 'select',
        		'options' => array('label' => 'Parent Category',),
        		'attributes' =>  array(
        				'id' => 'parent_id',
        				'options' => array(

        				),
        		),
        ));
        $this->add(array(
        		'name' => 'description',
        		'type'  => 'textarea',
        		'options' => array('label' => 'Description',),
				'attributes' =>  array(
        				'id' => 'desription',
        				'required'=> true
        )));
        $this->add(array(
        		'name' => 'created_date',
        		'type'  => 'hidden',
        		'options' => array('label' => 'Created date',),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Save',
                'id' => 'submitbutton',
            ),
        ));
    }
}
