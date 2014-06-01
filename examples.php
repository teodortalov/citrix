<?php

error_reporting(E_ALL);
ini_set('display_errors', 1 );

require_once 'vendor/autoload.php';


use Citrix\Citrix;

$citrix = new Citrix('ZOyODCZyVVDHCrMzzcwqOvqXaG5iAmpX');
$citrix->auth('support@charityhowto.com', 'kEjjco5uGF');