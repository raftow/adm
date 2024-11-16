<?php
$direct_dir_name = $file_dir_name = dirname(__FILE__);
include("$file_dir_name/adm_start.php");
$objme = AfwSession::getUserConnected();
//if(!$objme) $studentMe = AfwSession::getStudentConnected();
$studentMe = null;
if(!$lang) $lang = "ar";


$Main_Page = "home.php";
$My_Module = "adm";
/*
$cl = "Request";
$currmod="crm";
*/
$studentMe = null;
unset($_POST);
unset($_GET);
$page_css_file = "content";

// AfwRunHelper::simpleError("System under maintenance. contactez RB");
AfwMainPage::echoMainPage($My_Module);