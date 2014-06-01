<?php
namespace Citrix;

class Citrix extends ServiceAbstract
{

  public $host = 'api.citrixonline.com';

  public $basePath = '/G2W/rest';

  public $protocol = 'https';

  public $authorize_url = 'https://api.citrixonline.com/oauth/access_token';

  private $apiKey;

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
    $this->setUrl($this->authorize_url)->setParams($params)->sendRequest();
    var_dump($params);
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
}

?>