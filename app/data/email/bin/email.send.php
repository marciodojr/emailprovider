<?php

include __DIR__ . '/../../../../vendor/autoload.php';

use Tx\Mailer;

date_default_timezone_set('America/Sao_Paulo');
$filename = $argv[1];
$pass = $argv[2];
$json = json_decode(file_get_contents($filename), true);
$txMailler = new Mailer();
$txMailler
	->setServer($json['smtpServer'], $json['smtpPort'], $json['ssl'])
	->setAuth($json['authEmail'], $pass)
	->setFrom(utf8_decode($json['fromName']), $json['fromEmail'])
	->addTo(utf8_decode($json['toName']), $json['toEmail'])
	->setSubject(utf8_decode($json['subject']));
if(isset($json['fakeFromEmail'])) {
	$txMailler->setFakeFrom($json['fakeFromName'], $json['fakeFromEmail']);
}
if ($json['addBcc']) {
	$txMailler->addBcc(utf8_decode($json['bccName']), $json['bccEmail']);
}
$txMailler->setBody(utf8_decode($json['body']));
foreach($json['attachments'] as $attachment) {
	$txMailler->addAttachment($attachment['name'], $attachment['dir']);
}
$result = $txMailler->send();
$json['sent'] = $result;
$jsonData = json_encode($json, JSON_PRETTY_PRINT);
$fileHandler = fopen($filename, 'w');
fprintf($fileHandler, $jsonData);
fclose($fileHandler);
