<?php

namespace Classified\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * KslParentCategory
 *
 * @ORM\Table(name="ksl_parent_category")
 * @ORM\Entity
 */
class KslParentCategory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=225, nullable=false)
     */
    public $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    public $description;

    /**
     * @var string
     *
     * @ORM\Column(name="created_date", type="string", length=225, nullable=false)
     */
    public $createdDate;

    /**
     * @var string
     *
     * @ORM\Column(name="modified_date", type="string", length=225, nullable=false)
     */
    public $modifiedDate;
    
    protected $inputFilter;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return KslParentCategory
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return KslParentCategory
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdDate
     *
     * @param string $createdDate
     * @return KslParentCategory
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return string 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set modifiedDate
     *
     * @param string $modifiedDate
     * @return KslParentCategory
     */
    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;

        return $this;
    }

    /**
     * Get modifiedDate
     *
     * @return string 
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }
    
    /**
     * Exchange array - used in ZF2 form
     *
     * @param array $data An array of data
     */
    public function exchangeArray($data)
    {
    	
    	$this->id = (isset($data['id']))? $data['id'] : null;
    	$this->title = (isset($data['title']))? $data['title'] : null;
    	$this->description = (isset($data['description']))? $data['description'] : null;
    	//$this->email = (isset($data['email']))? $data['email'] : null;
    
    }
    
    /**
     * Get an array copy of object
     *
     * @return array
     */
    public function getArrayCopy()
    {
    	return get_object_vars($this);
    }
    
    /**
     * Set input method
     *
     * @param InputFilterInterface $inputFilter
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
    	throw new \Exception("Not used");
    }
    
    /**
     * Get input filter
     *
     * @return InputFilterInterface
     */
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
}
