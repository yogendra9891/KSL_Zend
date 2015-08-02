<?php
namespace Classified\Form;

// File: UploadForm.php
use Zend\Form\Element;
use Zend\Form\Form;

class UploadForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        $this->addElements();
    }

    public function addElements()
    {
        // File Input
        $file = new Element\File('image-file');
        $file->setLabel('Post Image Upload')
              ->setAttributes(array('required'=>'true', 'id'=>'image-file'));
        $this->add($file);
    }
}
