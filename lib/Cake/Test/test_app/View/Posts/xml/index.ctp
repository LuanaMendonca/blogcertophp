<?php
$data = array('Users' => array('user' => array()));
foreach ($users as $user) {
	$data['Users']['user'][] = array('@' => $user['User']['username']);
}
echo Xml::fromArray($data)->saveXml();
