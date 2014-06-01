<?php
namespace Citrix;

use Citrix\Entity\Webinar;
use Citrix\Entity\Consumer;

class GoToWebinar extends ServiceAbstract implements CitrixApiAware
{

  private $client;

  public function __construct(Citrix $client)
  {
  	$this->setClient($client);
  }

  public function getUpcoming(){
    
    $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/upcomingWebinars';
    $this->setHttpMethod('GET')
         ->setUrl($url)
         ->sendRequest($this->getClient()->getAccessToken())
         ->processResponse();
    
    return $this->getResponse();
  }
  public function getWebinar($webinarKey){
    $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey;
    $this->setHttpMethod('GET')
         ->setUrl($url)
         ->sendRequest($this->getClient()->getAccessToken())
         ->processResponse();

    return $this->getResponse();
  }
  public function getRegistrants($webinarKey){
    
    $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/registrants';
    $this->setHttpMethod('GET')
         ->setUrl($url)
         ->sendRequest($this->getClient()->getAccessToken())
         ->processResponse();
    
    return $this->getResponse();
  }
  
  public function register($webinarKey, $registrantData){

    $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/registrants';
    $this->setHttpMethod('POST')
        ->setUrl($url)
        ->setParams(array('email' => 'teodor@talov.com', 'firstName' => 'Teodor', 'lastName' => 'Talov'))
        ->sendRequest($this->getClient()->getAccessToken())
        ->processResponse();

    return $this->getResponse();
  }
  /**
   *
   * @return the $client
   */
  private function getClient()
  {
    return $this->client;
  }

  /**
   *
   * @param field_type $client          
   */
  private function setClient($client)
  {
    $this->client = $client;
    
    return $this;
  }
  public function processResponse(){
    $response = $this->getResponse();
    
    if(isset($response['int_err_code'])){
      $this->addError($response['msg']);
    }
    
    if(isset($response['description'])){
      $this->addError($response['description']);
    }
    
    $collection = new \ArrayObject(array());
    foreach ($response as $entity){
      if(isset($entity['webinarKey'])){
        $webinar = new Webinar($this->getClient());
        $webinar->setData($entity)->populate();
        $collection->append($webinar);
      }
      
      if(isset($entity['registrantKey'])){
        $webinar = new Consumer($this->getClient());
        $webinar->setData($entity)->populate();
        $collection->append($webinar);
      }
    }
    
    $this->setResponse($collection);
  }
}

?>