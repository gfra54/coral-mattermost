<?php

// call the webhook defined in config.ini
function call_webhook($payload) {

	$json_payload = json_encode($payload);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $GLOBALS['config']['webhook']);
	curl_setopt($ch, CURLOPT_POST, true);

	curl_setopt($ch, CURLOPT_POSTFIELDS, $json_payload);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: Content-Type: application/json',
		'Content-Length: ' . strlen($json_payload)
	));

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec($ch);

	curl_close ($ch);

	return true;

}



// convert Slack Markdown to standard Markdown
function md_convert($content) {
	
	$pattern = '/\<([^|]*)\|([^>]*)\>/i';
	$replacement = '[$2]($1)';

	$content = preg_replace($pattern, $replacement, $content);

	return $content;
}

// Add markdown quotes
function md_quote($content) {
	$tab = explode("\n",$content);
	foreach($tab as $k=>$v) {
		$tab[$k] = $v ? '> '.$v : $v;
	}
	return "\n".implode("\n",$tab);
}

// sample data used for testing
function sample_data(){
	return json_decode('{"text":"This comment has been reported on *<https://www.sofoot.com/l-athletic-elimine-le-barca-au-buzzer-479817.html|https://www.sofoot.com/l-athletic-elimine-le-barca-au-buzzer-479817.html>*","attachments":[{"text":"This is not the comment you are looking for.\n","footer":"Authored by *Obi1* | <https://staging.coral.coralproject.net/admin/moderate/comment/74a3a85d-e6de-440f-b1b1-fb304116123d|Go to Moderation> | <https://www.sofoot.com/l-athletic-elimine-le-barca-au-buzzer-479817.html?commentID=74a3a85d-e6de-440f-b1b1-fb304116123d|See Comment>"}]}',true);

}