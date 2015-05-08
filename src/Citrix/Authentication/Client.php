<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 5/8/15
 * Time: 1:23 AM
 */

namespace Citrix\Authentication;

/*
 * Wrapper class for all authentication methods.
 * It could be used for a single point of entry foo authentication functionality.
 */
class Client {

  private $authentication;
  public function __construct($authentication = 'Direct'){

    $this->setAuthentication($authentication);
  }

  public function auth(){
    return $this->getAuthentication()->auth();
  }
  /**
   * @return mixed
   */
  public function getAuthentication()
  {
    return $this->authentication;
  }

  /**
   * @param string $authentication
   */
  public function setAuthentication($authentication)
  {
    $class = '\\Citrix\\Authentication\\' . $authentication;
    $this->authentication = new $class();
    return $this;
  }

}