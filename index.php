<?php
// coral-mattermost
// a Coral custom integration with Mattermost
// gfra54 - gilles@sopress.net
// ----------------------------
// https://github.com/gfra54/coral-mattermost

include 'lib/main.inc.php';

// if text has been sent
if(isset($coral_data['text'])) {

	// convert Slack Markdown to standard Markdown
	$message = md_convert($coral_data['text']);

	// Transform attached statements to markdown quotes
	foreach($coral_data['attachments'] as $attachment) {
		$message.= md_quote(md_convert($attachment['text']));
		$message.= "\n\n".''.md_convert($attachment['footer']).'';
	}

	// add mention to people
	if($config['mention']) {
		$message.= "\n".$config['mention'];
	}


	// build webhook payload
	$payload = array(
		'username'=> $config['username'],
		'icon_url'=> $config['avatar'],
		'text'=>$message
	);

	if(call_webhook($payload)) {
		header("Content-Type: text/plain");
		echo 'Payload sent to '.$config['webhook'].' :';
		echo json_encode($payload,JSON_PRETTY_PRINT);
	}

}

