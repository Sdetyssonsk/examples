<?

//
// Add Event & Ticket: Download Terms & Conditions
//
	
if( $url['item1'] == "muziek" || $url['item1'] == "theater" || $url['item1'] == "film" || $url['item1'] == "sport" )
	$fullpath = APP_BASE_URL."/uploaded_files/template_terms_and_conditions/av_".$url['item1'].".docx"; // change the path to fit your websites document structure
else
{
	$event = new Event;
	$event->find_by_url( $url['item1'] );
	
	$fullpath = APP_BASE_URL."/uploaded_files/".$url['item1']."/".$event->terms_conditions_name; // change the path to fit your websites document structure
}
	
$filename = $fullpath;

$test=explode(".", $filename);

if( ini_get('zlib.output_compression') ) // required for IE, otherwise Content-disposition is ignored
	ini_set('zlib.output_compression', 'Off');

$file_extension = strtolower(substr(strrchr($filename,"."),1));

switch( $file_extension )
{
	case "docx": 
		$ctype="application/vnd.openxmlformats-officedocument.wordprocessingml.document";
		break;
	case "doc": 
		$ctype="application/msword";	
		break;
	case "pdf": 
		$ctype="application/pdf";
		break;
	default: 
		$ctype="application/force-download";
		break;
}

header("Pragma: public"); // required
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false); // required for certain browsers
header("Content-Type: $ctype");
header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($filename));
readfile("$filename");
exit();

?>