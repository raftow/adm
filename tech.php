<?php
$direct_dir_name = $file_dir_name = dirname(__FILE__);
include("$file_dir_name/adm_start.php");
$objme = AfwSession::getUserConnected();
//if(!$objme) $studentMe = AfwSession::getStudentConnected();
$page_css_file = "content";

$Main_Page = "run_tech.php";
$MODULE = $My_Module = "adm";
$options = [];
// $options["action"] = $_REQUEST["action"];
// $options["dashboard-stats"] = true;
// $options["chart-js"] = true;
AfwMainPage::echoMainPage($My_Module, $Main_Page, $file_dir_name, $options);


