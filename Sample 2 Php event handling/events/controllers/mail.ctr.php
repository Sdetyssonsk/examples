<?php

$event = new Event;

$event->find_by_url( $url['item1'] );

if( isset($_POST['mail']) )
{
	if( empty($_POST['mail']) )
		$error['mail'] = "Er is geen bericht ingevuld";
		
	if( strlen($_POST['mail']) < 50 )
		$error['mail'] = "Het bericht moet uit minimaal 50 letters bestaan";	
		
	if( empty($_POST['subject']) )
		$error['subject'] = "Er is geen onderwerp ingevuld";	
		
	if( strlen($_POST['subject']) < 10 )
		$error['subject'] = "Het onderwerp moet uit minimaal 10 letters bestaan";
		
	if( !isset($error) )
	{
		$content = addslashes(htmlentities($_POST['mail'], ENT_NOQUOTES, "UTF-8"));
		
		foreach( $event->find_tickets()->items() as $ticket )
		{		
			foreach( $ticket->find_orders()->items() as $order )
			{
				foreach( $order->find_payment_for_mail( $_POST['receivers'] )->items() as $payment )
				{	
					// var_dump( $payment->find_user_info() );

					if( $event->send_event_mail( $content, $payment, $_POST['subject'] ) )
						$counter++;
				}
			}
		}
		
		$error['success'] = $counter." berichten zijn verstuurd.";
	}
}

?>