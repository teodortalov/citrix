<?php
namespace Citrix\Entity;

use Citrix\GoToWebinar;

class Webinar extends EntityAbstract implements EntityAware
{
  public $id;
  public $subject;
  public $description;
  public $organizerKey;
  public $times = array();
  public $timeZone = 'America/New_York';
  public $consumers;
  
  public function __construct(\Citrix\Citrix $client){
    $this->setClient($client);
    $this->consumers = new \ArrayObject();
  }
  public function populate(){
    $data = $this->getData();
    
    $this->id = $data['webinarKey'];
    $this->subject = $data['subject'];
    $this->description = $data['description'];
    $this->organizerKey = $data['organizerKey'];
    $this->times = $data['times'];
    $this->timeZone = $data['timeZone'];
    return $this;
  }
  public function getRegistrants(){
    $goToWebinar = new GoToWebinar($this->getClient());
    $registrants = $goToWebinar->getRegistrants($this->getId());
    return $registrants;
  }
  public function registerConsumer(\Citrix\Entity\Consumer $consumer){
    $goToWebinar = new GoToWebinar($this->getClient());
    $registrants = $goToWebinar->register($this->getId(), $consumer->toArray());

    return $registrants;
  }
/**
 * @return the $description
 */
public function getDescription()
  {
    return $this->description;
}

/**
 * @param field_type $description
 */
public function setDescription($description)
  {
    $this->description = $description;
    
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
 * @return the $organizerKey
 */
public function getOrganizerKey()
  {
    return $this->organizerKey;
}

/**
 * @param field_type $organizerKey
 */
public function setOrganizerKey($organizerKey)
  {
    $this->organizerKey = $organizerKey;
    
    return $this;
}
/**
 * @return the $subject
 */
public function getSubject()
  {
    return $this->subject;
}

/**
 * @param field_type $subject
 */
public function setSubject($subject)
  {
    $this->subject = $subject;
    
    return $this;
}
/**
 * @return the $times
 */
public function getTimes()
  {
    return $this->times;
}

/**
 * @param multitype: $times
 */
public function setTimes($times)
  {
    $this->times = $times;
    
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
/**
 * @return the $consumers
 */
public function getConsumers()
  {
    return $this->getRegistrants();
}

/**
 * @param \ArrayObject $consumers
 */
public function setConsumers($consumers)
  {
    $this->consumers = $consumers;
    
    return $this;
}







}