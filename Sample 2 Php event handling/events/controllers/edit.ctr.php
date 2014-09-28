<?php

//
// Edit Event: Check Event Details / Set Event Details
//

$event = new Event;

$event->find_by_url( $url['item1'] );

if( !isset($_POST['event_type']) )
{
	switch( $event->event_type )
	{
		case "sports":
			$set_sports = "selected";
			break;
		case "film":
			$set_film = "selected";	
			break;
		case "theatre":
			$set_theatre = "selected";
			break;
		case "music":
			$set_music = "selected";
			break;
	}
}
else
{
	switch($_POST['event_type'])
	{
		case "sports":
			$set_sports = "selected";
			break;
		case "film":
			$set_film = "selected";	
			break;
		case "theatre":
			$set_theatre = "selected";
			break;
		case "music":
			$set_music = "selected";
			break;
	}
}
		
if( !isset($_POST['event_name']) )
	$set_name = $event->event_name;
else
	$set_name = $_POST['event_name'];
	
if( !isset($_POST['event_url_hash']) )
	$set_url_hash = $event->event_url_hash;
else
	$set_url_hash = $_POST['event_url_hash'];
	
if( !isset($_POST['event_description']) )
	$set_description = $event->event_description;
else
	$set_description = $_POST['event_description'];

if( !isset($_POST['venue']) )
	$set_venue = $event->venue;
else
	$set_venue = $_POST['venue'];

if( !isset($_POST['event_start_date']) )
	$set_start_date = $event->event_start_date;
else
	$set_start_date = $_POST['event_start_date'];

if( !isset($_POST['event_end_date']) )
	$set_end_date = $event->event_end_date;
else
	$set_end_date = $_POST['event_end_date'];

if( !isset($_POST['event_name']) )
{	
	if( $event->featured == "yes" )
		$set_featured = "checked=\"yes\"";
}
else
{
	if( $_POST['featured'] == "yes" )
		$set_featured = "checked=\"yes\"";
}
	
//
// Edit Event: Check Posts / Set Errors
//

if( isset($_POST['event_name']) ) 
{
	if( $_POST['event_name'] == "" )
		$error['event_name'] = "Vul een evenement naam in";

	$events = new Event;
	
	$events->find_all();
	
	if( count($events->items()) > 0 )
	{		
		foreach( $events->items() as $check_event ) 
		{
			if( $check_event->event_url_hash != $url['item1'] )
			{
				if( strtolower($check_event->event_name) == strtolower($_POST['event_name']) ) 
					$error['event_name'] = "Deze naam bestaat al";
					
				if( strtolower($check_event->event_url_hash) == strtolower($_POST['event_url_hash']) ) 
					$error['event_url_hash'] = "Deze url bestaat al";
			}
		}
	}
	
	if( $_POST['event_url_hash'] == "" )
		$error['event_url_hash'] = "Vul een url in";
		
	if( preg_match("/[^a-zA-Z0-9_]/", $_POST['event_url_hash']) || preg_match("/\\s/", $_POST['event_url_hash']) )
		$error['event_url_hash'] = "Symbolen en spaties niet toegestaan";

	if( $_POST['event_start_date'] == "" ) 
		$error['event_start_date'] = "Kies een begindatum";
	
	if( $_POST['event_end_date'] == "" ) 
		$error['event_end_date'] = "Kies een einddatum";

	if( $_POST['venue'] == "" ) 
		$error['venue'] = "Vul een locatie in"; 

	if( $_POST['featured'] == "" )
		$featured = "no";
	else
		$featured = $_POST['featured'];
}		

//
// Edit Event: Perform Update
//
		
if( isset($_POST['event_name']) && !isset($error) )
{		
	$event->event_type = $_POST['event_type'];
	
	$event->event_name = addslashes(htmlentities($_POST['event_name'], ENT_NOQUOTES, "UTF-8"));
	
	$event->event_url_hash = addslashes(htmlentities($_POST['event_url_hash'], ENT_NOQUOTES, "UTF-8"));
	
	$event->event_description = addslashes(htmlentities($_POST['event_description'], ENT_NOQUOTES, "UTF-8"));
	
	$event->venue = addslashes(htmlentities($_POST['venue'], ENT_NOQUOTES, "UTF-8"));
	
	$event->event_start_date = $_POST['event_start_date'];
	
	$event->event_end_date = $_POST['event_end_date'];
	
	$event->featured = $featured;
	
	$event->save();
	
	header("Location: /".SUB."/events/".$event->event_url_hash."");
}
?>