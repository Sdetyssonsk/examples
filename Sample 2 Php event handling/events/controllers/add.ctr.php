<?

//	
// Add Event & Ticket: Check Event Posts / Set Event Errors
//

$events = new Event;

$events->find_all();

if( count($events->items()) > 0 )
{
	foreach( $events->items() as $event ) 
	{
		if( strtolower($event->event_name) == strtolower($_POST['event_name']) ) 
			$error['event_name'] = "Deze naam bestaat al";
			
		if( strtolower($event->event_url_hash) == strtolower($_POST['event_url_hash']) ) 
			$error['event_url_hash'] = "Deze url bestaat al";
	}
}

if( isset($_POST['event_type']) )
{	
	if( $_POST['event_type'] == "" )
		$error['event_type'] = "Kies een type evenement";
		
	if( $_POST['featured'] == "" )
		$featured = "no";
	else
		$featured = $_POST['featured'];
		
	if( $_POST['event_name'] == "" )
		$error['event_name'] = "Vul een evenement naam in";
		
	if( $_POST['event_url_hash'] == "" )
		$error['event_url_hash'] = "Vul een url in";
		
	if( preg_match("/[^a-zA-Z0-9_]/", $_POST['event_url_hash']) || preg_match("/\\s/", $_POST['event_url_hash']) )
		$error['event_url_hash'] = "Symbolen en spaties niet toegestaan";
	
	if( $_POST['event_start_date'] == "" )
		$error['event_start_date'] = "Kies een begin datum";	
	
	if( $_POST['event_end_date'] == "" )
		$error['event_end_date'] = "Kies een eind datum";
		
	if( $_POST['event_end_date'] < $_POST['event_start_date'] )
	{
		$error['event_end_date'] = "De eind datum is eerder dan de begin datum";
	}
		
	if( $_POST['venue'] == "" )
		$error['venue'] = "Vul een locatie in";	
}

//
// Add Event & Ticket: Check Ticket Info Posts / Set Ticket Info Errors
//

if( isset($_POST['ticket_type']) )
{
	if( $_POST['ticket_type'] == "" ) 
		$error['ticket_type'] = "Vul een ticket soort in";
	
	if( $_POST['ticket_start_date'] == "" ) 
		$error['ticket_start_date'] = "Kies een begindatum voor het ticket";	
		
	if( $_POST['ticket_end_date'] == "" ) 
		$error['ticket_end_date'] = "Kies een einddatum voor het ticket";
}

//
// Add Event & Ticket: Check Ticket Price Posts / Set Ticket Price Errors
//

if( isset($_POST['ticket_price']) )
{
	if( $_POST['free_ticket'] != "yes" )
	{
		$price = str_replace(",", ".", $_POST['ticket_price']);
		
		if( !is_numeric($price) || $_POST['ticket_price'] == "" ) 
			$error['ticket_price'] = "Vul een ticketprijs in (formaat: 0.00 of 0,00)";
	}

	if( $_POST['availability'] == "" )
		$error['availability'] = "Vul het aantal beschikbare tickets in";
	
	if( $_POST['availability'] < 1 )
		$error['availability'] = "Er moet minstens 1 ticket beschikbaar zijn";
		
	if( preg_match('/[^0-9]/', $_POST['availability']) )
		$error['availability'] = "Dit is geen geldig aantal";

	if( $_POST['max_purchase'] == "" )
		$error['max_purchase'] = "Vul het max aantal tickets per persoon";
		
	if( $_POST['max_purchase'] < 1 )
		$error['max_purchase'] = "Er moet minstens 1 ticket koopbaar zijn";	

	if( preg_match('/[^0-9]/', $_POST['max_purchase']) )
		$error['max_purchase'] = "Dit is geen geldig aantal";	
		
	if( $_POST['max_purchase'] > $_POST['availability'] )
		$error['max_purchase'] = "Kan niet groter zijn dan beschikbare tickets.";
		
	if( $_POST['sale_start_date'] == "" ) 
		$error['sale_start_date'] = "Kies een begindatum voor de verkoop";	
		
	if( $_POST['sale_end_date'] == "" ) 
		$error['sale_end_date'] = "Kies een einddatum voor de verkoop";
}

//
// Add Event & Ticket: Check Layout Posts / Set Layout Errors
//

if( isset($_POST['barcode_loc']) )
{		   	
	if( $_POST['barcode_loc'] == "" ) 
		$error['barcode_loc'] = "Kies een locatie";	
	
	if( $_POST['description_loc'] == "" ) 
		$error['description_loc'] = "Kies een locatie";	
		
	if( $_POST['image_loc'] == "" ) 
		$error['image_loc'] = "Kies een locatie";
			
	if( $_POST['info_loc'] == "" ) 
		$error['info_loc'] = "Kies een locatie";
}

//	
// Add Event & Ticket: Perform Insert	
//

if( isset($_POST['final']) )
{
	if( $_POST['terms_accept'] == "" )
		$error['terms_accept'] = "U bent niet akkoord gegaan met onze voorwaarden.";
}

if( isset($_POST['event_type']) && isset($_POST['ticket_type']) && isset($_POST['ticket_price']) && isset($_POST['barcode_loc']) && isset($_POST['final']) && !isset($error) ) 
{		
	//
	// Add Event & Ticket: Event Insert		
	//
	
	$event = new Event;
	
	$event->event_type = addslashes(htmlentities($_POST['event_type'], ENT_NOQUOTES, "UTF-8"));
	
	$event->event_name = addslashes(htmlentities($_POST['event_name'], ENT_NOQUOTES, "UTF-8"));
	
	$event->event_url_hash = addslashes(htmlentities($_POST['event_url_hash'], ENT_NOQUOTES, "UTF-8"));
	
	$event->event_description = addslashes(htmlentities($_POST['event_description'], ENT_NOQUOTES, "UTF-8"));
	
	$event->featured = addslashes(htmlentities($featured, ENT_NOQUOTES, "UTF-8"));
	
	$event->venue = addslashes(htmlentities($_POST['venue'], ENT_NOQUOTES, "UTF-8"));
	
	$event->event_start_date = $_POST['event_start_date'];
	
	$event->event_end_date = $_POST['event_end_date'];
	
	$event->user_id = $current_user->id();
	
	$inserted_event_id = $event->save();
	
	//	
	// Add Event & Ticket: Ticket Insert  		
	//
	
	$ticket = new Ticket;
	
	$ticket->ticket_type = addslashes(htmlentities($_POST['ticket_type'], ENT_NOQUOTES, "UTF-8"));	
	
	$ticket->ticket_description = addslashes(htmlentities($_POST['ticket_description'], ENT_NOQUOTES, "UTF-8"));
	
	if( $_POST['free_ticket'] != "yes" ) 
		$ticket->ticket_price = addslashes(htmlentities($_POST['ticket_price'], ENT_NOQUOTES, "UTF-8"));
	else 
		$ticket->ticket_price = 0;
		
	$ticket->availability = addslashes(htmlentities($_POST['availability'], ENT_NOQUOTES, "UTF-8"));
	
	$ticket->max_purchase = addslashes(htmlentities($_POST['max_purchase'], ENT_NOQUOTES, "UTF-8"));
	
	$ticket->ticket_start_date = $_POST['ticket_start_date'];
	
	$ticket->ticket_end_date = $_POST['ticket_end_date'];
	
	$ticket->sale_start_date = $_POST['sale_start_date']." ".$_POST['sale_start_hour'].":".$_POST['sale_start_minute'];
	
	$ticket->sale_end_date = $_POST['sale_end_date']." ".$_POST['sale_end_hour'].":".$_POST['sale_end_minute'];
	
	$ticket->event_id = $inserted_event_id[1];
	
	$inserted_ticket_id = $ticket->save();
	
	//
	// Add Event & Ticket & Ticket: Layout Insert  		
	//
	
	$layout = new Layout;	
	
	$layout->barcode_loc = $_POST['barcode_loc'];
	
	$layout->description_loc = $_POST['description_loc'];
	
	$layout->info_loc = $_POST['info_loc'];
	
	$layout->image_loc = $_POST['image_loc'];
	
	$layout->event_ticket_id = $inserted_ticket_id[1];

	$layout->save();
}
	
//
// Add Event & Ticket & Ticket: Javascript On Next Button Click Error Checking  		
//
	
if( isset($_POST['first_name']) || isset($_POST['event_type']) || isset($_POST['ticket_type']) || isset($_POST['ticket_price']) || isset($_POST['barcode_loc']) || isset($_POST['final']) )
{	
	if( isset($error) )
	{
		$error['error'] = true;
		
		echo json_encode($error);
	}
	else
	{
		$error['error'] = false;
		
		if( !empty($event->event_url_hash) )
			$error['event_url'] = $event->event_url_hash;
		
		echo json_encode($error);
	}	
	
	exit;	
}
?>