<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 5/8/15
 * Time: 1:23 AM
 */

namespace Citrix\Authentication;

use Citrix\ServiceAbstract;
use Citrix\CitrixApiAware;

/**
 * Citrix Authentication
 *
 * Use this class to authenticate into Citrix APIs.
 *
 * @uses \Citrix\ServiceAbstract
 * @uses \Citrix\CitrixApiAware
 */

class Direct extends ServiceAbstract implements CitrixApiAware
{

  /**
   * Authentication URL
   * @var String
   */
  private $authorizeUrl = 'https://api.getgo.com/oauth/v2/token';

  /**
   * API key or Secret Key in Citrix's Developer Portal
   * @var String
   */
  private $apiKey;

  /**
   * Access Token
   * @var String
   */
  private $accessToken;

  /**
   * Organizer Key
   * @var int
   */
  private $organizerKey;

  /**
   * Being here bu passing the api key
   *
   * @param String $apiKey
   */
  public function __construct($apiKey = null)
  {
    $this->setApiKey($apiKey);
  }

  /**
   * Authenticate by passing username and password. Those are
   * the same username and password that you use to login to
   * www.gotowebinar.com
   *
   * @param String $username
   * @param String $password
   * @return Direct|\Citrix\Citrix
   */
  public function auth($username, $password)
  {

    if(is_null($this->getApiKey())){
      $this->addError('Direct Authentication requires API key. Please provide API key.');
      return $this;
    }

    if(is_null($username) || is_null($password)){
      $this->addError('Direct Authentication requires username and password. Please provide username and password.');
      return $this;
    }

    $params = array(
      'grant_type' => 'password',
      'user_id' => $username,
      'password' => $password,
      'client_id' => $this->getApiKey()
    );
//TODO add setter and getter for secret key api
      $this->setHttpMethod('POST')
          ->setUrl($this->authorizeUrl)
          ->setParams($params)
          ->sendRequest(null,'Basic '.base64_encode($this->getApiKey().':'.env('CITRIX_CONSUMER_KEY_SECRET')))
          ->processResponse();
      return $this;
  }

    /**
     * @return String $apiKey
     */
  public function getApiKey()
  {
    return $this->apiKey;
  }

    /**
     *
     * @param String $apiKey
     * @return Direct
     */
  public function setApiKey($apiKey)
  {
    $this->apiKey = $apiKey;

    return $this;
  }

  /* (non-PHPdoc)
   * @see \Citrix\CitrixApiAware::processResponse()
   */
  public function processResponse()
  {
    $response = $this->getResponse();

    if (empty($response)) {
      return $this;
    }

    if (isset($response['int_err_code'])) {
      $this->addError($response['msg']);
      return $this;
    }

    $this->setAccessToken($response['access_token']);
    $this->setOrganizerKey($response['organizer_key']);
    return $this;
  }

    /**
     *
     * @return String $accessToken
     */
  public function getAccessToken()
  {
    return $this->accessToken;
  }

    /**
     *
     * @param String $accessToken
     * @return Direct
     */
  public function setAccessToken($accessToken)
  {
    $this->accessToken = $accessToken;

    return $this;
  }

  /**
   *
   * @return String
   */
  public function getAuthorizeUrl()
  {
    return $this->authorizeUrl;
  }

  /**
   *
   * @param string $authorizeUrl
   */
  public function setAuthorizeUrl($authorizeUrl)
  {
    $this->authorizeUrl = $authorizeUrl;

    return $this;
  }

  /**
   *
   * @return string
   */
  public function getOrganizerKey()
  {
    return $this->organizerKey;
  }

    /**
     *
     * @param int $organizerKey
     * @return Direct
     */
  public function setOrganizerKey($organizerKey)
  {
    $this->organizerKey = $organizerKey;

    return $this;
  }
}
