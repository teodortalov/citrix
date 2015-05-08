<?php
namespace Citrix\Entity;

/**
 * Provides common functionality used accross the codebase.
 * @abstract
 *
 */
abstract class EntityAbstract
{

  /**
   * Instance of \Citrix\Citrix 
   * @var \Citrix\Citrix
   */
  protected $client;

  /**
   * Data that is to be passed to parent classes,
   * just getters and setters that's all
   * @var Array
   */
  protected $data;

  /**
   *
   * @return the $client
   */
  protected function getClient()
  {
    return $this->client;
  }

  /**
   *
   * @param $client
   */
  protected function setClient($client)
  {
    $this->client = $client;
    
    return $this;
  }

  /**
   *
   * @return the $data
   */
  public function getData()
  {
    return $this->data;
  }

  /**
   *
   * @param array $data          
   */
  public function setData($data)
  {
    $this->data = $data;
    
    return $this;
  }

  /**
   * Converts class variables to array
   * 
   * @return array
   */
  public function toArray()
  {
    //list of variables to be skipped
    $toUnset = array(
      'client',
      'data'
    );
    $toArray = get_object_vars($this);
    
    foreach ($toUnset as $value) {
      if (isset($toArray[$value])) {
        unset($toArray[$value]);
      }
    }
    
    return $toArray;
  }
}