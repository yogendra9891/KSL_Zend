<?php

namespace Classified\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class PostImage implements InputFilterAwareInterface
{
	public $id;
	public $post_id;
	public $user_id;
	public $image;

	public function exchangeArray($data)
	{

		$this->id       = (isset($data['id']))         ? $data['id']     : null;
		$this->post_id  = (isset($data['post_id']))  ? $data['post_id']  : 0;
		$this->user_id  = (isset($data['user_id']))  ? $data['user_id']  : 0;
		$this->image    = (isset($data['image']))      ? $data['image']  : null;
	}
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception("Not used");
	}
	
	public function getInputFilter()
	{

	}
	// Add the following method:
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}