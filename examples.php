<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';

use Citrix\Citrix;
use Citrix\GoToWebinar;
use Citrix\Entity\Consumer;

//authenticate
$client = new Citrix('ZOyODCZyVVDHCrMzzcwqOvqXaG5iAmpX');
$client->auth('info@charityhowto.com', 'Jda084B0DP');

//get upcoming weibnars
$goToWebinar = new GoToWebinar($client);
$webinars = $goToWebinar->getUpcoming();

//get info for a single webinar
/* @var $webinar Citrix\Enttiy\Webinar */
$webinar = reset($webinars);

//get registraion/join url
$registrationUrl = $webinar->getRegistrationUrl();

//get more info about a webinar
$webinarInfo = $goToWebinar->getWebinar($webinar->getId());

//get registrants for given webinar
$registrants = $webinar->getRegistrants();

//register a user for a webinar
$data = array('email' => 'teodor@talov.com', 'firstName' => 'Teodor', 'lastName' => 'Talov');
$consumer = new Consumer($client);
$consumer->setData($data)->populate();

$registration = $webinar->registerConsumer($consumer);

if($registration->hasErrors()){
//   throw new \Exception($registration->getError());
}

var_dump('You just registered!');
