<?php
namespace Citrix\Entity;

/**
 * Purpose of this interface is to force all 
 * Entities to use one common structure.
 */
interface EntityAware
{
  /**
   * Each entity must implement populate, which 
   * should parse the previously provided $data 
   * into its respective places.
   */
  public function populate();
}