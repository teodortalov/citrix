<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';

use Citrix\Citrix;
use Citrix\GoToWebinar;
use Citrix\Entity\Consumer;

//authenticate
$client = new Citrix('CONSUMER_KEY');
$client->auth('USERNAME', 'PASSWORD');

//get upcoming weibnars
$goToWebinar = new GoToWebinar($client);
$webinars = $goToWebinar->getUpcoming();

//get info for a single webinar
$webinar = reset($webinars);
$webinarInfo = $goToWebinar->getWebinar($webinar->getId());

//get registrants for given webinar
$registrants = $webinar->getRegistrants();
var_dump($registrants);

//register a user for a webinar
$data = array('email' => 'teodor@talov.com', 'firstName' => 'Teodor', 'lastName' => 'Talov');
$consumer = new Consumer($client);
$consumer->setData($data)->populate();

$registration = $webinar->registerConsumer($consumer);

if($registration->hasErrors()){
  throw new \Exception($registration->getError());
}

var_dump('You just registered!');
