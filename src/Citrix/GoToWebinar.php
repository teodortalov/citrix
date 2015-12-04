<?php
namespace Citrix;

use Citrix\Authentication\Authentication;
use Citrix\Entity\Webinar;
use Citrix\Entity\Consumer;

/**
 * Use this to get/post data from/to Citrix.
 * 
 * @uses \Citrix\ServiceAbstract
 * @uses \Citrix\CitrixApiAware
 */
class GoToWebinar extends ServiceAbstract implements CitrixApiAware
{

  /**
   * Authentication Client
   * 
   * @var Citrix
   */
  private $client;

  /**
   * Begin here by passing an authentication class.
   * 
   * @param $client - authentication client
   */
  public function __construct($client)
  {
  	$this->setClient($client);
  }

  /**
   * Get upcoming webinars.
   * 
   * @return \ArrayObject - Processed response
   */
  public function getUpcoming(){
    
    $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/upcomingWebinars';
    $this->setHttpMethod('GET')
         ->setUrl($url)
         ->sendRequest($this->getClient()->getAccessToken())
         ->processResponse();
    
    return $this->getResponse();
  }

  /**
   * Get all webinars.
   *
   * @return \ArrayObject - Processed response
   */
  public function getWebinars(){

    $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars';
    $this->setHttpMethod('GET')
        ->setUrl($url)
        ->sendRequest($this->getClient()->getAccessToken())
        ->processResponse();

    return $this->getResponse();
  }

  /**
   * Get past webinars.
   *
   * @deprecated - Use GoToWebinar::getPast() instead2
   * @return \ArrayObject - Processed response
   */
  public function getPastWebinars(){
    return $this->getPast();
  }

  /**
   * Get all past webinars.
   * @todo - add date range
   * @return \ArrayObject - Processed response
   */
  public function getPast(){
    $since = date(DATE_ISO8601, mktime(0, 0, 0, 7, 1, 2000));
    $until = date(DATE_ISO8601);
    $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/historicalWebinars';

    $this->setHttpMethod('GET')
        ->setParams(['fromTime' => $since, 'toTime' => $until])
         ->setUrl($url)
         ->sendRequest($this->getClient()->getAccessToken())
         ->processResponse();

    return $this->getResponse();
  }

  /**
   * Get info for a single webinar by passing the webinar id or 
   * in Citrix's terms webinarKey.
   * 
   * @param int $webinarKey
   * @return \Citrix\Entity\Webinar
   */
  public function getWebinar($webinarKey){
    $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey;
    $this->setHttpMethod('GET')
         ->setUrl($url)
         ->sendRequest($this->getClient()->getAccessToken())
         ->processResponse(true);

    return $this->getResponse();
  }
  /**
	 * ADDED by jwilson on 2015-12-01
	 */
	public function createWebinar($params) {
		$url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars';
		// print_r($params);
		$this->setHttpMethod('POST')
				->setUrl($url)
				->setParams($params)
				->sendRequest($this->getClient()->getAccessToken());
		//->processResponse();

		return $this->getResponse();
	}
	
  /**
   * Get all registrants for a given webinar.
   * 
   * @param int $webinarKey
   * @return \Citrix\Entity\Consumer
   */
  public function getRegistrants($webinarKey){
    
    $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/registrants';
    $this->setHttpMethod('GET')
         ->setUrl($url)
         ->sendRequest($this->getClient()->getAccessToken())
         ->processResponse();
    
    return $this->getResponse();
  }

  /**
   * Get a single registrant for a given webinar.
   *
   * @param int $webinarKey
   * @param int $registrantKey
   * @return \Citrix\Entity\Consumer
   */
  public function getRegistrant($webinarKey, $registrantKey){

    $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/registrants/'.$registrantKey;
    $this->setHttpMethod('GET')
        ->setUrl($url)
        ->sendRequest($this->getClient()->getAccessToken())
        ->processResponse(true);

    return $this->getResponse();
  }
  /**
   * Get all attendees for a given webinar.
   *
   * @param int $webinarKey
   * @return \Citrix\Entity\Consumer
   */
  public function getAttendees($webinarKey){

    $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/attendees';
    $this->setHttpMethod('GET')
        ->setUrl($url)
        ->sendRequest($this->getClient()->getAccessToken())
        ->processResponse();

    return $this->getResponse();
  }
  
  /**
   * Register user for a webinar
   * 
   * @param int $webinarKey
   * @param array $registrantData - email, firstName, lastName (required)
   * @return \Citrix\GoToWebinar
   */
  public function register($webinarKey, $registrantData){

    $url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $this->getClient()->getOrganizerKey() . '/webinars/' . $webinarKey . '/registrants';
    $this->setHttpMethod('POST')
        ->setUrl($url)
        ->setParams($registrantData)
        ->sendRequest($this->getClient()->getAccessToken())
        ->processResponse();

    return $this;
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
   * @param Citrix $client          
   */
  private function setClient($client)
  {
    $this->client = $client;
    
    return $this;
  }
  /* (non-PHPdoc)
   * @see \Citrix\CitrixApiAware::processResponse()
   */
  /**
   * @param bool $single    If we expect a single entity from the server, make this true.
   *                        Single webinar request wasn't working because it was looping its properties.
   */
  public function processResponse($single = false){
    $response = $this->getResponse();
    $this->reset();

    if(isset($response['int_err_code'])){
      $this->addError($response['msg']);
    }
    
    if(isset($response['description'])){
      $this->addError($response['description']);
    }

    if($single === true) {
      if(isset($response['webinarKey'])){
        $webinar = new Webinar($this->getClient());
        $webinar->setData($response)->populate();
        $this->setResponse($webinar);
      }

      if(isset($response['registrantKey'])){
        $webinar = new Consumer($this->getClient());
        $webinar->setData($response)->populate();
        $this->setResponse($webinar);
      }
    } else {
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
}

?>
