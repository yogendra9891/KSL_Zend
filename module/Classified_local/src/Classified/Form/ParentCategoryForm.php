<?php
namespace Classified\Form;

use Zend\Form\Form;

class ParentCategoryForm extends Form
{
    public function __construct()
    {
        parent::__construct('parentcategory');

        $this->setAttribute('method', 'post');

        
        $this->add(array(
        		'name' => 'id',
        		'type'  => 'hidden',
        		'options' => array('label' => 'Title'),
        		'attributes' => array(
        				'class' => 'input-xxlarge'
        		)
        ));
        
        $this->add(array(
            'name' => 'title',
            'type'  => 'text',
            'options' => array('label' => 'Title',),
        		'attributes' => array(
        				'required' => true
        		)
        ));
        
        $this->add(array(
        		'name' => 'description',
        		'type'  => 'textarea',
        		'options' => array('label' => 'Description',),
        		'attributes' => array(
        				'required' => true
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
    }
}