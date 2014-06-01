<?php
namespace Citrix;

class Citrix extends ServiceAbstract implements CitrixApiAware
{
  private $authorizeUrl = 'https://api.citrixonline.com/oauth/access_token';

  private $apiKey;
  private $accessToken;
  private $organizerKey;
  public function __construct($apiKey)
  {
    $this->setApiKey($apiKey);
  }

  public function auth($username, $password)
  {
    $params = array(
      'grant_type' => 'password',
      'user_id' => $username,
      'password' => $password,
      'client_id' => $this->getApiKey()
    );
    
    $this->setHttpMethod('GET')
         ->setUrl($this->authorizeUrl)
         ->setParams($params)
         ->sendRequest()
         ->processResponse();
    
    return $this;
  }

  /**
   *
   * @return the $apiKey
   */
  public function getApiKey()
  {
    return $this->apiKey;
  }

  /**
   *
   * @param field_type $apiKey          
   */
  public function setApiKey($apiKey)
  {
    $this->apiKey = $apiKey;
    
    return $this;
  }
  
  public function processResponse(){
    $response = $this->getResponse();
var_dump($response);
    if(empty($response)){
      return $this;
    }
    
    if(isset($response['int_err_code'])){
      $this->addError($response['msg']);
      return $this;
    }
    
    $this->setAccessToken($response['access_token']);
    $this->setOrganizerKey($response['organizer_key']);
    return $this;
  }
/**
 * @return the $accessToken
 */
public function getAccessToken()
  {
    return $this->accessToken;
}

/**
 * @param field_type $accessToken
 */
public function setAccessToken($accessToken)
  {
    $this->accessToken = $accessToken;
    
    return $this;
}
/**
 * @return the $authorizeUrl
 */
public function getAuthorizeUrl()
  {
    return $this->authorizeUrl;
}

/**
 * @param string $authorizeUrl
 */
public function setAuthorizeUrl($authorizeUrl)
  {
    $this->authorizeUrl = $authorizeUrl;
    
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



}

?>