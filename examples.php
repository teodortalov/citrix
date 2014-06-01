<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';

use Citrix\Citrix;
use Citrix\GoToWebinar;

$client = new Citrix('ZOyODCZyVVDHCrMzzcwqOvqXaG5iAmpX');
$client->auth('support@charityhowto.com', 'kEjjco5uGF');

$goToWebinar = new GoToWebinar($client);
$webinars = $goToWebinar->getUpcoming();
var_dump($webinars); exit;
$webinar = reset($webinars);
$webinarInfo = $goToWebinar->getWebinar($webinar['webinarKey']);

$registrants = $goToWebinar->getRegistrants($webinar['webinarKey']);



