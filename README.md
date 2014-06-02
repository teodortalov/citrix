Citrix API - PHP warpper around GoToWebinar APIs - 2014
======

Install via composer
--

`require "teodortalov/citrix: *"`

Authenticate and Get Going in 15 seconds
--

All you need in order to authenticate with Citrix's API is consumer key, which you can obtain by registering at [Citrix Developer Center][1]. After registering and adding your application, you will be given *Consumer Key*, 
*Consumer Secret*, and *Callback URL*. You need the *Consumer Key* in order for your application to authenticate with Citrix. 

In addition to the *Consumer Key*, you need your *username* and *password*, which is the one that you use to login to say [GoToWebinar.com][2].

You can authenticate to Citrix, and your GoToWebinar account respectively, like so:


    $client = new \Citrix\Citrix('CONSUMER_KEY');
    $client->auth('USERNAME', 'PASSWORD'); 


Generally, the things you need the most are the `access_token` and `organizer_key`. You can retrieve those like this:

    $client->getAccessToken() //returns your access token
    $client->getOrganizerKey() //returns the organizer key

The code will handle all the authentication stuff for you, so you don't really have to worry about that. 

Getting upcoming webinars
===

In order to get all the upcoming webinars, you have to do this:

    $goToWebinar = new \Citrix\GoToWebinar($client); //@see $client definition above 
    $webinars = $goToWebinar->getUpcoming();
    var_dump($webinars) //this gives you all upcoming webinars


Register a user for a webinar
====

You can really easily register somebody for a webinar. Basically, all you need to do is this:

    $data = array('email' => 'joe.smith@gmail.com', 'firstName' => 'Joe', 'lastName' => 'Smith');
    $consumer = new \Citrix\Entity\Consumer($client);
    $consumer->setData($data)->populate();
    
    //register a user for the very first upcoming webinar, @see Getting upcoming webinars
    $webinar = reset($webinars)
    $webinar->registerConsumer($consumer);

As mentioned above `$client` you can get from **Authenticate and Get Going in 15 seconds** section, and `$webinar` you can get from  **Getting upcoming webinars** section. 

Alternatively, you can register a user for a webinar by providing the `webinarKey` and the user data directly to the `GoToWebinar` class like so:

    $webinarKey = 123123;
    $registrantData = array('email' => 'joe.smith@gmail.com', 'firstName' => 'Joe', 'lastName' => 'Smith');
    
    $goToWebinar = new \Citrix\GoToWebinar($client); //@see $client definition above
    $goToWebinar->register($webinarKey, $registrantData);

Error handling
====

The code does handle errors but it fails silently. You can check for errors like so:

    $data = array('email' => 'joe.smith@gmail.com', 'firstName' => 'Joe', 'lastName' => 'Smith');
    $consumer = new \Citrix\Entity\Consumer($client);
    $consumer->setData($data)->populate();
    
    //register a user for the very first upcoming webinar, @see Getting upcoming webinars
    $webinar = reset($webinars)
    $registration = $webinar->registerConsumer($consumer);
    
    if($registration->hasErrors()){
       //get the first error that occurred and use it as the exception message
       throw new \Exception($registration->getError());
    }
       
    //no errors, continue...
    die('Registration was successful.');

  [1]: https://developer.citrixonline.com/user/register
  [2]: http://GoToWebinar.com
