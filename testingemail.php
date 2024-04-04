<?php 
session_start();

require 'sendnotification.php';

send_email('test subject', 'test body', 'dntran@g.clemson.edu');

?>