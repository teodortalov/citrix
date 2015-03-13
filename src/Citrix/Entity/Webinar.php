<?php
namespace Citrix\Entity;

use Citrix\GoToWebinar;

/**
 * Webinar Entity
 *
 * Contains all fields for a Webinar. It also provides additional functionality
 * such as registering a user for a webinar
 *
 * @uses \Citrix\Entity\EntityAbstract
 * @uses \Citrix\Entity\EntityAware
 *      
 */
class Webinar extends EntityAbstract implements EntityAware
{

  /**
   * Unique identifier, in Citrix World
   * this is called WebinarKey
   *
   * @var integer
   */
  public $id;

  /**
   * Title/Subject of the webinar
   * 
   * @var String
   */
  public $subject;

  /**
   * Description of the webinar
   * 
   * @var String
   */
  public $description;

  /**
   * Organizer Key, big integer
   * 
   * @var int
   */
  public $organizerKey;

  /**
   * Times when the webinar will be held
   * 
   * @var Array
   */
  public $times = array();

  /**
   * Timezone
   * 
   * @var String
   */
  public $timeZone = 'America/New_York';

  /**
   * Registration/Join URL
   * 
   * @var String
   */
  public $registrationUrl;
  /**
   * List of registrants/attendees for that webinar.
   * 
   * @var \ArrayObject
   */
  public $consumers;

  /**
   * Beging here by injecting an authentication object.
   * 
   * @param \Citrix\Citrix $client          
   */
  public function __construct(\Citrix\Citrix $client)
  {
    $this->setClient($client);
    $this->consumers = new \ArrayObject();
  }
  /*
   * (non-PHPdoc) @see \Citrix\Entity\EntityAware::populate()
   */
  public function populate()
  {
    $data = $this->getData();
    
    $this->id = (string) $data['webinarKey'];
    $this->subject = $data['subject'];
    $this->description = $data['description'];
    $this->organizerKey = $data['organizerKey'];
    $this->times = $data['times'];
    $this->timeZone = $data['timeZone'];
    $this->registrationUrl = isset($data['registrationUrl']) ? $data['registrationUrl'] : null;
    return $this;
  }

  /**
   * Get all people that registered for
   * this webinar.
   * 
   * @return \ArrayObject
   */
  public function getRegistrants()
  {
    $goToWebinar = new GoToWebinar($this->getClient());
    $registrants = $goToWebinar->getRegistrants($this->getId());
    return $registrants;
  }

  /**
   * Register consumer for a webinar
   * 
   * @param \Citrix\Entity\Consumer $consumer
   * @return \Citrix\GoToWebinar
   */
  public function registerConsumer(\Citrix\Entity\Consumer $consumer)
  {
    $goToWebinar = new GoToWebinar($this->getClient());
    $goToWebinar->register($this->getId(), $consumer->toArray());
    
    return $goToWebinar;
  }

  /**
   *
   * @return the $description
   */
  public function getDescription()
  {
    return $this->description;
  }

  /**
   *
   * @param String $description          
   */
  public function setDescription($description)
  {
    $this->description = $description;
    
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
   * @param int $id          
   */
  public function setId($id)
  {
    $this->id = $id;
    
    return $this;
  }

  /**
   *
   * @return the $organizerKey
   */
  public function getOrganizerKey()
  {
    return $this->organizerKey;
  }

  /**
   *
   * @param int $organizerKey          
   */
  public function setOrganizerKey($organizerKey)
  {
    $this->organizerKey = $organizerKey;
    
    return $this;
  }

  /**
   *
   * @return the $subject
   */
  public function getSubject()
  {
    return $this->subject;
  }

  /**
   *
   * @param String $subject          
   */
  public function setSubject($subject)
  {
    $this->subject = $subject;
    
    return $this;
  }

  /**
   *
   * @return the $times
   */
  public function getTimes()
  {
    return $this->times;
  }

  /**
   *
   * @param Array $times          
   */
  public function setTimes($times)
  {
    $this->times = $times;
    
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

  /**
   *
   * @return the $consumers
   */
  public function getConsumers()
  {
    return $this->getRegistrants();
  }

  /**
   *
   * @param \ArrayObject $consumers          
   */
  public function setConsumers($consumers)
  {
    $this->consumers = $consumers;
    
    return $this;
  }
  /**
   * @return the $registrationUrl
   */
  public function getRegistrationUrl()
    {
      return $this->registrationUrl;
  }
  
  /**
   * @param string $registrationUrl
   */
  public function setRegistrationUrl($registrationUrl)
    {
      $this->registrationUrl = $registrationUrl;
      
      return $this;
  }

}