<?php
namespace Citrix;

interface CitrixApiAware
{
  /**
   * Each class that makes calls to 
   * Citrix API should define how to process
   * the response.
   */
  public function processResponse();
}