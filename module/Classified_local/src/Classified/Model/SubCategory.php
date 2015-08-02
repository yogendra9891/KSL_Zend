<?php
namespace Classified\Model;

use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import

class SubCategory implements InputFilterAwareInterface
{
	public $id;
	public $title;
	public $parent_id;
	public $description;
	public $created_date;
	public $modified_date;
	protected $inputFilter;                       // <-- Add this variable

	public function exchangeArray($data)
	{
		$this->id             = (isset($data['id']))     ? $data['id']     : null;
		$this->title          = (isset($data['title']))  ? $data['title']  : null;
		$this->parent_id      = (isset($data['parent_id']))  ? $data['parent_id']  : null;
		$this->description    = (isset($data['description'])) ? $data['description'] : null;
		$this->created_date   = (isset($data['created_date'])) ? $data['created_date'] : Date('Y-m-d H:i:s');
		$this->modified_date  = (isset($data['modified_date'])) ? $data['modified_date'] : Date('Y-m-d H:i:s');
	}

	// Add content to this method:
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception("Not used");
	}


	/**
	 * converting object array to associative array
	 */
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
	
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory     = new InputFactory();

			//id validation
			$inputFilter->add($factory->createInput(array(
					'name'     => 'id',
					'required' => true,
					'filters'  => array(
							array('name' => 'Int'),
					),
			)));

			//title validation
			$inputFilter->add($factory->createInput(array(
					'name'     => 'title',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 100,
									),
							),
					),
			)));

			$this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}
}