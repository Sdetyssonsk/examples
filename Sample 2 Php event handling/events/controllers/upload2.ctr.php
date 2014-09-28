<?php

//
// Uploader: Check Directory / Set Directory
//

$event = new Event;

$event->find_by_url( $url['item1'] );

if ( !is_dir("uploaded_files/".$url['item1']."/") ) 
	mkdir("uploaded_files/".$url['item1']."/");		
	
//
// Uploader: Check Details Of Organiser's Tickets  / Set Details Of Organiser's Tickets
//

if( isset($_POST['uploader']) )
{
	$maxsize = 22428800; // 2 MB
	
	$logo_file_name = $_FILES['logo_file']['name'];
	$logo_file_size = $_FILES["logo_file"]["size"];
	$logo_file_type = $_FILES['logo_file']['type'];
		
	switch( $logo_file_type ) 
	{
		case "image/png":
			$logo_extension = "png";
			break;
		case "image/jpg":
			$logo_extension = "jpg";
			break;		
		case "image/jpeg":
			$logo_extension = "jpg";
			break;		
	}
		
	if( $logo_file_size >= $maxsize )
		$error['logo_file'] = "Het bestand is te groot";
		
	if( $logo_file_name != "" )
		if($logo_extension != "jpeg" && $logo_extension != "jpg" && $logo_extension != "png")
		   $error['logo_file'] = "Alleen .jpg, .jpeg en .png toegestaan";
		   
	if( $logo_file_name == "" )
		$error['logo_file'] = "Er is niets om te uploaden";
	
	if( $_POST['logo_file_hidden'] == "error" )
		$error['logo_file'] = "Bestandsnaam is te lang";
}

//
// Uploader: Perform Insert / Update
//
	
if( isset($_POST['uploader']) && !isset($error) )
{
	//
	// Uploader : Image & Logo Insert  / Update		 
	//
	
	$logo_target_path = "uploaded_files/".$url['item1']."/".basename("logo.". $logo_extension);
	
	if( $logo_file_name != "" )
	{			
		move_uploaded_file($_FILES['logo_file']['tmp_name'], $logo_target_path);
		
		$event->logo_name = "logo.".$logo_extension;
	}
	
	if( $logo_file_name != "" )
		$event->save();
		
	header("Location: /".SUB."/events/".$url['item1']."");
}
?>