<?php
namespace Citrix;

abstract class ServiceAbstract
{

  private $errors = array();

  private $params = array();

  private $url;
  
  private $response;

  public function sendRequest()
  {
    $ch = curl_init(); // initiate curl
    curl_setopt($ch, CURLOPT_URL, $this->getUrl());
    curl_setopt($ch, CURLOPT_POST, true); // tell curl you want to post something
    curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getParams()); // define what you want to post
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
    $output = curl_exec($ch); // execute
    
    curl_close($ch); // close curl handle
    
    var_dump($output); // show output
  }

  public function hasErrors()
  {
    return empty($this->errors) ? false : true;
  }

  /**
   * Returns the first error
   *
   * @return Ambigous <boolean, array>
   */
  public function getError()
  {
    $error = $this->errors;
    $this->reset();
    return empty($error) ? false : reset($error);
  }

  public function getErrors()
  {
    $error = $this->errors;
    $this->reset();
    return $error;
  }

  public function addError($message)
  {
    $this->errors[] = $message;
    
    return $this;
  }

  public function reset()
  {
    $this->errors = array();
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
   * @param multitype: $params          
   */
  public function setParams($params)
  {
    $this->params = $params;
    
    return $this;
  }

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
   * @param field_type $url          
   */
  public function setUrl($url)
  {
    $this->url = $url;
    
    return $this;
  }
/**
 * @return the $response
 */
public function getResponse()
  {
    return $this->response;
}

/**
 * @param field_type $response
 */
public function setResponse($response)
  {
    $this->response = $response;
    
    return $this;
}

}

?>