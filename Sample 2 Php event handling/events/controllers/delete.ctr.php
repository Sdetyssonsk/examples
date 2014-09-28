<?

$event = new Event();

$event->find_by_url( $url['item1'] );

if( isset($_POST['confirm']) )
{
	$event->delete();
	
	$sub_dir = "uploaded_files/".$event->event_url_hash."/terms_and_conditions/";
	
	$dir = "uploaded_files/".$event->event_url_hash."/";

	foreach( scandir($sub_dir) as $item ) 
	{
		if ($item == '.' || $item == '..') continue;
			unlink($sub_dir.DIRECTORY_SEPARATOR.$item);
	}
	
	rmdir($sub_dir);
	
	rmdir($dir);
	
	header("Location: /".SUB."/events");
}

?>