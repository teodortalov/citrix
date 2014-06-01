<?php
namespace Citrix;

class Citrix extends ServiceAbstract implements CitrixApiAware
{

  public $host = 'api.citrixonline.com';

  public $basePath = '/G2W/rest';

  public $protocol = 'https';

  public $authorize_url = 'https://api.citrixonline.com/oauth/access_token';

  private $apiKey;
  private $accessToken;

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
         ->setUrl($this->authorize_url)
         ->setParams($params)
         ->sendRequest()
         ->processResponse();
    
    
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
    $this->setAccessToken($response['access_token']);
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

}

?>