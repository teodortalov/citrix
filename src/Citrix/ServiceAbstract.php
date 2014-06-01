<?php
namespace Citrix;

abstract class ServiceAbstract
{

  private $errors = array();

  private $params = array();

  private $url;
  
  private $response;
  
  private $httpMethod = 'POST';

  public function sendRequest($oauthToken = null){
    $url = $this->getUrl();
    $ch = curl_init(); // initiate curl
    
    if($this->getHttpMethod() == 'POST'){
      curl_setopt($ch, CURLOPT_POST, true); // tell curl you want to post something
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->getParams())); // define what you want to post
    }else{
      $url = $this->getUrl();
      $query = http_build_query($this->getParams());
      $url = $url . '?' . $query;
    }
    
    if(!is_null($oauthToken)){
      $headers = array(
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: OAuth oauth_token='.$oauthToken,
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

    if(is_object($response)){
      $this->response = $response;
      return $this;
    }
    
    $this->response = (array) json_decode($response, true);
    return $this;
}
/**
 * @return the $httpMethod
 */
public function getHttpMethod()
  {
    return $this->httpMethod;
}

/**
 * @param string $httpMethod
 */
public function setHttpMethod($httpMethod)
  {
    $this->httpMethod = $httpMethod;
    
    return $this;
}


}

?>