<?php
namespace Citrix\Entity;

class Webinar extends EntityAbstract
{
  public $id;
  public $subject;
  public $description;
  public $organizerKey;
  public $times = array();
  public $timeZone = 'America/New_York';
  
  public function __construct(\Citrix\Citrix $client){
    $this->setClient($client);
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
}