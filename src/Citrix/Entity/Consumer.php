<?php
namespace Citrix\Entity;

/**
 * Consumer Entity
 *
 * Contains all fields for registratns and attendees. Consumer
 * is an entity that merges both registratns and attendees.
 *
 * @uses \Citrix\Entity\EntityAbstract
 * @uses \Citrix\Entity\EntityAware
 *      
 */
class Consumer extends EntityAbstract implements EntityAware
{

  /**
   * Unique identifier, in Citrix World
   * this is called RegistrantKey or AtendeeKey
   * 
   * @var integer
   */
  public $id;

  /**
   * First Name
   * 
   * @var String
   */
  public $firstName;

  /**
   * Last Name
   * 
   * @var String
   */
  public $lastName;

  /**
   * Email Address
   * 
   * @var String
   */
  public $email;

  /**
   * Status of Consumer
   * 
   * @var String
   */
  public $status;

  /**
   * Registration Date
   * 
   * @var \DateTime
   */
  public $registrationDate;

  /**
   * Join U
   * 
   * @var String
   */
  public $joinUrl;

  /**
   * Timezone
   * 
   * @var String
   */
  public $timeZone = 'America/New_York';

  /**
   * Begin here by injecting authentication object.
   *
   * @param $client
   */
  public function __construct($client)
  {
    $this->setClient($client);
  }
  
  /*
   * (non-PHPdoc) @see \Citrix\Entity\EntityAware::populate()
   */
  public function populate()
  {
    $data = $this->getData();
    
    $this->firstName = $data['firstName'];
    $this->lastName = $data['lastName'];
    $this->email = $data['email'];
    
    if (isset($data['registrantKey'])) {
      $this->id = $data['registrantKey'];
    }
    
    if (isset($data['status'])) {
      $this->status = $data['status'];
    }
    if (isset($data['registrationDate'])) {
      $this->registrationDate = $data['registrationDate'];
    }
    if (isset($data['joinUrl'])) {
      $this->joinUrl = $data['joinUrl'];
    }
    if (isset($data['timeZone'])) {
      $this->timeZone = $data['timeZone'];
    }
  }

  /**
   *
   * @return the $email
   */
  public function getEmail()
  {
    return $this->email;
  }

  /**
   *
   * @param String $email          
   */
  public function setEmail($email)
  {
    $this->email = $email;
    
    return $this;
  }

  /**
   *
   * @return the $firstName
   */
  public function getFirstName()
  {
    return $this->firstName;
  }

  /**
   *
   * @param String $firstName          
   */
  public function setFirstName($firstName)
  {
    $this->firstName = $firstName;
    
    return $this;
  }

  /**
   *
   * @return the $id
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   *
   * @param String $id          
   */
  public function setId($id)
  {
    $this->id = $id;
    
    return $this;
  }

  /**
   *
   * @return the $joinUrl
   */
  public function getJoinUrl()
  {
    return $this->joinUrl;
  }

  /**
   *
   * @param String $joinUrl          
   */
  public function setJoinUrl($joinUrl)
  {
    $this->joinUrl = $joinUrl;
    
    return $this;
  }

  /**
   *
   * @return the $lastName
   */
  public function getLastName()
  {
    return $this->lastName;
  }

  /**
   *
   * @param String $lastName          
   */
  public function setLastName($lastName)
  {
    $this->lastName = $lastName;
    
    return $this;
  }

  /**
   *
   * @return the $registrationDate
   */
  public function getRegistrationDate()
  {
    return $this->registrationDate;
  }

  /**
   *
   * @param \DateTime $registrationDate          
   */
  public function setRegistrationDate($registrationDate)
  {
    $this->registrationDate = $registrationDate;
    
    return $this;
  }

  /**
   *
   * @return the $status
   */
  public function getStatus()
  {
    return $this->status;
  }

  /**
   *
   * @param String $status          
   */
  public function setStatus($status)
  {
    $this->status = $status;
    
    return $this;
  }

  /**
   *
   * @return the $timeZone
   */
  public function getTimeZone()
  {
    return $this->timeZone;
  }

  /**
   *
   * @param string $timeZone          
   */
  public function setTimeZone($timeZone)
  {
    $this->timeZone = $timeZone;
    
    return $this;
  }
}

?>