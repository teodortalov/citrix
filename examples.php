<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';

use Citrix\Citrix;
use Citrix\GoToWebinar;

$client = new Citrix('ZOyODCZyVVDHCrMzzcwqOvqXaG5iAmpX');


$goToWebinar = new GoToWebinar($client);
$webinars = $goToWebinar->getUpcoming();

$webinar = reset($webinars);
$webinarInfo = $goToWebinar->getWebinar($webinar->getId());

$registrants = $webinar->getRegistrants();
var_dump($registrants);


