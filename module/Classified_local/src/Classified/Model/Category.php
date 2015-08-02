<?php

namespace Classified\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Category implements InputFilterAwareInterface
{
	public $id;
	public $title;
	public $description;
	public $created_date;
	public $modified_date;


	public function exchangeArray($data)
	{

		$this->id     = (isset($data['id']))     ? $data['id']     : null;
		$this->title  = (isset($data['title']))  ? $data['title']  : null;
		$this->description  = (isset($data['description']))  ? $data['description']  : null;
		$this->created_date  = (isset($data['created_date']))  ? $data['created_date']  : null;
		$this->modified_date  = (isset($data['modified_date']))  ? $data['modified_date']  : null;
	}

	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception("Not used");
	}

	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory     = new InputFactory();

			$inputFilter->add($factory->createInput(array(
					'name'     => 'id',
					'required' => true,
					'filters'  => array(
							array('name' => 'Int'),
					),
			)));
			
// 			$inputFilter->add($factory->createInput(array(
// 					'name'     => 'title',
// 					'required' => true,	
// 			)));
			
// 			$inputFilter->add($factory->createInput(array(
// 					'name'     => 'description',
// 					'required' => true,
// 			)));
			
// 			$inputFilter->add($factory->createInput(array(
// 					'name'     => 'start_date',
// 					'required' => true,
// 			)));
			
// 			$inputFilter->add($factory->createInput(array(
// 					'name'     => 'end_date',
// 					'required' => true,
// 			)));
			
			


			$this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}

	// Add the following method:
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}