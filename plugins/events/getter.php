<?php
  #call at top of single event script.

  #will get the param 'id' value from the URL bar
  $single_event_id = $_GET['id'];
  echo $single_event_id;
  #call the entire list of events & store the feed to variable
  $string = file_get_contents("/home/mackeycl/webapps/fhg_wp/events_feed/event_feed.json");
  #store and decode the json object into a PHP assoc_array
  $json_a = json_decode($string, true);
  
  #declare an array variable to store the isolated event
  $single_event = array();
  
  #cycle through the returned results & store the single event
  foreach($json_a as $key){

    foreach($key as $k=>$v){
//      echo $k . " = " . $v . "<br>";
      if($k == 'id'){
        if($v == $single_event_id){
          #compare & store if single_event_id is found in the json posts
          $single_event = $key;
        }
      }
    }
  }
  
  #for testing. See results
  var_dump($single_event);

  #Notes on process
/*
#houses all of the events and relevant information
events.php

#handles the request of "single_event" or "widget_events"
events_handler.php

	if(SINGLE_EVENT){
		#pull the single event based on the PARAM ID
	}

	if(widget_events){
		#dunno :/
	}


events-custom-feed.php DIR:
/home/mackeycl/webapps/pccevents_wp/events-test/_events_resources/event_feed.json

Live feed DIR:
http://foothillgoldline.mackeystaging.com/events_feed/event_feed.json
*/



?>