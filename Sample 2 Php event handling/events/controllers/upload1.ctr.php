<?

//
// Uploader: Check Directory / Set Directory
//

$event = new Event;

$event->find_by_url( $url['item1'] );
	
if( !is_dir("uploaded_files/".$event->event_url_hash."") )	
	mkdir("uploaded_files/".$event->event_url_hash."");	
	
//
// Uploader: Check Details Of Organiser's Tickets  / Set Details Of Organiser's Tickets
//

if( isset($_POST['uploader']) )
{
	$maxsize = 22428800; // 2 MB
	
	$terms_file_name = $_FILES['terms_file']['name'];
	$terms_file_size = $_FILES["terms_file"]["size"];
	$terms_file_type = $_FILES['terms_file']['type'];
	
	switch( $terms_file_type ) 
	{
		case "application/msword":
			$terms_extension = "doc";
			break;
		case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
			$terms_extension = "docx";
			break;
		case "application/pdf":
			$terms_extension = "pdf";
			break;		
	}	
	
	if( $terms_file_size >= $maxsize )
		$error['terms_file'] = "Het bestand is te groot";	
	
	if( $terms_file_name != "" )
		if( $terms_extension != "doc" && $terms_extension != "pdf" && $terms_extension != "docx" )
		   $error['terms_file'] = "Alleen .doc, docx en .pdf toegestaan";
		
		   
	if( $terms_file_name == "" )
		$error['terms_file'] = "Er is niets om te uploaden";
}

//
// Uploader: Perform Insert / Update
//
	
if( isset($_POST['uploader']) && !isset($error) )
{
	//
	// Uploader : Terms & Conditions Insert / Update		 
	//
		
	$terms_target_path = "uploaded_files/".$event->event_url_hash."/".basename("terms_event_".$url['item1'].".". $terms_extension);
			
	if( $terms_file_name != "" )			
	{
		move_uploaded_file($_FILES['terms_file']['tmp_name'], $terms_target_path);
		
		$event->terms_conditions_name = "terms_event_".$url['item1'].".".$terms_extension;
		
		$event->save();
	}
	
	header("Location: /".SUB."/events/".$url['item1']."");
}
?>