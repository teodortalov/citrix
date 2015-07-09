<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';


//authenticate with direct authentication
$client = new \Citrix\Authentication\Direct('CONSUMER_KEY');
$client->auth('USERNAME', 'PASSWORD');

//get upcoming weibnars
$goToWebinar = new \Citrix\GoToWebinar($client);
$webinars = $goToWebinar->getUpcoming();

//get info for a single webinar
/* @var $webinar \Citrix\Entity\Webinar */
$webinar = reset($webinars);

//get registraion/join url
$registrationUrl = $webinar->getRegistrationUrl();

//get more info about a webinar
$webinarInfo = $goToWebinar->getWebinar($webinar->getId());

//get registrants for given webinar
$registrants = $webinar->getRegistrants();

//register a user for a webinar
$data = array('email' => 'teodor@talov.com', 'firstName' => 'Teodor', 'lastName' => 'Talov');
$consumer = new \Citrix\Entity\Consumer($client);
$consumer->setData($data)->populate();

$registration = $webinar->registerConsumer($consumer);

if($registration->hasErrors()){
  throw new \Citrix\Exception\ServiceException($registration->getError());
}

var_dump('You just registered!');

//get past weibnars
$goToWebinar = new \Citrix\GoToWebinar($client);
$webinars = $goToWebinar->getPast();


