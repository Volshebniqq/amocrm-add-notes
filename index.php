<?php
require_once('Upload.php');

$login = 'login@to.crm';
$subdomain = 'your subdomain';
$api_key = 'your api key from account page';

$upload = new Upload($login, $subdomain, $api_key); 

$upload->connect(); // connecting to AmoCRM
$upload->send('11111111111', 'note'); // add note to certain lead

?>