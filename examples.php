<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';

use Citrix\Citrix;
use Citrix\GoToWebinar;
use Citrix\Entity\Consumer;

$client = new Citrix('CONSUMER_KEY');
$client->auth('USERNAME', 'PASSWORD');

$goToWebinar = new GoToWebinar($client);
$webinars = $goToWebinar->getUpcoming();

$webinar = reset($webinars);
$webinarInfo = $goToWebinar->getWebinar($webinar->getId());

$registrants = $webinar->getRegistrants();
var_dump($registrants);

$data = array('email' => 'teodor@talov.com', 'firstName' => 'Teodor', 'lastName' => 'Talov');
$consumer = new Consumer($client);
$consumer->setData($data)->populate();

$webinar->registerConsumer($consumer);
