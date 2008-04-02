<?php

require_once "ste.class.php";

$view = new SeemsTemplate;
$view->name = "Test";
$view->customer_name = "Hihi";
$view->rows = array("segen", "patrick", "fritz", "seppi", "wurst", "käse");
$view->display("test.php");

?>
