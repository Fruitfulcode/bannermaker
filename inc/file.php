<?php	
global $xml_maccive;

add_action('wp_ajax_banner_open_custom_css', 'banner_open_custom_css');

function banner_open_custom_css() {
	
	
/*	$dom = new DomDocument();
	$dom->loadxml(BANNER_INC."/custom.xml");
	$friends = $dom->getElementsByTagName('class');
	print_r ($dom);
	$dom->save(BANNER_INC."/custom.xml");  
	*/
	
	
/*	$doc = new DOMDocument();
	$doc->load(BANNER_INC."/custom.xml");
	$value = $doc->saveXML();
	print_r ($doc);
	echo $doc->textContent;*/
	
	$xml = simplexml_load_file(BANNER_INC."/custom.xml");
	
	
		foreach ($xml as $val) {
			echo 'name=  '.$val->name;
			echo 'value= '.$val->value;
		}
		
	die();
}

function banner_set_class($out = NULL) {
	foreach($out as $line){
		echo $line;
		
	}
}
/*add_action('wp_ajax_banner_open_custom_css', 'banner_open_custom_css');

function banner_open_custom_css() {
    unset($out);
	$count = 0;
	$fp = fopen(BANNER_INC.'/custom.css', "rt");
	if ($fp)
	{
		while (!feof($fp))
		{
			$temp = fgets($fp, 999);
			$out[$count] = $temp;
			$count++;
		}
	}
	else echo "Sorry!!! The file is not exist.";
	fclose($fp);
	banner_set_class($out);
	die();
}

function banner_set_class($out = NULL) {
	foreach($out as $line){
		echo $line;
		
	}
}*/
?>