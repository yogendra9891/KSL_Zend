<?php

namespace Classified\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Post implements InputFilterAwareInterface
{
	public $id;
	public $user_id;
	public $category_id;
	public $sub_category_id;
	public $ad_type;
	public $ad_level;
	public $title;
	public $short_description;
	public $description;
	public $price;
	public $contact_name;
	public $contact_email;
	public $contact_phone_home;
	public $contact_phone_work;
	public $contact_phone_cell;
	public $address_1;
	public $address_2;
	public $city;
	public $state;
	public $is_featured;
	public $status;
	public $zip;
	protected $inputFilter;


	public function exchangeArray($data)
	{

		$this->id     = (isset($data['id']))     ? $data['id']     : null;
		$this->user_id  = (isset($data['user_id']))  ? $data['user_id']  : null;
		$this->category_id  = (isset($data['category_id']))  ? $data['category_id']  : null;
		$this->sub_category_id  = (isset($data['sub_category_id']))  ? $data['sub_category_id']  : null;
		$this->ad_type  = (isset($data['ad_type']))  ? $data['ad_type']  : null;
		$this->ad_level  = (isset($data['ad_level']))  ? $data['ad_level']  : null;
		$this->title  = (isset($data['title']))  ? $data['title']  : null;
		$this->short_description  = (isset($data['short_description']))  ? $data['short_description']  : null;
		$this->description  = (isset($data['description']))  ? $data['description']  : null;
		$this->price  = (isset($data['price']))  ? $data['price']  : null;
		$this->contact_name  = (isset($data['contact_name']))  ? $data['contact_name']  : null;
		$this->contact_email  = (isset($data['contact_email']))  ? $data['contact_email']  : null;
		$this->contact_phone_home  = (isset($data['contact_phone_home']))  ? $data['contact_phone_home']  : null;
		$this->contact_phone_work  = (isset($data['contact_phone_work']))  ? $data['contact_phone_work']  : null;
		$this->contact_phone_cell  = (isset($data['contact_phone_cell']))  ? $data['contact_phone_cell']  : null;
		$this->address_1  = (isset($data['address_1']))  ? $data['address_1']  : null;
		$this->address_2  = (isset($data['address_2']))  ? $data['address_2']  : null;
		$this->city  = (isset($data['city']))  ? $data['city']  : null;
		$this->state  = (isset($data['state']))  ? $data['state']  : null;
		$this->is_featured  = (isset($data['is_featured']))  ? $data['is_featured']  : null;
		$this->status  = (isset($data['status']))  ? $data['status']  : null;
		$this->zip  = (isset($data['zip']))  ? $data['zip']  : null;
		//$this->created_date  = (isset($data['created_date']))  ? $data['created_date']  : null;
		//$this->modified_date  = (isset($data['modified_date']))  ? $data['modified_date']  : null;
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