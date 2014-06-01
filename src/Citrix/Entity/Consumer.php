<?php
namespace Citrix\Entity;

class Consumer extends EntityAbstract implements EntityAware
{
  public $id;
  public $firstName;
  public $lastName;
  public $email;
  public $status;
  public $registrationDate;
  public $joinUrl;
  public $timeZone = 'America/New_York';
  
  public function __construct(\Citrix\Citrix $client){
    $this->setClient($client);
  }
  public function populate(){
    $data = $this->getData();

    $this->firstName =  $data['firstName'];
    $this->lastName =  $data['lastName'];
    $this->email =  $data['email'];
    
    if(isset($data['registrantKey'])){
     $this->id =  $data['registrantKey'];
    }
    
    if(isset($data['status'])){
     $this->status =  $data['status'];
    }
    if(isset($data['registrationDate'])){
     $this->registrationDate =  $data['registrationDate'];
    }
    if(isset($data['joinUrl'])){
     $this->joinUrl =  $data['joinUrl'];
    }
    if(isset($data['timeZone'])){
     $this->timeZone =  $data['timeZone'];
    }
    
  }
/**
 * @return the $email
 */
public function getEmail()
  {
    return $this->email;
}

/**
 * @param field_type $email
 */
public function setEmail($email)
  {
    $this->email = $email;
    
    return $this;
}
/**
 * @return the $firstName
 */
public function getFirstName()
  {
    return $this->firstName;
}

/**
 * @param field_type $firstName
 */
public function setFirstName($firstName)
  {
    $this->firstName = $firstName;
    
    return $this;
}
/**
 * @return the $id
 */
public function getId()
  {
    return $this->id;
}

/**
 * @param field_type $id
 */
public function setId($id)
  {
    $this->id = $id;
    
    return $this;
}
/**
 * @return the $joinUrl
 */
public function getJoinUrl()
  {
    return $this->joinUrl;
}

/**
 * @param field_type $joinUrl
 */
public function setJoinUrl($joinUrl)
  {
    $this->joinUrl = $joinUrl;
    
    return $this;
}
/**
 * @return the $lastName
 */
public function getLastName()
  {
    return $this->lastName;
}

/**
 * @param field_type $lastName
 */
public function setLastName($lastName)
  {
    $this->lastName = $lastName;
    
    return $this;
}
/**
 * @return the $registrationDate
 */
public function getRegistrationDate()
  {
    return $this->registrationDate;
}

/**
 * @param field_type $registrationDate
 */
public function setRegistrationDate($registrationDate)
  {
    $this->registrationDate = $registrationDate;
    
    return $this;
}
/**
 * @return the $status
 */
public function getStatus()
  {
    return $this->status;
}

/**
 * @param field_type $status
 */
public function setStatus($status)
  {
    $this->status = $status;
    
    return $this;
}
/**
 * @return the $timeZone
 */
public function getTimeZone()
  {
    return $this->timeZone;
}

/**
 * @param string $timeZone
 */
public function setTimeZone($timeZone)
  {
    $this->timeZone = $timeZone;
    
    return $this;
}








}

?>