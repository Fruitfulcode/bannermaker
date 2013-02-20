<?php	
global $xml_maccive;

add_action('wp_ajax_banner_open_custom_css', 'banner_open_custom_css');

function banner_open_custom_css() {

	$xml = simplexml_load_file(BANNER_INC."/custom.xml");
	unset($out);

		foreach ($xml as $val) {
		
			echo '<div class="xml_line"><input class="class_css" type="text" value="'.$val->name.'"/>';
			echo '<textarea class="value_css">'.$val->value.'</textarea><a>delete</a></div>';
			$count ++;
		}
		echo '<a class="action_button" id="custom_css_add">add</a><a class="grey_button" id="custom_css_save" >Save</a>';

	die();
}

add_action('wp_ajax_banner_add_class', 'banner_add_class');

function banner_add_class() {
	$xml = simplexml_load_file(BANNER_INC."/custom.xml");
	unset($out);
	
	$class_v = $xml->addChild('class_v');	
	$class_v->addChild('name', 'New_class');
	$class_v->addChild('value', ' ');
	
	file_put_contents(BANNER_INC."/custom.xml",$xml->asXML());
	echo some;
	
	die();
}

add_action('wp_ajax_banner_save_xml', 'banner_save_xml');

function banner_save_xml() {
	$xml = $_POST["xml_macive"];
	$xml_macive = str_replace('\"','"',$xml);
	$xml_macive = json_decode($xml_macive);
	/*print_r($xml_macive);*/
	$i = 0; 
	$xmlstr = '<?xml version="1.0"?><classes></classes>';	
	$movies = new SimpleXMLElement($xmlstr);	

	foreach ($xml_macive as $line)	{
		$class_v = $movies->addChild('class_v');
		foreach ($line as $key => $value)	{
			if ($key == 'name')  { $class_v->addChild('name',$value); }
			if ($key == 'value') { $class_v->addChild('value',$value); }
		}
	}
	
	file_put_contents(BANNER_INC."/custom.xml",$movies->asXML());
		
	/*$character = $movies->movie[0]->characters->addChild('character');
	$character->addChild('name', 'Mr. Parser');
	$character->addChild('actor', 'John Doe');

	$rating = $movies->movie[0]->addChild('rating', 'PG');
	$rating->addAttribute('type', 'mpaa');

	echo $movies->asXML();*/
	
	die();
	
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