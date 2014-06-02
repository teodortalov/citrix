<?php
namespace Citrix;

/**
 * Provides common functionality for classes
 * that get/post from/to Citrix APIs.
 *
 * @abstract
 *
 *
 */
abstract class ServiceAbstract
{

  /**
   * List of errors that have occured
   * 
   * @var Array
   */
  private $errors = array();

  /**
   * Params to be passed via POST or GET requests
   * to Citrix APIs
   *
   * @var Array
   */
  private $params = array();

  /**
   * URL to be called
   * 
   * @var String
   */
  private $url;

  /**
   * Response from Citrix API call
   * 
   * @var Array
   */
  private $response;

  /**
   * HTTP METHOD used - POST | GET
   * 
   * @var String
   */
  private $httpMethod = 'POST';

  /**
   * Send API request, but pass the $oauthToken first.
   * 
   * @see \Citrix\Citrix
   *
   * @param string $oauthToken          
   * @return \Citrix\ServiceAbstract
   */
  public function sendRequest($oauthToken = null)
  {
    $url = $this->getUrl();
    $ch = curl_init(); // initiate curl
    
    if ($this->getHttpMethod() == 'POST') {
      curl_setopt($ch, CURLOPT_POST, true); // tell curl you want to post something
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->getParams())); // define what you want to post
    } else {
      $url = $this->getUrl();
      $query = http_build_query($this->getParams());
      $url = $url . '?' . $query;
    }
    
    if (! is_null($oauthToken)) {
      $headers = array(
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: OAuth oauth_token=' . $oauthToken
      );
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
    $output = curl_exec($ch); // execute
    curl_close($ch); // close curl handle
    
    $this->setResponse($output);
    return $this;
  }

  /**
   * Have any errors occurred?
   *
   * @return boolean
   */
  public function hasErrors()
  {
    return empty($this->errors) ? false : true;
  }

  /**
   * Returns the first error
   *
   * @return Ambigous <boolean, String>
   */
  public function getError()
  {
    $error = $this->errors;
    $this->reset();
    return empty($error) ? false : reset($error);
  }

  /**
   * Get all errors
   * 
   * @return Array
   */
  public function getErrors()
  {
    $error = $this->errors;
    $this->reset();
    return $error;
  }

  /**
   * Add a new error
   *
   * @param String $message          
   * @return \Citrix\ServiceAbstract
   */
  public function addError($message)
  {
    $this->errors[] = $message;
    
    return $this;
  }

  /**
   * Empty the list of errors
   *
   * @return \Citrix\ServiceAbstract
   */
  public function reset()
  {
    $this->errors = array();
    
    return $this;
  }

  /**
   *
   * @return the $params
   */
  public function getParams()
  {
    return $this->params;
  }

  /**
   *
   * @param Array $params          
   */
  public function setParams($params)
  {
    $this->params = $params;
    
    return $this;
  }

  /**
   * Add a new param to be passed to API
   *
   * @param String $key          
   * @param String $value          
   * @return \Citrix\ServiceAbstract
   */
  public function addParam($key, $value)
  {
    $this->params[$key] = $value;
    
    return $this;
  }

  /**
   *
   * @return the $url
   */
  public function getUrl()
  {
    return $this->url;
  }

  /**
   *
   * @param String $url          
   */
  public function setUrl($url)
  {
    $this->url = $url;
    
    return $this;
  }

  /**
   * Get the resposne
   * @return the $response
   */
  public function getResponse()
  {
    return $this->response;
  }

  /**
   *
   * @param
   *          Array | String $response
   * @return \Citrix\ServiceAbstract
   */
  public function setResponse($response)
  {
    if (is_object($response)) {
      $this->response = $response;
      return $this;
    }
    
    $this->response = (array) json_decode($response, true);
    return $this;
  }

  /**
   * Get the getHttpMethod
   * @return the $httpMethod
   */
  public function getHttpMethod()
  {
    return $this->httpMethod;
  }

  /**
   * Set the HttpMethod
   * 
   * @param String $httpMethod
   *          - GET | POST
   * @return \Citrix\ServiceAbstract
   */
  public function setHttpMethod($httpMethod)
  {
    $this->httpMethod = $httpMethod;
    
    return $this;
  }
}